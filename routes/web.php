<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

use App\Http\Requests;

Route::get('/', function () {
	$statu = true;
	try
	{
		// Create table COURSE
		if(!Schema::hasTable('STUDENT'))
		{
			$tableName = 'STUDENT';
			Schema::create($tableName, function($table){
                    $table->string('student_id', 20);
                    $table->string('year', 20);
                    $table->string('class', 20)->nullable();
                    $table->integer('grade')->nullable();
                    $table->integer('class_index')->nullable();
                    $table->integer('number')->nullable();
                    $table->string('name', 30)->nullable();
                    $table->string('sex', 10)->nullable();
                    $table->string('social_id', 20)->nullable();
                    $table->date('birthday')->nullable();
                    $table->text('address')->nullable();
                    $table->text('phone')->nullable();
                    $table->string('guardian', 20)->nullable();
                    $table->string('emergency_phone', 20)->nullable();
    
                    $table->primary(['student_id', 'year']);
    
                    $table->engine = 'InnoDB';
                    $table->charset = 'utf8';
                    $table->collation = 'utf8_general_ci';
            });
		}

		// Create table COURSEMAP 
		if(!Schema::hasTable('COURSEMAP'))
		{
			$tableName = 'COURSEMAP';
            Schema::create($tableName, function($table){
                    $table->string('class_id', 20);
                    $table->text('cname');
                    $table->integer('week');
            
                    $table->primary('class_id');
            
                    $table->engine = 'InnoDB';
                    $table->charset = 'utf8';
                    $table->collation = 'utf8_general_ci';
            });
		}

		if(!Schema::hasTable('COURSE'))
		{
			// Create table COURSE
			$tableName = 'COURSE';
			Schema::create($tableName, function($table){
                    $table->string('class_id', 20);
                    $table->string('student_id', 20);
                    $table->engine = 'InnoDB';
                    $table->charset = 'utf8';
                    $table->collation = 'utf8_general_ci';
            });
		}

	}
	catch(\Exception $e)
	{
		$statu = false;
		$statu = $e->getMessage();
	}

	return view('index', [ 'a' => $statu, ] );
});

/*
	Show students data route.
*/
Route::get('/class', function(Request $request){
	$year = $request->query('year', '');
	$semester = $request->query('semester', '');
	$grade = $request->query('grade', '');
	$class_index = $request->query('class_index', '');
	$all_class = $request->query('all_class', '');

	if( (strlen($year) === 0) || (strlen($semester)===0) || (strlen($grade)===0) || (strlen($class_index)===0)  )
	{
		$students = array();
		return view('class', [ 'students' => $students ] );
	}
	else if( $all_class === 'y')
	{
		$students = DB::select('select * FROM STUDENT WHERE year=? ORDER BY student_id', [ $year . $semester, ]);
		return view('class', [ 'students' => $students, 'year' => $year, 'semester' => $semester, ]);
	}
	else
	{
		return redirect('class/' . $year . '/' . $semester . '/' . $grade . '/' . $class_index);
	}
});

Route::get('/class/{year}/{semester}', function($year, $semester){
	$prefix = $year . $semester;
	$students = DB::select('SELECT * FROM STUDENT WHERE year=:year ORDER BY grade, class_index, number',
			[ 'year' => $prefix,  ]);
	return view('class', [ 'year' => $year, 'semester' => $semester, 'students' => $students ] );
});

Route::get('/class/{year}/{semester}/{grade}/{class_index}', function ($year, $semester, $grade, $class_index) {
	$prefix = $year . $semester;
	$students = DB::select('SELECT * FROM STUDENT WHERE grade=:grade and class_index=:class_index and year=:year ORDER BY number',
			[ 'grade' => $grade, 'class_index' => $class_index, 'year' => $prefix,  ]);
	return view('class', [ 'year' => $year, 'semester' => $semester, 'students' => $students, ]);
});

/*
	Create Student and Class table route.
*/
Route::get('/createStudentTable', 'CreateStudentTableController@showForm');
Route::post('/createStudentTable', 'CreateStudentTableController@create');

/*
	File upload route.
*/
Route::get('/upload', 'FileUploadController@showForm');
Route::post('/upload', 'FileUploadController@upload');

Route::get('/select/{year}/{semester}/{student_id}', function($year, $semester, $student_id){
	$student = array();
	$course = array();
	$student['year'] = $year;
	$stduent['semester'] = $semester;
	$prefix = $year . $semester;

	try
	{
		$student = DB::select('SELECT grade, class_index, name, number, student_id FROM STUDENT WHERE student_id=:student_id', [
			'student_id' => $student_id,	
		]);
		$course = DB::select('SELECT class_id, cname, week FROM COURSEMAP WHERE class_id LIKE concat("%", :prefix, "%")', [
			'prefix' => $prefix,
		]);
	}
	catch(\Exception $e)
	{
		$student['error_message'] = $e->getMessage();
	}

	return view('select', [
		'student' => $student,	
		'course' => $course,
	]);
});

