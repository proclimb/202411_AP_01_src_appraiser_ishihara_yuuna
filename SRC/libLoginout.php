<?php
//
//ログイン画面
//
function subLogin()
{
?>


	<div class="login_ttl">
		<img src="./images/logo.png">
	</div>


	<form name="form" action="index.php" method="post">
		<input type="hidden" name="act" value="loginCheck" />

		<div class="login_table">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>ユーザーID</th>
					<td><input type="text" name="id" style="ime-mode:disabled;" /></td>
				</tr>
				<tr>
					<th>パスワード</th>
					<td><input type="password" name="pw" /></td>
				</tr>
			</table>
		</div>

		<div class="login_btn">
			<a href="javascript:form.submit();"><img src="./images/btn_login.png"></a>
		</div>
	</form>
<?php
}

//
// ★　ログイン確認（ハッシュ化ver）
//
function subLoginCheck()
{
	$id = addslashes($_REQUEST['id']); //// ユーザーがフォームに入力したIDとパスワードを取得し、SQLインジェクションを防ぐためにエスケープ
	$pw = addslashes($_REQUEST['pw']);

	$conn = fnDbConnect(); // データベース接続を確立

	$sql = fnSqlLogin($id, $pw); // ユーザーIDに基づいてSQLクエリを作成（ログイン情報を取得）
	$res = mysqli_query($conn, $sql); // SQLクエリを実行して結果を取得
	$row = mysqli_fetch_array($res); // 結果から1行分のデータを取得（ユーザー情報）

	if ($row[0] && password_verify($pw, $row['PASSWORD'])) { // ユーザーが存在し、かつ入力されたパスワードがデータベース内のハッシュ化されたパスワードと一致するか確認
		$_COOKIE['cUserNo']   = $row[0]; // ユーザー番号（USERNO）
		$_COOKIE['authority'] = $row[1]; // ユーザー権限（AUTHORITY）
		$_REQUEST['act']      = 'menu'; // ログイン成功後、actを'menu'に設定してメニュー画面に遷移させる
	} else {
		$_REQUEST['act']    = 'reLogin'; // ログイン失敗時、actを'reLogin'に設定して再度ログイン画面を表示
	}
}

//
// ★　ログイン確認
//
// function subLoginCheck()
// {
// $id = addslashes($_REQUEST['id']);
// $pw = addslashes($_REQUEST['pw']);

// $conn = fnDbConnect();

// $sql = fnSqlLogin($id, $pw);
// $res = mysqli_query($conn, $sql);
// $row = mysqli_fetch_array($res);

// if ($row[0]) {
// $_COOKIE['cUserNo']   = $row[0];
// $_COOKIE['authority'] = $row[1];
// $_REQUEST['act']      = 'menu';
// } else {
// $_REQUEST['act']    = 'reLogin';
// }
// }


?>