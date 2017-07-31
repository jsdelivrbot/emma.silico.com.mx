<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Helper class with various methods
 *
 * Includes all kind of helpers specific to EMMA functioning
 *
 * PHP Version 7.0
 *
 * Created by Vim.
 * User: marcosantana
 * Date: 29/09/16
 * Time: 10:03
 * @category Class
 *
 * @package Helper
 * @author msantana
 * @link http://emma.silico.com.mx
 *
 */
namespace EMMA5\Helpers;

use EMMA5\Board as Board;
use Carbon;
use File;
use EMMA5\Response;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Input as Input;
use Exception;
use Image;
use Intervention\Image\ImageManager;
use Comodojo\Zip\Zip as Zip;
use Comodojo\Exception\ZipException as ZipException;

/**
 *Helper class to do simple tasks easier in EMMA
 *
 * @package Helper
 * @subpackage default
 * @author yourname
 */
class Helper
{
    /**
     * @param $string
     * @param bool $onlyCapitals
     * @return null|string
     * Creates an acronym for usernames and the like
     */

    public static function createAcronym($string, $onlyCapitals = false)
    {
        $output = null;
        $token  = strtok($string, ' ');
        while ($token !== false) {
            $character = mb_substr($token, 0, 1);
            if ($onlyCapitals and mb_strtoupper($character) !== $character) {
                $token = strtok(' ');
                continue;
            }
            $output .= $character;
            $token = strtok(' ');
        }
        return $output;
    }

    /**
     * Takes a Board object and searchs for its smnall version of
     * its logo for the header in the template generator
     *
     * @param Class $board
     *
     * @return string
     */
    public static function templateHeaderLogo(Board $board)
    {
        $dir = public_path('images/');
        $file = Image::make($dir.$board->logo->first()->source);
        //So I must create a directory to save the new asset
        //I must create a proper name for the final image file
        //Must create a function to create the dir if it doesn't exists?
        $file->greyscale();
        $file->resize(
                        80,
                        null,
                        function ($constraint) {
                            $constraint->aspectRatio();
                        }
                );
        $file->save(
                        storage_path('app/wordTemplates/'.$board->id.'/').$file->filename.'_small'.'.'.$file->extension
                );
        dd($file);
    }


    /*
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public static function createBoardTemplate(Board $board)
    {
        //Getting the board logo
        $objPHPWord = new \PhpOffice\PhpWord\PhpWord();
        $logo = $board->logo->first()->source;
        //Preparing th generarl orintation of the main section
        //For this kind of reports it is always portrait
        $sectionStyle = [
                        'orientation' =>  'portrait',
                        'marginTop' => 600,
                        'colsNum' => 1,
                ];
        //Preparing the "small" image to be
        //used in the header of all the document
        $imageStyle = [
                        'height' => 80,
                        'wrappingStyle' => 'square',
                        'posHorizontalRel' => 'margin',
                        'posVerticalRel' => 'line',
                ];
        //Create the section
        //
        $section = $objPHPWord->addSection($sectionStyle);
        //Create snake_casean empty header
        $header = $section->addHeader();
        //Preparing a table to insert in the heading
        //to accomodate the image on the left and
        //the name of the board on the right
        $tableStyle = [
                        'borderColor' => '006699',
                        'borderSize' => 6,
                        'cellMargin' => 50
                ];
        $firstRowStyle = array('bgColor' => '66BBFF');
        $objPHPWord->addTableStyle('headerTable', $tableStyle, $firstRowStyle);

        $headerTable = $header->addTable('headerTable');
        $headerTable->addRow();
        $cell = $headerTable->addCell();

        $source = "images/".$logo;
        //echo asset($source);
        //dd($source);
        echo $logo;
        $cell->addImage(public_path('images')."/".$logo, $imageStyle);
        $cell = $headerTable->addCell();
        $cell->addText($board->name, array('name' => 'Arial', 'size' => 11));
        $cell = $headerTable->addCell();
        $cell->addText(
                        'Examen de Certificación ${aplicated_at}',
                        array('name' => 'Arial', 'size' => 11)
                );
        $testTextSection = $objPHPWord->addSection();
        $testTextSection->addText(
                        '',
                        ['name' => 'Tahoma', 'size' => 32]
                );
        //Save and return
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($objPHPWord, 'Word2007');
        $fileName = 'template_'.Helper::createAcronym($board->name).".docx";
        $savePath = storage_path().'/wordTemplates/'.$board->id;
        //dd(storage_path('wordTemplates/'.$board->id));
        echo $fileName;
        echo File::exists($savePath);
        /*if (!File::exists($savePath)) {
            File::makeDirectory(storage_path().'/wordTemplates/'.$board->id, 0777, true);
        }*/
        return $objWriter->save($savePath.'/'.$fileName);

