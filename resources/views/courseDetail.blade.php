@extends('base')

@section('title', '課程參加學生')

@section('content')
<?php
	 use Illuminate\Support\Facades\DB;
?>

<h1><center><?php echo $courseName; ?></center></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>課程名稱</th>
			<th>班級</th>
			<th>座號</th>
			<th>姓名</th>
			<th>聯絡人</th>
			<th>連絡電話</th>
			<th>緊急連絡電話</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach($courseMember as $member)
			{
		?>
		<tr>
		<?php
			echo '<td>' . $courseName . '</td>';
			echo '<td>' . $member->class . '</td>';
			echo '<td>' . $member->number . '</td>';
			echo '<td>' . $member->name . '</td>';
			echo '<td>' . $member->guardian . '</td>';
			echo '<td>' . $member->phone . '</td>';
			echo '<td>' . $member->emergency_phone . '</td>';
		?>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>

@endsection