Route::post('/select', function(Request $request){
	$student_id = $request->input('student_id', '');
	$currentData = DB::select('SELECT class_id FROM COURSE WHERE student_id=:student_id', [ 'student_id' => $student_id ]);
	$error_message = '';
	$current = array();

	//Get all current selected course
	foreach($currentData as $c)
	{
		array_push($current, $c->class_id);
	}

	$selects = array($request->input('c0', '0'),
					 $request->input('c1', '0'),
					 $request->input('c2', '0'),
					 $request->input('c3', '0'),
					 $request->input('c4', '0'),
					 $request->input('c5', '0'),
					 );
	
	DB::transaction(function() use($student_id){
		DB::table('COURSE')->where('student_id', '=', $student_id)->delete();	
	});

	for($i=0;$i<count($selects);$i++)
	{
		if($selects[$i] !== '0')
		{
			$data = array($selects[$i], $student_id);
			DB::transaction(function() use($data){
				DB::insert('INSERT INTO `COURSE` (`class_id`, `student_id`) VALUES (?, ?)', $data);	
			});
		}
	}

	if(strlen($error_message) === 0)
	{
		return back()->with('success', '操作完成');
	}
	else
	{
		return back()->with('error', '操作失敗');
	}
});

Route::get('/course', function(Request $request){
	$courseList = null;
	$prefix = $request->query('year', '') . $request->query('semester', '');

	if(strlen($prefix) === 0)
	{
		$courseList = array();
	}
	else
	{
		$courseList = DB::select('SELECT class_id, cname, week FROM COURSEMAP WHERE class_id LIKE concat("%", :prefix, "%") ORDER BY week', [
			'prefix' => $prefix,	
		]);
	}

	return view('course', [ 'course' => $courseList, 'courseName' => '尚未選擇課程', ]);
});

Route::get('/course/detail/{class_id}', function($class_id){
	$courseList = null;
	$courseMember = array();
	$courseName = '';
	try
	{
		$courseMember = DB::table('STUDENT')
							->join('COURSE', 'COURSE.student_id', '=', 'STUDENT.student_id')
							->select('STUDENT.student_id', 'STUDENT.class', 'STUDENT.number', 'STUDENT.name')
							->where('class_id', '=', $class_id)
							->distinct()
							//->orderBy('class')
							->orderBy('grade')
							->orderBy('class_index')
							->orderBy('number')
							//->groupBy('student_id')
							->get();
	}
	catch(\Exception $e)
	{
		$courseMember = array();
	}

	try
	{
		$courseName = DB::select('select cname FROM COURSEMAP WHERE class_id=?', [ $class_id, ])[0]->cname;
	}
	catch(\Exception $e)
	{
		$courseName = '未知課程名稱';
	}
	if(strlen($courseName) === 0)
	{
		$courseName = '未知課程名稱';
	}

	return view('courseDetail', [ 'courseName' => $courseName, 'courseMember' => $courseMember, ] );
});

Route::get('/class/detail', 'StudentSelectController@index');

Route::get('/courseEdit', function(Request $request){
	$year = $request->query('year', '');
	$semester = $request->query('semester', '');
	$prefix = $year . $semester;
	$course = array();
	
	if(strlen($prefix) !== 0)
	{
		$course = DB::table('COURSEMAP')
				->where('class_id', 'like', '%' . $prefix . '%')
				->orderBy('week')
				->get();
	}

	//$message = print_r($course, true);

	return view('courseEdit', [ 'courses' => $course, ] );
});

Route::get('/dropStudent', function(){
	return view('/dropStudent');
});
Route::post('/dropStudent', function(Request $request){
	$year = $request->input('year', '');
	$semester = $request->input('semester', '');
	$message = '刪除成功';

	if( (strlen($year) === 0) || (strlen($semester) === 0) )
	{
		return back()->with('error', '輸入錯誤');
	}

	$prefix = $year . $semester;
	try
	{
		DB::transaction(function() use($prefix){
			DB::table('STUDENT')
				->where('year', '=', $prefix)
				->delete();
		});
	}
	catch(\Exception $e)
	{
		$message = $e->getMessage();
		return back()->with('error', $message);
	}

	return back()->with('success', $message);
});

Route::get('test', function() {
	$students = DB::select('select * FROM STUDENT WHERE year=? ORDER BY student_id', [ "107A" ]);
	return view('test', [ 'students' => $students, 'year' => 107, 'semester' => 'A' ]);
});
