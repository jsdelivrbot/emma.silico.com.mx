<?php

namespace EMMA5\Http\Controllers;

use Helper;
use EMMA5\User;
use EMMA5\Center;
use EMMA5\Board;
use EMMA5\Exam;
use EMMA5\Slot;
use EMMA5\Subject;
use EMMA5\Vignette;
use EMMA5\Question;
use EMMA5\Distractor;
use EMMA5\Image as Img;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use File;
use League\Flysystem\ZipArchive\ZipArchiveAdapter as Adapter;
use League\Csv\Reader;
use Excel;
use Carbon;
use Faker\Factory as Faker;
use Comodojo\Zip\Zip as Zip;
use Comodojo\Exception\ZipException as ZipException;
use Debugbar;
use Stringy as S;
use Log;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*Methods for exams*/
    public function exam_prepare()
    {
        $boards = Board::pluck('name', 'id');
        return view('management.exams.csv_exam_form', compact('boards'));
    }


    public function exam_regex_clean($path)
    {
        try {
            //File::get(storage_path($path));
            // $path = storage_path($pathToFile);
            //$contents = File::get($file);
            $reader = Reader::createFromPath($path);
            $reader->setDelimiter('\n');
            //$file->setOffset(0);
            //$file = fopen($path, "a+");
        } catch (\Exception $e) {
            $message = 'No puedo abrir el flujo de datos '.$path;
            flash($message, 'danger')->important();
            return back()->withInput();
        }

        //Read each line and make the proper regex to clean
        //
        $results = $reader->fetch();
        $outputText = "";
        dd($results);
        foreach ($results as $row) {
            $row[0] = preg_replace('/^ */', '', $row[0]);
            /*Encuentra los espacios al pricipio de la línea y los remueve*/
            $row[0] = preg_replace('/^ */', '', $row[0]);
            /*Encuentra los espacios al final de la línea y los remueve;*/
            $row[0] = preg_replace('/ *$/', '', $row[0]);
            // $row[0] = preg_replace('/\W*$/,','');
            // $row[0] = preg_replace('/^\W*/,' '');
            #Encuentra los espacios y tabuladores redundantes;
            $row[0] = preg_replace('/ {2,}/', ' ', $row[0]);
            $row[0] = preg_replace('/\t{2,}/', ' ', $row[0]);
            $row[0] = preg_replace('/\r\n/', PHP_EOL, $row[0]);
            $row[0] = preg_replace('/\r/', PHP_EOL, $row[0]);
            #Encuentra los saltos de línea redundantes; (\r|\n|\r\n)
            $row[0] = preg_replace('/\n{2,}/', "\n", $row[0]);
            #Encuentra ocurrencias de compuestos consubíndices químicos i.e. O2 y los;
            #convierte a la forma O<sub>2</sub> ((?<foo1>([A-Z])) encuentra la letra;
            #mayúscula de la fórmula química y la asigna a foo1 #((?<foo2>(\d)))) encuentra la parte entera y; la asigna a foo2
            $row[0] = preg_replace('/((?<foo1>([A-Z]))((?<foo2>(\d))))/','\k<foo1><sub>\k<foo2></sub>', $row[0] );
            #Encuentra ocurrencias de mm en volúmenes de líquido y añade al subíndice;
            $row[0] = preg_replace('/(?<foo1>(mm))(?<foo2>(\d))/,', '\k<foo1><sup>\k<foo2></sup>', $row[0]);
            #Encuentra la falta de salto de línea entre la última respuesta (correcta) y #el tema de la; siguiente
            $row[0] = preg_replace('/(?<foo1>(^[A-E]))(?<foo2>([A-Z]))(?<foo3>([a-z])){1,1}/', "\\k<foo1>\n\\k<foo2>\\k<foo3>", $row[0]);
            $row[0] = preg_replace('/$/', "|", $row[0]);
            $outputText .= $row[0];
        }
        File::put($path, $outputText);
        return $path;
    }
    public function exam_csv(Request $request)
    {
        ini_set('max_execution_time', '180');
        $this->validate($request, [
            'exam_csv' => 'required|mimes:csv,dat,txt|max:2048',
            'board_id' => 'required',
            'applicated_at' => 'required',
        ]);
        $examCsvName = $request->applicated_at.'_'.$request->board_id.'.'.$request->exam_csv->getClientOriginalExtension();
        $path = storage_path('app/public/'.$request->board_id);
        // $path = public_path('tmp/'.$request->board_id);
        try {
            if ($request->file('exam_csv')->isValid()) {
                $newPath = $request->file('exam_csv');
                $reader = Reader::createFromPath($this->exam_regex_clean($newPath));
                $reader->setDelimiter('|');
            }
        } catch (\Exception $e) {
            $message = 'Revise su archivo. No tiene una estructura valida';
            flash($message, 'danger')->important();
            return back()->withInput();
        }

        $request->exam_csv->move($path, $examCsvName);

        //$newPath = $path.'/'.$examCsvName;



        $vignetteHas = 0;
        $slotsNumber = $request->slots_number;
        $questionsNumber = $request->questions_number;
        $distractorsNumber = $request->distractors_number;
        $applicatedAt = Carbon::parse($request->applicated_at);
        $duration = $request->duration;
        $vignetteHas = $request->vignetteHas; //TODO must come from th Form
        $subjectHas = 1; //TODO must come from the Form
        $subtopicHas = 1; //TODO must come from the Form
        $correctHas = 1; //TODO must come from the Form

        $offset =   $subjectHas +
            $subtopicHas +
            //$vignetteHas +
            1 +
            $questionsNumber +
            ($questionsNumber * ($distractorsNumber+$correctHas)) ;
        /*if ($vignetteHas == 0){
            $offset += 2;
        }*/

        //return $offset;
        //Create exam
        $exam = Exam::create(
                [
                        'board_id' => $request->board_id,
                        'applicated_at' => $applicatedAt,
                        'duration' => $duration,
                        'annotation' => $request->annotation
                ]
        );
        //$exam->active = 1;
        //$exam->annotation = "";

        // Create vignette
        $vignetteOrder = 2;
        $vignetteInstructions = "Responda las siguientes preguntas";

        //Questions options
        if ($vignetteHas == 0) {
            $questionsOrder = 1;
        } else {
            $questionsOrder = 2;
        }

        //Distractor options
        if ($vignetteHas == 0) {
            $distractorsOrder = 2;
        } else {
            $distractorsOrder = 3;
        }

        //Create reader
        $reader = Reader::createFromPath($path.'/'.$examCsvName);
        $reader->setDelimiter('|');
        //count the numbers of rows in a CSV
        $nbRows = $reader->each(
                function ($row) {
                    return true;
                }
        );
        try {
            $slotsNumber*$offset == $nbRows;
        } catch (\Exception $e) {
            $message = 'El numero de lineas no coincide con las indicadas por favor revise su archivo';
            flash($message, 'danger')->important();
            $exam->delete();
            return back()->withInput();
        }
        $subject = $subtopic = $vignette= $question = $distractor = $correct = collect();
        $slotInstruccions = "Responda el siguiente caso";
        $results = $reader->fetch();
        $offset = 0;
        for ($slotsCycle = 1; $slotsCycle <= $slotsNumber; $slotsCycle++) {
            $data = $reader->fetchOne($offset);
            $subjectText = $data[0];
            $subject = Subject::firstOrCreate(['text' => $subjectText]);
            /*Vignettes text*/
            $data = $reader->fetchOne($offset + $vignetteOrder);
            //            $vignetteText = $data[0];
            /*Vignette text*/
            //$vignette = Vignette::where('text', $vignetteText)->first();
            //dd($vignette);
            //            if ($vignette != NULL) {
            //                $slotId = $vignette->slot_id;
            //                $slot = Slot::find($slotId);
            //            }
            //            else
            //            {
            //            }
            $slot = Slot::create(['subject_id' => $subject->id, 'order' => $slotsCycle, 'instructions' => $slotInstruccions, 'exam_id' => $exam->id]);



            //Vignette
            $data = $reader->fetchOne($offset + $vignetteOrder);
            $vignetteText = $data[0];
            if ($vignetteHas == 1) {
                $vignette = Vignette::create(['slot_id' => $slot->id,
                                'order' => 1, 'text' => $vignetteText, 'instructions' => $vignetteInstructions]);

                $vignette->save();
            }
            //$slot->vignettes()->save($vignette);

            $exam->slots()->save($slot);

            //Questions
            $questionsOffset = 1;
            $correctOffset = 0;

            for ($questionsCycle = 1; $questionsCycle <= $questionsNumber; $questionsCycle++) {
                $data = $reader->fetchOne($offset + $questionsOrder + $questionsOffset);

                $questionText = $data[0];

                //$question->push(['pos' => $offset + $questionsOrder + $questionsOffset, 'text' => $questionText, 'vignette' => $vignette->text]);
                $question = Question::create(
                                [
                                        'slot_id' => $slot->id,
                                        'order' => ($slotsCycle -1)*($questionsNumber)+$questionsCycle,
                                        'text' => $questionText
                                ]
                        );
                $question->slot_id = $slot->id;
                $question->save();




                //Distractors
                $distractorsOffset = $offset + $distractorsOrder + $questionsOffset;
                for ($distractorsCycle = 0; $distractorsCycle < $distractorsNumber; $distractorsCycle++) {
                    try {
                        $data = $reader->fetchOne($distractorsOffset + $distractorsCycle);
                    } catch (\Exception $e) {
                        return $e;
                    }
                    if ($data != null) {
                        $distractorText = $data[0];
                    }

                    $alphabet = range('A', 'Z');
                    $option = $alphabet[$distractorsCycle];

                    $data = $reader->fetchOne($distractorsOffset + $distractorsNumber);

                    if ($data != null) {
                        $correctOption = $data[0];
                    }
                    try {
                        strlen($data[0]) > 1;
                    } catch (\Exception $exception) {
                        $message = 'Hay un error cerca de la la línea '.($distractorsOffset + $distractorsNumber). 'ó del texto '.$data[0];
                        flash($message, 'danger')->important();
                        $exam->delete();
                        return back()->withInput();
                    }

                    if ($correctOption == $option) {
                        $correct = true;
                    } else {
                        $correct = false;
                    }

                    $distractor = Distractor::create(['question_id' => $question->id, 'option' => $option, 'distractor' => $distractorText,'correct' => $correct ]);
                    //$question->distractors()->save($distractor);

                                //$distractor->push(['QuestionText' => $question->text, 'DistractorText' => $distractorText, 'Position' => $distractorsCycle, 'Option' => $option, 'Correct' => $correctOption, 'correct' => $correct]);
                }

                $questionsOffset += $distractorsNumber + $correctHas +1;
            }



            //Offset set
            $offset +=   $subjectHas +
                        $subtopicHas +
                        $vignetteHas +
                        $questionsNumber +
                        ($questionsNumber * ($distractorsNumber+$correctHas)) ;
        }

        // $exam->push(['slots' => $slot]);
        //$exam->save();
        //return $exam->load('slots.subject', 'slots.vignettes', 'slots.questions', 'slots.questions.distractors');
        //return $distractor;
        //return $question;
        //return $correct->count();
        //dd($exam);
        // return $exam->slots->all();
        return redirect('/exams/'.$exam->id);
        // return view('management.exams.doc_preview_partial', compact('exam'));
    }

    /**
     * Uploads users CSV file
     *
     * Uploads a CSV file with the users name and generates Users with automatic and unique username
     *
     * @param  Request $request
     * @return Response
     */
    public function users_csv(Request $request)
    {
        ini_set('max_execution_time', '180');
        $this->validate(
                $request,
                [
                    'users_csv' => 'required|mimes:txt,csv',
                    'exam_id'   => 'required',
                ]
            );

        $file = $request->file('users_csv');
        $usersCsvName = $request->exam_id.'_'.$request->board_id.'.'.$request->users_csv->getClientOriginalExtension();
        $path = public_path('tmp/users/'.$request->board_id);
        $request->users_csv->move($path, $usersCsvName);


        //Create reader
        $reader = Reader::createFromPath($path . '/' . $usersCsvName);
        $reader->setDelimiter('|');
        $reader->setEnclosure('"');

        //$reader->setOffset(1);//Because we have header

        $exam = Exam::find($request->exam_id);
        $faker = Faker::create();
        $centerCollection = $usersCollection = collect();
        $seatCounter = 0;
        //Use a conditional to see if the file contains a column with the avatar filename
        //in order to create the image/avatar for the given user
        $usersRows = $reader->each(
                function ($row) use ($exam, $request ,$faker, $usersCollection, $centerCollection, $seatCounter) {
                    $boardId = $exam->board_id;
                    $identifier = $row[0];
                    $last_name = $row[1] . " " . $row[2];
                    $name = $row[3];
                    $center = Center::where('name', 'like', '%' . trim($row[4]) . '%')->get()->first();
                    $completion_year = intval($row[5]);
                    $centerCollection->push($completion_year);
                    $user = User::firstOrNew(
                        [
                            //'identifier' => $identifier,
                            'name' => $name,
                            'last_name' => $last_name,
                            'board_id' => $boardId,
                            'completion_year' => $completion_year,
                        ]
                    );
                    $user->identifier = $identifier;
                    $user->board_id = $boardId;
                    $user->completion_year = $completion_year;
                    //$user->seat = $seatCounter;
                    /*Username generator*/
                    $userName = Helper::createAcronym($user->name . " " . $user->last_name);
                    if ($user->username == null) {
                        $user->username = $faker->bothify($userName . $boardId . '####?');
                        if ($user->password == null) {
                            $user->password = $user->username;
                        }
                        $user->email = $user->username . '@' . $boardId . '.local';
                    }

                    if (!empty($center)) {
                        $user->center_id = $center->id;
                    }

                    $usersCollection->push($user);
                    $user->save();

                    $exam->users()->attach($user->id);
                    /**/
                    return true;
                    //return $usersCollection;
                }
            );
        //return $usersCollection;
        $exam = Exam::find($request->exam_id);
        return redirect()->action('AdministrationController@createUsersPdf', ['exam' => $exam]);
    }

    /**
     * Accepts request from user with file upload and vlidates it as a excel
     * file that icludes the name and other user data
     *
     * @return Redirect
     */
    public function usersExcel(Request $request)
    {
        ini_set('max_execution_time', '180');
        $this->validate($request, [
                'users_excel' => 'required|mimeTypes:'.
                'application/vnd.ms-office,'.
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,'.
                'application/vnd.ms-excel',
                'zipFile' => 'sometimes|mimes:zip',
                'exam_id' => 'required',
        ]);
        //Verify zipfile
        if ($request->zipFile) {
            $dir = Helper::unzipUpload($request);
            $imagesDir = Helper::filterImages($dir);
            if (!File::exists(public_path("images/avatars/users/$request->board_id/"))) {
                    $avatarsPath = File::makeDirectory(public_path("images/avatars/users/$request->board_id/"));
            } else {
                    $avatarsPath = public_path("images/avatars/users/$request->board_id/");
            }
            foreach ($imagesDir as  $imageFile){
                $fileName = ''.S::create(pathinfo($imageFile, PATHINFO_FILENAME))->collapseWhitespace()->regexReplace('\W','');
                File::copy($imageFile, $avatarsPath.$fileName);
            }
        } else {
                $imagesDir = "";
                $avatarsPath = "";
                $dir = "";
        }
        //Recursively get al files
        //Compare the filename with the identifier
        //Save user to database
        //Save image to database
        //Move image to avatars folder
        $filePath = $request->file('users_excel');
        $data = Excel::load(
            $filePath,
            function ($reader) {
                //reader methods
                $results = $reader->get();
                //Table heading as attributes
                //first row of the excel file will be used as attributes.
            }
        )->get();
        $users = collect();
        $exam = Exam::find($request->exam_id);
        $users->push($data->map(function ($item) use($request, $imagesDir, $avatarsPath, $dir, $exam){
                $item = $item->toArray();
                $user = new User;
                /* somewhere I read that there is no need for this array conversion */
                foreach ($item as $key => $val) {
                        if (\Schema::hasColumn($user->getTable(), $key)) {
                                $userArray[$key] = $val;
                        }
                }
                        $userFullName = $userArray['name']." ".$userArray['last_name'];
                        $userName = S::create(Helper::createAcronym($userFullName))->padBoth(4, 'X');
                        $faker = Faker::create();
                        $userName = $faker->bothify($userName.'???');
                        $userArray['username'] = $userName;
                        $userArray['password'] = $userName;
                        $userArray['board_id'] = $request->board_id;
                        $userArray['identifier'] = $item['identifier'];
                        $turn = filter_var($item['turn'], FILTER_SANITIZE_NUMBER_INT);
                        //$user->password = $userName;
                        $center =  Center::where('name', $item['center'])->first();
                        if ($center) {
                                $userArray['center_id'] = $center->id;
                        } else {
                                //$user->center_id = null;
                                $userArray['center_id'] = null;
                                // flash($item['center']." no se encuentra en nuestra base de datos", 'danger')->important();
                                Log::info($item['center']." no se encuentra en nuestra base de datos");
                        }
                        //$user->exam_id = $request->exam_id;
                        //$user = User::firstOrCreate(['identifier' => $userArray['identifier'], 'board_id' => $request->board_id, 'name' => $userArray['name'], 'last_name' => $userArray['last_name'] ]);
                        //dd($userArray['identifier']);
                        $user = User::firstOrCreate($userArray);
                        /*$userName = S::create(Helper::createAcronym($user->full_name()))->padBoth(4, 'X');
                        $user->username = $userName;
                        $user->password = $userName;
                         */
                        // $user->identifier = $userArray['identifier'];
                        // $user-> = $userArray['identifier'];
                        // $user->save($userArray);
                        // $user->exams()->save($exam); //Will use a proper attach
                        $exam->users()->attach($user, ['turn' => $turn]);
                        $avatar = new Img;
                                $avatar->imageable_id = $user->id;
                                $avatar->source = ''.S::create($item['identifier'])->collapseWhitespace()->regexReplace('\W','');;
                                $avatar->imageable_type = "EMMA5\user";
                                $avatar->save();

                //         if (isset($imagesDir) && $imagesDir != "") {
                //                 $expectedFilename = ''.S::create($item['identifier'])->collapseWhitespace()->regexReplace('\W','');
                //                 // $image = preg_grep("/\/($expectedFilename)\.\w*$/", $imagesDir);
                //                 // dd($imagesDir);
                //                 $image =''.S::create(pathinfo($imagesDir[0], PATHINFO_FILENAME))->collapseWhitespace()->regexReplace('\W','');
                //                 if ($image != null) {
                //                         dd($image);
                //                         $fileName = File::name($image).".".File::extension($imagesDir[0]);
                //                         $avatar = new Img;
                //                         $avatar->imageable_id = $user->id;
                //                         $avatar->source = $fileName;
                //                         $avatar->imageable_type = "EMMA5\user";
                //                         // dd($imagesDir[0]);
                //                         // dd($avatarsPath.$fileName);
                //                         File::copy($imagesDir[0], $avatarsPath.$fileName);
                //                         array_shift($imagesDir);
                //                         $avatar->save();

                //                         // $user->avatar()->save($avatar);
                //                 }

                // }
                return $user;
        }));
        ini_set('max_execution_time', '180');
        // return $users;
        //validate the header names (this will be converted to attribute
        //names by excelLaravel)
        //
        //Create the users as objects to be saved
        //¿How manage the photos?
        //Create the Image object and attach it but the after how do I
        //garantee that the user uploads the photo files
        return back();
    }



    public function image(Request $request)
    {
        $path = public_path('images/exams');
        $files = $request->file('file');
        foreach ($files as $file) {

            // if ($file->getClientOriginalExtension() == '.jpg'||'.gif'||'.png') {
            //   return response()->json(['error' => 'Error: Utilice un formato .jpg .gif .png'], 422);
            // }
            $fileName = $file->getClientOriginalName();
            $img = Image::make($file);
            $img->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->move($path, $fileName);
            $img->save($path.'/'.$fileName);

            $image = new Img ;
            $image->imageable_type = 'EMMA5\\'.$request->type;
            $image->imageable_id = $request->imageable_id;
            $image->source = $fileName;
            $image->save();
        }

        return response()->json(['success' => 'Imagen almacenada'], 200);
    }

    public function examImages(Request $request)
    {
	$files = $request->file('images');

	if($request->hasFile('images'))
	{

        ini_set('memory_limit', '256M');
        $path = public_path('images/exams/'.$request->exam_id);
        if (!File::exists($path)) {
            return File::makeDirectory($path, 0775, true);
        }
        //        $this->validate($request, [
        //        'images' => 'required|image'
        //        ]);
        $files = $request->file('images');
        foreach ($files as $file) {
		Debugbar::addMessage($file, 'mylabel');
            $fileName = $file->getClientOriginalName();
            $input = $file->getClientOriginalName();
            $img = Image::make($file);
            $img->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imageData = Helper::imageType($fileName);
            $slot = Slot::byExamOrder($request->exam_id, $imageData['slotOrder']);
            $imageableId = $slot->id;
            if (isset($imageData['questionOrder'])) {
                $question = Question::where('slot_id', $slot->id)
                    ->where('order', $imageData['questionOrder'])
                    ->get()
                    ->first();
                $imageableId = $question->id;
            }


            $file->move($path, $fileName);
            $img->save($path . '/' . $fileName);
            $image = Img::firstOrCreate(
                [
                    'imageable_type' => 'EMMA5\\'.$imageData['imageableType'],
                    'imageable_id' => $imageableId,
                    'source' => $fileName
                ]
            );
        }
        //return back();
	return Redirect::back();
    }
}

    /**
     ''''* Filters a Request with zipped pictures and
     * returns the containing directory
     *
     * @return Response $request
     *
     * @author msantana
     *
     * @param $request Request
     */
    public function pictures(Request $request)
    {
        $this->validate($request, [
            'zipFile' => 'required|mimes:zip',
        ]
    );
        $dir = Helper::unzipUpload($request);
        return Helper::filterImages($dir);
        //Must get the board instance
        return $request;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function userAvatar(Request $request)
    {
        $this->validate($request, [
            'exam_id' => 'required'|'digits_between: 1, 4',
            'body' => 'required',
        ]);
        return back();
    }
} /*Methods for usersList*/
