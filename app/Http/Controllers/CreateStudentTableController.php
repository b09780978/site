<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;

class CreateStudentTableController extends Controller
{
	public function showForm()
	{
		return view('createStudentTable');
	}

	public function create(Request $request)
	{
		$year = $request->input('year');
		$semester = $request->input('semester');
		$prefix = $request->input('year') . $request->input('semester');
		$classTable = array();
		$counter = DB::table('COURSEMAP')->where('class_id', 'LIKE', '%' .  $prefix . '%')->count();
		$statu = 'success';
		$message = '';


		// 加入課程對應表
		try
		{
			//取得來自檔案上傳新增的課程
			$file = $request->file('uploadFile');
			if( $file && ( $file->getClientOriginalExtension()=='xlsx' || $file->getClientOriginalExtension()=='xls')  )
			{
				$filePath = $file->getRealPath();
				$reader = IOFactory::load($filePath);
				$reader->setActiveSheetIndex(0);
				$sheet = $reader->getActiveSheet();
				$rows = $sheet->getHighestRow();

				for($row=2;$row<=$rows;$row++)
				{
					$week = $sheet->getCell('A' . $row)->getValue();
					$cname = $sheet->getCell('B' . $row)->getValue();
					array_push($classTable, [ 'class_id' => $prefix . $counter,
							'week' => $week,
							'cname' => $cname,
					]);
					$counter++;
				}
			}

			// 取得來自網頁新增的課程
			$courses = $request->all();
			$temp = array();
			foreach($courses as $c => $value)
			{
				if($c === '_token' || $c === 'year' || $c === 'semester' || $c === 'uploadFile')
				{
					continue;
				}
				array_push($temp, $value);
			}

			for($i=0;$i<count($temp);$i+=2)
			{
				array_push($classTable, [
					'class_id' => $prefix . $counter,
					'cname' => $temp[$i],
					'week' => $temp[$i+1],
				]);
				$counter++;
			}

			// 存入資料庫
			DB::transaction(function() use($classTable){
				$total_course = count($classTable);

				for($i=0;$i<$total_course;$i++)
				{
					DB::insert('INSERT INTO `coursemap` (`class_id`, `cname`, `week`) VALUES (?, ?, ?)', [
						$classTable[$i]['class_id'], $classTable[$i]['cname'], $classTable[$i]['week'],	
					]);	
				}
			});
		}
		catch(\Exception $e)
		{
			//$message .= $e->getMessage();
			$message = '發生錯誤，請聯絡管理員';
			$message .= $e->getMessage();
			$statu = 'error';
		}

		if($statu === 'success')
		{
			$message = '操作成功';
		}

		return back()->with($statu, $message);

	}
}

?>
