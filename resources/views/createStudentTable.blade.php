@extends('base')

@section('title', '建立課照班課程資料表')

@section('content')
	<h1>課程建置表格</h1>
	<form method="POST" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label for="year">年分</label>
			<select type="text" class="form-control" id="year" name="year">
			</select>
		</div>

		<div class="form-group">
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
			<small id="uploadHelp" class="form-text form-muted">請選擇一個xls(x)檔案進行上傳</small>
		</div>

		<!-- 存放課程 -->
		<div id="classes">
		</div>

		<div class="form-group" id="addClassBtn">
			<button type="button" class="btn btn-info">新增課程</button>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary" id="postBtn" >建立課程表</button>
		</div>
	</form>

	@if ($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	@endif
	@if ($error = Session::get('error'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $error }}</strong>
		</div>
	@endif

	<script>
		//生成年分選項
		for(var y=100;y<=200;y++)
		{
			$('#year').append('<option>'+y+'</option>');
		}

		//動態生成課程選項
		var index = 1;
		$('#addClassBtn').click(function(){
			var text = '<div class="form-group" id="block' + index  +'">' + '\n';
					text += '<label>課程' + index + '</label>' + '\n';
						text += '<div class="form-control">' + '\n';
						//課程名稱
						text += '<label for="c' + index + '">課程名稱' + '</label>' + '\n';
						text += '<input type="text" id="block' + index + 'c" name="c' + index + '" value="課程' + index +  '" >' + '\n';
						//課程日期
						text += '<div class="form-group">' + '\n';
						text += '<label for="y' + index + '">星期</label>'  + '\n';
						text += '<select type="text" class="form-control" id="block' + index + 'y" name="y' + index + '" >' + '\n';
						text += '<option>1</option>' + '\n';
						text += '<option>2</option>' + '\n';
						text += '<option>3</option>' + '\n';
						text += '<option>4</option>' + '\n';
						text += '<option>5</option>' + '\n';
						text += '<option>0</option>' + '\n';
						text += '</select>' + '\n';
						text += '</div>' + '\n';
						//刪除按鈕
						text += '<button class="btn btn-info" type="button" onclick="$(\'#block' + index + '\').remove();"' + '>刪除</button>' + '\n';
						text += '</div>' + '\n';
					text += '</div>' + '\n';
			$('#classes').append(text);	
			index++;
		});
	</script>
@endsection
