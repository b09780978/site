@extends('base')

@section('title', '課程編輯')

@section('content')
	<h1><strong>功能尚未完成</strong></h1>
	<form method="GET" action="/site/courseEdit" class="form-inline">
		<div class="form-group">
			<label for="year">學年</label>
			<select class="form-control" name="year" id="year">
				<script>
					for(var y=100;y<=200;y++)
					{
						$('#year').append('<option>' + y + '</option>');
					}
				</script>
			</select>
		</div>

		<div class="form-group">
			<input checked="checked" type="radio" name="semester" id="semesterA" value="A">
			<label for="semesterA">上學期</label>
		</div>

		<div class="form-group">
			<input type="radio" name="semester" id="semesterB" value="B">
			<label for="semesterB">下學期</label>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">查詢</button>
		</div>
			
	</form>

	<table class="table table-striped table-botdered">
		<thead>
			<tr>
				<th>課程ID</th>
				<th>課程名稱</th>
				<th>星期</th>
			</tr>
			
			<tbody>
				<?php
					foreach($courses as $course)
					{
						echo '<tr>';
						echo '<td>' . $course->class_id . '</td>';
						echo '<td><input type="text" value="' . $course->cname . '"/></td>';
						echo '<td>' . $course->week . '</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</thead>
	</table>

@endsection
