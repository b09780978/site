<!DOCTYPE>
<html>

<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap4 CSS -->
	<link rel="stylesheet" href="/site/css/bootstrap.min.css">
	<!-- jQuery 3.2.1 -->
	<script src="/site/js/jquery-3.2.1.min.js"></script>
	<!-- popper.js 1.12.9 -->
	<script src="/site/js/popper.min.js"></script>
	<!-- bootstrap4 javascript -->
	<script src="/site/js/bootstrap.min.js"></script>

</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="/site">首頁</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbar">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/class">學生選課</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/class/detail">班級選課結果查詢</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/upload">上傳學生資料</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/createStudentTable">建立課程</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/course">課程名單查詢</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/courseEdit">課程編輯</a>
				</li>

				<!--
				<li class="nav-item">
					<a class="nav-link text-white" href="/site/dropStudent">刪除學生資料</a>
				</li>
				-->
			</ul>

			<form class="form-inline my-2 my-lg-0">
				<input class="from-control mr-sm-2" type="search" name="q" placeholder="google搜尋">
				<button id="googleBtn" class="btn btn-outline-success my-2 my-sm-0" onclick="googleSearch()"><font color="white">搜尋</font></button>
			</form>
			<script>
				function googleSearch(){
						var url = 'https://www.google.com/search?q='+$('[name=q]').val();
						window.open(url, '_blank');	
						alert('https://www.google.com?q='+$('[name=q]').val());
				}
			</script>
		</div>
	</nav>

	<div class="container">
		@yield('content')	
	</div>
</body>

</html>
