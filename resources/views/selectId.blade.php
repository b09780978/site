@extends('base')

@section('title', '顯示班級學生資料')

@section('content')

	<center><h1>學生資料表</h1></center>
	<div class="container">
		<form method="POST" class="form" action="/site/selectId">
			@csrf
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
				<br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" checked="checked" type="radio" name="semester" id="semesterA" value="A">
					<label class="form-check-label" for="semesterA">上學期</label>
				</div>	
    
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="semester" id="semesterB" value="B">
					<label class="form-check-label" for="semesterB">下學期</label>
				</div>
    
			</div>

			<div class="form-group">
				<label>學號</label>
				<input type="text" class="form-control" name="studentId" id="studentId" placeholder="請輸入學號">
			</div>
    
			<div class="form-group">
				<button class="btn btn-primary">查詢</button>
			</div>
		</form>
	</div>

	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<strong>{{ $message }}</strong>
		</div>
	@endif

	@if ($message = Session::get('error'))
		<div class="alert alert-danger">
			<strong>發生錯誤</strong>
			<strong>{{ $message }}<strong>
		</div>
	@endif

@endsection
