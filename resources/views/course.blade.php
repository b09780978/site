@extends('base')

@section('title', '課程參加學生')

@section('content')
<?php
	 use Illuminate\Support\Facades\DB;
?>

<form method="GET" class="form-inline" action="/site/course">
	<div class="form-group">
		<label for="year">學年</label>
		<select class="form-control" name="year" id="year">
			<script>
				var y = 100;
				for(var y=100;y<=200;y++)
				{
					$('#year').append('<option>'+ y +'</option>');
				}
			</script>
		</select>

		<div class="form-group">
			<label for="semester">學期</label>
			<div class="form-check form-check-inline">
				<input checked="checked" type="radio" name="semester" id="semesterA" value="A">
				<label for="semesterA">上學期</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="radio" name="semester" id="semesterB" value="B">
				<label for="semesterB">下學期</label>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">查詢</button>
		</div>
	</div>
</form>

<h1><center>課程列</center></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>星期</th>
			<th>課程名稱</th>
			<th>選項</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach($course as $c)
			{
		?>
			<tr>
			<?php
				echo '<td>' . $c->week . '</td>';
				echo '<td>' . $c->cname . '</td>';
				echo '<td><button class="btn btn-primary"><a href="/site/course/detail/' . $c->class_id .'"><font class="text-light">前往</font></a></button></td>';
			?>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

@endsection
