<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class StudentSelectController extends Controller
{
	public function index(Request $request)
	{
		$year = $request->query('year');
		$semester = $request->query('semester');
		$grade = $request->query('grade');
		$class_index = $request->query('class_index');
		$prefix = $year . $semester;

		// $message for debug
		$message = '';
		$message .= $year . '<br>';
		$message .= $semester . '<br>';
		$message .= $grade . '<br>';
		$message .= $class_index . '<br>';

		$student = DB::table('STUDENT')
					->where('year', '=', $prefix)
					->where('grade', '=', $grade)
					->where('class_index', '=', $class_index)
					->orderBy('number')
					->get();
		$message = $student;

		return view('classDetail', [ 'students' => $student, 'message' => $message ]);
	}

	public function getResult()
	{

	}
}

?>
