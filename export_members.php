<?php
//require('functions.php');
require('database.php');
		$link = mysql_connect($data_host, $data_username,$data_password)
		or die ("Could not connect to mysql because ".mysql_error());
	mysql_select_db($name_database)
		or die ("Could not select database because ".mysql_error());
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once 'source/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Event Sign Up")
							 ->setLastModifiedBy("Event Sign Up")
							 ->setTitle("Event Sign Up")
							 ->setSubject("Event Sign Up")
							 ->setDescription("Event Sign Up")
							 ->setKeywords("office 2007 openxml php Event Sign Up")
							 ->setCategory("Event Sign Up");
	$time = date('y').date('m').date('d').date('H').date('i');
	$date= date('m').'/'.date('d').'/'.date('y');
$sql = "SELECT * FROM  `team` "; 
$result=mysql_query($sql);
$result=mysql_query($sql);
// Add some data
$number=3;
while($row=mysql_fetch_array($result))
    {
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','Teams List')
			->setCellValue('B1', 'Downloaded:'.$date)
			->setCellValue('B2', 'Team')
			->setCellValue('C2', 'Username')
			->setCellValue('D2', 'Email')
            ->setCellValue('B'.$number,$row['name'])
            ->setCellValue('C'.$number, $row['username'])
            ->setCellValue('D'.$number, $row['email']);
	$number++;		
}
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Teams');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teams.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
