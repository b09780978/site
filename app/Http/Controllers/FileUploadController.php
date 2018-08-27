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

		try
		{
			$reader = IOFactory::load($filePath);

			for($table=0;$table<6;$table++)
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
						if($column==='H')
						{
							$birthday = $sheet->getCell($column . $row)->getFormattedValue();
							$data = date('Y-m-d', strtotime($birthday));
						}
						else
						{
							$data = $sheet->getCell($column . $row)->getValue();
						}
						array_push($student, $data);
					}
					
					//Use transaction
					DB::transaction(function() use ($student){
						DB::insert('INSERT INTO `student` ( `year`,`student_id`, `class`, `grade`, `class_index`, `number`, `name`, `sex`, `social_id`, `birthday`, `address`, `phone`, `guardian`, `emergency_phone`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $student);
					});
				}
			}
				return back()->with('success', '上傳資料庫完成');
		}
		catch(\Exception $e)
		{
			return back()->with('error', $e->getMessage());
		}

	}

}

?>
