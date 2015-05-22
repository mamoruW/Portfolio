<?php require_once 'sessions.php'; ?>
<?php require_once 'functions.php'; ?>
<?php

ini_set('session.bug_compat_42', 0);

/* submitチェック
----------------------------------*/
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) ){

	/* バリデーション
	----------------------------------*/
	//required
	$required_fields = array('name','email','msg','quiz');
	//必須項目の存在を有効化
	validate_presences($required_fields);

	//maxlength
	$field_with_max_length = array(
		'name'		=> 100,
		'email'		=> 254,
		'msg'		=> 1000,
		'quiz'		=> 100
	);
	//最大値チェック
	validate_maxleng($field_with_max_length);


	/* セキュリティ
	----------------------------------*/
	$_POST = checkInput($_POST);


	/* Eメール書式チェック
	----------------------------------*/
	if( !emailFormat($_POST['email']) ){
		$errors['format_email'] = 'メールアドレスの書式が違います';
	}


	//変数セット
	$name		= isset( $_POST['name'] )	? $_POST['name']	: NULL;
	$email		= isset( $_POST['email'] )	? $_POST['email']	: NULL;
	$msg		= isset( $_POST['msg'] )	? $_POST['msg']		: NULL;
	$quiz		= isset( $_POST['quiz'] )	? $_POST['quiz']	: NULL;


	//セッション変数に格納
	$_SESSION['name']		= $name;
	$_SESSION['email']		= $email;
	$_SESSION['msg']		= $msg;
	$_SESSION['quiz']		= $quiz;

	$_SESSION['ticketPOST'] = $_POST['ticket'];


	/* ノーエラー
	----------------------------------*/
	if( empty($errors) ) {
		//プレビューへのファイルパスを取得してリダイレクト
		$previewPage = dirname($_SERVER['SCRIPT_NAME']);
		$previewPage = ($previewPage == DIRECTORY_SEPARATOR) ? '' : $previewPage;
		$uri = 'http://' . $_SERVER['SERVER_NAME'] . $previewPage . '/preview.php';
		header('HTTP/1.1 303 See Other');
		redirectTo($uri);
		exit;
	}

	/* なんらかのエラーがあった…
	----------------------------------*/
	$error_msg = '入力内容にエラーがありました。もう一度確認してください。';
}//submit(POST)


/* ワンタイムチケット発行(submitチェック後でやること)
----------------------------------*/
//このサイトからのセッションかどうかを判断させるセキュリティ対策
//mt_rand()は今回プリフィックスとして使用し、uniqidで
$ticket = md5(uniqid(mt_rand(),true));

//チケットをセッション配列変数に保存。確認画面で使います。
$_SESSION['ticket'] = $ticket;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Portfolio</title>
	<link rel="stylesheet" href="../css/reset.css" /><!-- リセットcss -->
	<link rel="stylesheet" href="../css/common.css"><!-- 共通css -->
	<link rel="stylesheet" href="../css/style.css"><!-- 個別css -->
	<link href='http://fonts.googleapis.com/css?family=Jacques+Francois+Shadow' rel='stylesheet' type='text/css'><!-- webfont読み込み -->
<!-- 	<link href='http://fonts.googleapis.com/css?family=Fredericka+the+Great|Henny+Penny|Jacques+Francois+Shadow' rel='stylesheet' type='text/css'> -->
</head>
<body>
<div id="wrapper">
	<header id="top">
		<nav>
			<ul>
				<li><a href="#top">top</a></li>
				<li><a href="#about">about</a></li>
				<li><a href="#works">works</a></li>
				<li><a href="#contact">contact</a></li>
			</ul>
		</nav>
	</header>

	<section id="key" class="blur">
		<h1 id="title">PORTFOLIO</h1>
