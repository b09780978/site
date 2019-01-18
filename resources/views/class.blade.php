@extends('base')

@section('title', '顯示班級學生資料')

@section('content')

	<center><h1>學生資料表</h1></center>
	<div class="container">
		<form method="GET" class="form-inline" action="/site/class">
			<div class="form-group">
				<label for="year">學年</label>
				<select class="form-control" name="year" id="year">
					<script>
						for(var y=100;y<=200;y++)
						{
							$('#year').append('<option>'+ y +'</option>');
						}
					</script>
				</select>
			</div>
    
			<div class="form-group">
				<label>學期</label>
    
				<div class="form-check form-check-inline">
					<input class="form-check-input" checked="checked" type="radio" name="semester" id="semesterA" value="A">
					<label class="form-check-label" for="semesterA">上學期</label>
				</div>	
    
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="semester" id="semesterB" value="B">
					<label class="form-check-label" for="semesterB">下學期</label>
				</div>
    
			<div class="form-group">
				<label for="grade">年級</label>
				<select class="form-control" id="grade" name="grade">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
				</select>
			</div>
    
			<div class="form-group">
				<label for="class_index">班級</label>
				<select class="form-control" id="class_index" name="class_index">
					<script>
						for(var c=1;c<=20;c++)
						{
							$('#class_index').append('<option>' + c + '</option>');
						}
					</script>
				</select>
			</div>

			<div class="form-group">
				<label>選擇全部</label>
				<input class="form-check form-check-inline" type="radio" name="all_class" value="y">
				<label class="form-check-label" for="all_class">是</label>
				<input class="form-check-form-check-inline" type="radio" name="all_class" checked="checked" value="n">
				<label class="form-cehck-label" for="all_class" >否</label>
			</div>
    
			<div class="form-group">
				<button class="btn btn-primary">查詢</button>
			</div>
		</form>
	</div>

	<table id="table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>選課</th>
				<th>學號</th>
				<th>班級</th>
				<th>座號</th>
				<th>姓名</th>
				<th>性別</th>
				<th>身分證字號</th>
				<th>生日</th>
				<th>地址</th>
				<th>電話</th>
				<th>監護人</th>
				<th>緊急聯絡電話</th>
			</tr>
		</thead>

		<tbody>
				<?php
					foreach($students as $student)
					{
				?>
					<tr>
						<td>
							<button class="btn btn-primary" type="button"><a href="<?php echo '/site/select/' . $year . '/' . $semester . '/' . $student->student_id;  ?>" target="_blank"><font class="text-light">選課</font></a></button>
						<!--
							<button class="btn btn-primary" type="button"><a href="<?php echo '/site/student/edit/' . $year . '/' . $semester . '/' . $student->student_id; ?>" target="_blank"><font class="text-light">編輯</font></a></button>
						</td>
						-->
				<?php
						echo '<td>' . $student->student_id . '</td>';
						echo '<td>' . $student->class . '</td>';
						echo '<td>' . $student->number . '</td>';
						echo '<td>' . $student->name . '</td>';
						echo '<td>' . $student->sex . '</td>';
						echo '<td>' . $student->social_id . '</td>';
						echo '<td>' . $student->birthday . '</td>';
						echo '<td>' . $student->address . '</td>';
						echo '<td>' . $student->phone . '</td>';
						echo '<td>' . $student->guardian . '</td>';
						echo '<td>' . $student->emergency_phone . '</td>';
				?>
					</tr>
				<?php
					}
				?>
		</tbody>

	</table>

	</script>
@endsection
