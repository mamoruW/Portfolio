<?php

session_start();

function error_msg() {
	if( isset($_SESSION['error_msg']) ) {
		//SESSIONがいじられている可能性を加味して htmlentities()する
		$output = '<p id="errorMsg">' . htmlspecialchars( $_SESSION['error_msg'] ) . '</p>';

		//clear message after use.
		$_SESSION['error_msg'] = null;

		return $output;
	}
}

?>