@extends('base')

@section('title', '刪除學生資料庫')

@section('content')
	<form method="POST" action="/site/dropStudent">
		@csrf
		<div class="form-group">
			<label for="year">學年</label>
			<select class="form-control" name="year" id="year">
				<script>
					for(var y=100;y<201;y++)
					{
						$('#year').append('<option>' + y + '</option>');
					}
				</script>
			</select>
		</div>

		<div class="form-group">
			<label for="semester">學期</label>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="semester" id="semesterA" value="A" checked="checked">
				<label class="form-check-label" for="semesterA">上學期</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="semester" id="semesterB" value="B">
				<label class="form-check-label" for="semesterB">下學期</label>
			</div>
		</div>

		<div class="form-group">
			<button class="btn btn-primary">刪除</button>
		</div>
		
	</form>

	@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	@endif

	@if($error = Session::get('error'))
		<div class="alert alert-danger">
			<strong>發生錯誤</strong>
			<strong>{{ $error }}</strong>
		</div>
	@endif
@endsection
