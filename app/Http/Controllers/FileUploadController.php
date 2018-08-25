<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;

// 加長執行上傳可執行時間
ini_set('max_execution_time', 300);

class FileUploadController extends Controller
{
	public function showForm()
	{
		return view('upload');
	}

	public function upload(Request $request)
	{
		$file = $request->file('uploadFile');
		$year = $request->input('year', 'empty');
		$semester = $request->input('semester', 'empty');


		if( (!$file) || ($year === 'empty') || ($semester === 'empty'))
		{
			return back()->with('error', '輸入參數不夠');
		}

		if($file->getClientOriginalExtension()!='xlsx' && $file->getClientOriginalExtension()!='xls' )
		{
			return back()->with('error' , '目前只支援xlsx檔');
		}

		$filePath = $file->getRealPath();
		$prefix = $year . $semester;
		$digitMap = [ '一' => 1, '二' => 2, '三' => 3,  '四' => 4, '五' => 5,
					'六' => 6, '七' => 7, '八' => 8, '九' => 9, '十' => 10,  ];

		try
		{
			$reader = IOFactory::load($filePath);

			for($table=0;$table<1;$table++)
			{
				$reader->setActiveSheetIndex($table);
				$sheet = $reader->getActiveSheet();
				$rows = $sheet->getHighestRow();
				$columns = 'N';

				for($row=2;$row<=$rows;$row++)
				{
					$student = array( $prefix );
					for($column='A';$column<=$columns;$column++)
					{
						$data = null;
						switch($column)
						{
							case 'F':
							case 'L':
							case 'M':
								break;

							case 'B':
								$data = $sheet->getCell($column, $row)->getValue();
								$grade = digitMap[mb_substr($data, 0, 1, 'UTF-8')];
								$class_index = digitMap[mb_substr($data, 2, 1, 'UTF-8')];
								$grade = 10000;
								$class_index = 999999;
								array_push($student, $data);
								array_push($student, $grade);
								array_push($student, $class_index);
								break;
							case 'H':
								$birthday = $sheet->getCell($column . $row)->getFormattedValue();
								$data = date('Y-m-d', strtotime($birthday));
								array_push($student, $data);
								break;
							default:
								$data = $sheet->getCell($column . $row)->getValue();
								array_push($student, $data);
						}
					}
					
					//Use transaction
					/*
					DB::transaction(function() use ($student){
						DB::insert('INSERT INTO `student` ( `year`,`student_id`, `class`, `grade`, `class_index`, `number`, `name`, `sex`, `social_id`, `birthday`, `address`, `phone`, `guardian`, `emergency_phone`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $student);
					});
					*/
				}
			}
				return back()->with('success', '1: ' . print_r($student, true));
		}
		catch(\Exception $e)
		{
			return back()->with('error', $e->getMessage());
		}

	}

}

?>
