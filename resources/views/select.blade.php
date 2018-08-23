@extends('base')

@section('title', '學生選課')

@section('content')
	<center><h1>學生選課</h1></center>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>學號</th>
				<th>年級</th>
				<th>班級</th>
				<th>座號</th>
				<th>姓名</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><?php echo $student[0]->student_id; ?></td>
				<td><?php echo $student[0]->grade; ?></td>
				<td><?php echo $student[0]->class_index ?></td>
				<td><?php echo $student[0]->number; ?></td>
				<td><?php echo $student[0]->name; ?></td>
			</tr>
		</tbody>
	</table>

	@if ($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	@endif

	@if ($error = Session::get('error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>發生錯誤<strong>
			<strong>{{ $error }}</strong>
		</div>
	@endif

	<form method="POST" class="form" action="/site/select" >
		@csrf
		<?php
			if(count($course) !== 0)
			{
		?>

		<h2>課照班</h2>
		<div class="form-check form-check-inline">
			<div class="form-check form-check-inline">
				<input class="form-check-input" checked="checked" name="c0" type="radio" value="0" id="ii">
				<label class="form-check-label" for="ii">不參加</label>
			</div>

			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="c0" value="<?php echo $course[0]->class_id; ?>" id="i0">
				<label class="form-check-label" for="i0">課照班</label>
			</div>
		</div>

		<?php
			echo '<input type="hidden" name="student_id" value="' . $student[0]->student_id . '">';
			$counter = 1;
			for($i=1;$i<6;$i++)
			{
				echo '<h2>星期' . $i . '</h2>';
				echo '<div class="form-check form-check-inline">';

				echo '<div class="form-check form-check-inline">';
				echo '<input class="form-check-input" type="radio" value="0" name="c' . $i . '" id="i' . $counter . '" checked="checked">';
				echo '<label class="form-check-label" for="i' . $counter . '">不參加</label>';
				echo '</div>';
				$counter++;

				foreach($course as $c)
				{
					if($i === $c->week)
					{
						echo '<div class="form-check form-check-inline">';
						echo '<input class="form-check-input" type="radio" name="c' . $i . '" value="' . $c->class_id .  '" id="i' . $counter . '">';
						echo '<label class="form-check-label" for="i' . $counter . '">' . $c->cname  . '</label>';
						echo '</div>';
						$counter++;
					}
				}
				echo '</div>';
			}
		?>

		<div class="form-group">
			<button class="btn btn-primary">送出</button>
		</div>
		<?php
			// End if coure is empty
			}
		?>
	</form>

@endsection