        //$objWriter->save(storage_path().'/wordTemplates/'.$board->id.'test.docx');
                //File::put($fileName, $objWriter->save($fileName));
                //return public_path($fileName);
                //return $objWriter->save("test.docx");
                //$document->save(public_path($fileName));
                //$writer = PHPWord_IOFactory::createWriter($objPHPWord, 'Word2007');;
                //$writer->save("testword.docx");
                //return Response::download(storage_path(), $fileName);
    }

    /**
     * Takes a number and rounds it to 2 significant digits
     * and or zeropads it to 2 significant digits
     *
     * @return string
     */
    public static function statsRound($value)
    {
        $value = number_format($value, 2, '.', ',');
        return $value;
    }

    /**
     * Takes the group as original and part as the request of percentage
     *
     * @return string
     */
    public static function percentage($original, $part)
    {
        try {
            $percent = ($part/$original)*100;
            return Helper::statsRound($percent);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Takes a Request object, test if the uploaded file is a valid zip
     * puts it on a temp file and uncompress it.
     *
     *@return string Route to the uncompressed folder
     */
    public static function unzipUpload(Request $request)
    {
        try {
            Zip::check(Input::file('zipFile'));
        } catch (ZipException $e) {
            return $e;
            flash('Archivo no válido', 'danger')->important();
        }
        try {
            $inputZip = Input::file('zipFile')
                                ->move(
                                        storage_path('/tmp/'.Input::file('zipFile')->getBasename())
                                );
            $zip = Zip::open($inputZip);
            $zip->extract(storage_path('tmp/').$inputZip->getBasename());
            File::delete($inputZip);
        } catch (ZipException $e) {
            flash(
                                'Error al descomrpimir el archivo inténtelo de nuevo y si el problema persiste contacte al administrador'
                        );
        }//End try/catch
        return storage_path('tmp/').$inputZip->getBasename();
    }//End unzipUpload

    /**
     * Recibes a string of a directory and returns an array with the image contents of the file
     *
     * @return array
     * @author msantana
     */
    public static function filterImages(string $directory)
    {
        //$files = File::allFiles($directory);
        $aviableImageFormats = [
                        "png",
                        "jpg",
                        "jpeg",
                        "gif"
                ];
        $imageExtensions = "{";
        foreach ($aviableImageFormats as $extension) {
            //Final product glob("*.{[jJ][pP][gG],[pP][nN][gG],[gG][iI][fF]}"
            $extensionChars = str_split($extension);
            $rgxPartial = null;
            foreach ($extensionChars as $char) {
                $rgxPartial .= "[".strtoupper($char).strtolower($char)."]";
            }
            $rgxPartial .= ",";
            $imageExtensions .= $rgxPartial;
        }
        $imageExtensions .= "}";
        if (File::exists($directory)) {
            $imagesList = glob($directory."/*.".$imageExtensions, GLOB_BRACE);
            return $imagesList;
        } else {
            return null;
        }
    }//End filterImages

    /**
     * Processes the given image to be properly used in the exams
     *
     * @return Array
     * @author msantana
     */
    public static function userPictureProcess($directory, Board $board)
    {
        try {
            //$files = File::get($directory);
            $files = File::allFiles($directory);
        } catch (Exception $e) {
            return $e;
        }
        try {
            $manager = new ImageManager(array('driver' => 'imagick'));
        } catch (Exception $e) {
            echo "Error creando manager de image ".PHP_EOL.$e;
        }
        if ($board) {
            $logo = $board->logo->first();
            $watermark = $manager->make("http://www.cmmu.org.mx/images/logo_intro.png?crc=4127967993");
            ///$watermark = $manager->make(public_path('images/'.$logo->source));
            //$watermark->gamma(2.5);
            //$watermark->greyscale();
            //$watermark= $manager->make($directory."/watermarkLogo.jpg");
            /*$watermark->resize(null, 64, function ($constraint) {
                        $constraint->aspectRatio();
            });*/
            $watermark->save($directory."/watermarkLogo.jpg");
        }
        foreach ($files as $picture) {
            try {
                $newImage = $manager->make($picture);
            } catch (Exception $e) {
                echo $e;
            }
            $height = round($newImage->height() * 0.6);
            $width = round($newImage->width() * 0.5);
            $newImage->crop($width, $height);
            $newImage->save($picture);
            //$newImage->resizeCanvas($height, $width);
            $newImage->trim('bottom-right', array('bottom'), 0, null);
            $newImage->save($picture);
            $newImage->mask($watermark, true);
            $newImage->save($picture);
            echo $picture.PHP_EOL;
        }
        return true;
    }/* End userPictureProcess */

    /**
     * Extracts information from the file such as the imageable type it belongs and order within that object
     *
     * @param $file String
     * @return $imageData  Array
     * @author msantana
     */
    public static function imageType($file)
    {
        preg_match("/([0-9]{1,})([a-z]*)([_| ]?)([p|d]?)([0-9]*)/", $file, $output_array);
        if (isset($output_array[2])) {
                $imageData['imageOrder'] = $output_array[2];
        }
        $imageData['slotOrder'] = $output_array[1];
        $imageData['imageableType'] = "slot";
        if ($output_array[4] == "p" | $output_array[4] == "P") {
                $imageData['imageableType'] = "question";
                isset($output_array[5]) ? $imageData['questionOrder'] = $output_array[5] : $imageData['questionOrder'] = null;
        }
        //$imageData['order'] = $output_array[5];
        return $imageData;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public static function uploadUserAvatar()
    {
    }
} // END     class
