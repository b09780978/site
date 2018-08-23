@extends('base')

@section('title', '班級查詢')

@section('content')
	<center><h1>班級查詢</h1></center>

	<form method="GET" class="form-inline" action="/site/class/detail">
		<div class="form-group">
			<label for="year">學年</label>
			<select class="form-control" name="year" id="year">
				<script>
					for(var y=100;y<210;y++)
					{
						$('#year').append('<option>' + y + '</option>');
					}
				</script>
			</select>
		</div>

		<div class="form-group">
			<label for="semester">學期</label>

			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="semester" id="semesterA" value="A" checked>
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
				<select id="class_index" name="class_index" class="form-control">
					<script>
						for(var c=1;c<21;c++)
						{
							$('#class_index').append('<option>' + c + '</option>');
						}
					</script>
				</select>
			</div>

			<div class="form-group">
				<button class="btn btn-primary">查詢</button>
			</div>

		</div>
	</form>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>學號</th>
				<th>班級</th>
				<th>座號</th>
				<th>姓名</th>
				<th>課程</th>
			</tr>
		</thead>

		<tbody>
			<?php
				foreach($students as $student)
				{
			?>
			</tr>
			<?php
				echo '<td>' . $student->student_id . '</td>';
				echo '<td>' . $student->class . '</td>';
				echo '<td>' . $student->number . '</td>';
				echo '<td>' . $student->name . '</td>';
			?>
				<td>空</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>

@endsection
