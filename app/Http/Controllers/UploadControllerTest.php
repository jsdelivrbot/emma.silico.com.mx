<?php

namespace EMMA5\Http\Controllers;

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
use File;
use League\Csv\Reader;
use Carbon;

class UploadControllerTest extends Controller
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

    public function image(Request $request)
    {
        $path = public_path('images/exams/'.$request->exam_id);
        if (!File::exists($path)) {
            return File::makeDirectory($path, 0775, true);
        }
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
}