<!-- 		<video autoplay loop muted controls>
			<source src="../video/fireplace_Mon.webm" type="video/webm" />
			<source src="../video/fireplace_Mon.mp4" type="video/mp4" />
			<p>この動画はお使いのブラウザに対応していないので表示できません。</p>
		</video>
 -->	</section>

	<section id="about" class="blur">
		<div id="sheet">
			<h1>about</h1>
			<p class="textAnimate">村上  護<br>
				mamoru  murakami</p>
			<p class="textAnimate">1990年生まれ。<br>
				現在東京にてフロントエンドエンジニアになるために勉強中。デザイン,UI/UX,動きが面白くて優れているWEBやスマホアプリなどプログラミング言語で出来たもの全般が好き。<br>将来的には、どんなに面白くて難しいアイデアが浮かんだ時でも、それを実現または昇華させるための技術の引き出しを増やすために日々勤しんでおります。<br>つまり、ヒッキー。ただし、スポーツなどのアウトドアも結構好き。インドアももちろん好き。</p>
			<div class="sheetInner">
				<dl>
					<dt class="textAnimate">好きなもの</dt>
					<dd class="textAnimate">WEB開発、心理学、猫</dd>
				</dl>
				<dl>
					<dt class="textAnimate">嫌いなもの</dt>
					<dd class="textAnimate">タバコの煙などなど<!-- 、ナルシスト(ガチ勢) --></dd>
				</dl>
			</div>
			<div class="sheetInner">
				<dl>
					<dt class="textAnimate">現在勉強中またはすごく気になっているもの</dt>
					<dd class="table">
						<dl>
							<div class="cell w340">
								<dt class="textAnimate">勉強中</dt>
								<dd>
									<ul>
										<li class="textAnimate">AngularJS , javascript , canvas , SVG</li>
									</ul>
								</dd>
							</div>
							<div class="cell w340">
								<dt class="textAnimate">気になる</dt>
								<dd>
									<ul>
										<li class="textAnimate">jade , Coffeescript , WebGL , node.js</li>
									</ul>
								</dd>
							</div>
						</dl>
					</dd>
				</dl>
<!-- 				<dl>
					<dt>尊敬する人</dt>
					<dd>松岡修造さん</dd>
				</dl>
				<dl>
					<dt>座右の銘</dt>
					<dd>もっと熱くなれよ！！<span>by 松岡修造</span></dd>
				</dl>
 -->
 			</div>
			<h2>skill</h2>
			<div class="conteiner table">
				<div id="skill">
					<ul>
						<li class="htmlSkill">HTML</li>
						<li class="cssSkill">CSS(SCSS)</li>
						<li class="jsSkill">javascript</li>
						<li class="jqSkill">jQuery</li>
						<li class="illustSkill">Illustrator</li>
						<li class="photoSkill">Photoshop</li>
						<li class="phpSkill">PHP</li>
					</ul>
				</div><!-- /#skill -->
				<div id="code">
<!-- 					<p data-height="306" data-theme-id="10544" data-slug-hash="oXNKZN" data-default-tab="result" data-user="M_M_" class='codepen'>See the Pen <a href='http://codepen.io/M_M_/pen/oXNKZN/'>oXNKZN</a> by M_M_ (<a href='http://codepen.io/M_M_'>@M_M_</a>) on <a href='http://codepen.io'>CodePen</a>.</p>
<script async src="//assets.codepen.io/assets/embed/ei.js"></script>
 -->
<!-- 					<p data-height="310" data-theme-id="10544" data-slug-hash="◯◯◯" data-default-tab="result" data-user="M_M_" class='codepen'>See the Pen <a href='http://codepen.io/M_M_/pen/◯◯◯/'>◯◯◯</a> by M_M_ (<a href='http://codepen.io/M_M_'>@M_M_</a>) on <a href='http://codepen.io'>CodePen</a>.</p>
<script async src="//assets.codepen.io/assets/embed/ei.js"></script>
 -->
 				</div><!-- /#code -->
			</div>
		</div><!-- /#sheet -->
	</section>

	<section id="works" class="blur">
		<div id="corkbord">
			<h1>works</h1>
			<ul>
				<li><a href="work_2015_05_12_1.html"></a></li>
				<li><a href="work_2015_05_08_1.html"></a></li>
				<li><a href="work_2015_05_05_1.html"></a></li>
			</ul>
			<ul>
				<li><a href="work_2015_04_27_1.html"></a></li>
				<li><a href="work_2014_12_08_1.html"></a></li>
				<li><a href="#work"></a></li>
			</ul>
		</div><!-- /#corkbord -->
	</section>

	<section id="contact" class="blur">
		<div id="desk">
		</div><!-- /#desk -->
		<div id="postcard">
			<h1>contact</h1>
			<form action="">
				<input type="text" name="name" maxlength="100" placeholder="名前">
				<input type="email" name="email" maxlength="254" placeholder="メールアドレス">
				<textarea name="msg" cols="28" rows="10" maxlength="2000" placeholder="メッセージ:
"></textarea>
<!-- 				<p>確認</p>
				<input type="text" name="check" placeholder="4+9=?">
 -->				<input type="submit" name="submit" value="送信">
			</form>
		</div><!-- /#postcard -->
	</section>

	<footer id="footer">
		<p><small>Copyright &copy; 2015 All Rights Reserved mamoru murakami</small></p>
	</footer>
</div><!-- /#wrapper -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.easing/1.3/jquery.easing.1.3.min.js"></script>
	<script src="../js/jquery.textAnimation.min.js"></script>
	<script type="text/javascript" src="../js/common.js"></script>
	<script></script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61502274-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>