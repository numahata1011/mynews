<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>ローディングページ</title>
<meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/load.css') }}">
</head>

<body>
	<div id="splash">
		<div id="splash_text"></div>
	</div>

	<main>
        <div id="container">
		<p>ローディング後、この画面。</p>
	</div>
	</main>
<!--==============JQuery読み込み===============-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
<script src="{{ asset('js/load.js') }}"></script>
</body>
</html>