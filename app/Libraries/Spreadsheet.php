<?php
/**
 * LliststUsers File Doc Comment
 *
 * PHP version 7
 *
 * @category  CategoryName
 * @package   PackageName
 * @author    msantana <marco.santana@gmail.com>
 * @copyright 2016 msantana SiLiCo
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://silico.com.mx
 */
namespace EMAM5\Libraries;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
use File;
use Helper;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

/**
 * Creates a spreadsheet with the given array *
 *
 PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 *  @package    PackageName
 * @author     msantana <marco.santana@gmail.com>
 * @copyright  2016 msantana SiLiCo
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://silico.com.mx
 * @deprecated File deprecated in Release 2.0.0
 */

class UserSpreadsheet
{

        /**
         * Class construct
         *
         * @param string $users the location of the spreadsheet containing the users
         *
         * @author msantana <marco.santana@gmail.com>
         *
         * @return void
         */
    public function __construct()
    {
        $this->searchDir = $searchDir;
        $this->fs = new Filesystem;
    }

    /**
     * Reads the original spread sheet and organizes the file acording to column name
     *
     * @return array
     * @author msantana <marco.santana@gmail.com>
     */
    public function store(Request $request)
    {
        $this->validate($request, [
              'file' => 'required | mimes:application/vnd.ms-excel',
            ]);
    }
} // END UserSpreadsheet class
