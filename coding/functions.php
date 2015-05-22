<?php

	/* htmlspecialchars短縮化
	----------------------------------*/
	function h($string) {
		return htmlspecialchars($string, ENT_QUOTES);
	}

	/* リダイレクト
	----------------------------------*/
	function redirectTo($url) {
		header('Location: ' . $url);
		exit;
	}

	/* 入力有無存在チェック
	----------------------------------*/
	$errors = array();
	function has_presence($value) {
		//あった場合は true
		return isset($value) && $value !== '';
	}

	//入力有無チェックループ
	function validate_presences( $required_fields ) {

		global $errors;	//this is must!

		foreach( $required_fields as $field ) {
			$value = trim($_POST[$field]);
			if( !has_presence($value) ) {
				$errors['req_' . $field] = '入力必須項目です';
			}
		}
	}

	/* 最大値チェック (true or false)
	----------------------------------*/
	function has_max_length($val, $max) {
		return mb_strlen($val, 'utf-8') <=  $max;
	}

	// 最大値チェックループ
	function validate_maxleng($lengthArr) {

		global $errors;	//this is must!

		foreach( $lengthArr as $field => $max ) {
			$value = trim($_POST[$field]);	//trim any whitespace

			if( !has_max_length($value, $max) ) {
				$over = mb_strlen($value, 'utf-8') - $max;
				$errors['max_' . $field] = '入力した文字が長すぎます('.$over.'文字オーバー)';
			}
		}
	}

	/* Eメール書式チェック
	----------------------------------*/
	function emailFormat($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/* inputチェック
	----------------------------------*/
	function checkInput($var) {
		if( is_array( $var ) ) {
			//第1ステップ : $_POSTが渡ってくるのでまず自分自信で処理
			//配列から配列に格納されている１つ１つの値を、第１引数に指定した関数(checkInput)に引っ掛けてチェック。
			//今度はここはパスされて、elseの方へ行く。
			return array_map( 'checkInput', $var );
		} else {
			//第２ステップ: 値に変換されたときの処理
			if( get_magic_quotes_gpc() ) {
				//廃止予定のmagic_quotes_gpcがサーバでONになっているかどうかチェック
				//またmagic...は変なスラッシュを挿入するので、取る
				$var = stripslashes( $var );
			}
			if( preg_match('/\0/', $var) ) {
				die('不正な入力が指定されています。');
			}
			if( !mb_check_encoding($var, 'UTF-8') ) {
				die('不正なエンコードです。');
			}
			//すべてクリア！
			return $var;
		}
	}

?>