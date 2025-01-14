<?php
//
//ログイン画面
//
function subLogin() {
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
//ログイン確認
//
function subLoginCheck(){
	$id = addslashes($_REQUEST['id']);
	$pw = addslashes($_REQUEST['pw']);

	$conn = fnDbConnect();

	$sql = fnSqlLogin($id,$pw);
	$res = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($res);

	if( $row[0] ) {
		$_COOKIE['cUserNo']   = $row[0];
		$_COOKIE['authority'] = $row[1];
		$_REQUEST['act']      = 'menu';
	} else {
		$_REQUEST['act']    = 'reLogin';
	}
}
?>
