@extends('base')

@section('title', '上傳學生資料到資料庫')

@section('content')
	<h1>上傳寫入資料到資料庫</h1>
	<div class="card">
		<div class="card-header">上傳學生資料</div>
		<div class="card-body">
			<form action="/site/upload" method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<label for="year">年分</label>
					<select class="form-control" id="year" name="year">
					</select>
				</div>

				<div class-"form-group">
					<label for="semester">學期</label>
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
					<input type="file" class="form-control-file" name="uploadFile" id="uploadFile" aria-describedby="uploadHelp">
					<small id="uploadHelp" class="form-text text-muted">請選擇一個xls(x)檔案進行上傳</small>
				</div>
				<button type="submit" class="btn btn-primary">進行上傳並寫入資料庫</button>
			</form>

			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ $message }}</strong>
				</div>
			@endif

			@if ($error = Session::get('error'))
				<div class="alert alert-danger">
					<strong>發生錯誤</strong>
					<strong>{{ $error }}</strong>
				</div>
			@endif
		</div>
	</div>

	<script>
		//生成年分選項
		for(var y=100;y<=200;y++)
		{
			$('#year').append('<option>'+y+'</option>');
		}
	</script>

@endsection
