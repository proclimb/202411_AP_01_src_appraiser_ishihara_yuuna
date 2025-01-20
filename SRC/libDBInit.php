<?php
//
//DB接続
//
function fnDbConnect()
{
	$conn = mysqli_connect('localhost', 'root', 'proclimb') or die('DB接続エラー1です。管理者にご報告をお願いいたします。');
	mysqli_select_db($conn, 'appraiser1') or die('DB接続エラー2です。管理者にご報告をお願いいたします。');
	mysqli_query($conn, 'SET NAMES utf8');

	return ($conn);
}
