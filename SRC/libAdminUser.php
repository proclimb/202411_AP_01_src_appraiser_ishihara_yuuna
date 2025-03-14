<?php
//
//ユーザー情報画面
//
function subAdminUser()
{
	$conn = fnDbConnect();

	subMenu();
?>
	<h1>ユーザー情報画面</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="adminUser" />
		<input type="hidden" name="userNo" />

		<a href="javascript:form.act.value='adminUserEdit';form.submit();"><img src="./images/btn_enter.png"></a><br />

		<div class="list">
			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th class="list_head">名前</th>
					<th class="list_head">ユーザーID</th>
					<th class="list_head">パスワード</th>
					<th class="list_head">所属</th>
					<th class="list_head">削除</th>
				</tr>
				<?php
				$sql = fnSqlAdminUserList();
				$res = mysqli_query($conn, $sql);

				$i = 0;
				while ($row = mysqli_fetch_array($res)) {
					$userNo    = htmlspecialchars($row[0]);
					$name      = htmlspecialchars($row[1]);
					$id        = htmlspecialchars($row[2]);
					$password  = htmlspecialchars($row[3]);
					$authority = htmlspecialchars($row[4]);
				?>
					<tr>
						<td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='adminUserEdit';form.userNo.value=<?php print $userNo; ?>;form.submit();"><?php print $name; ?></a></td>
						<td class="list_td<?php print $i; ?>"><?php print $id; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $password; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print fnAuthorityName($authority); ?></td>
						<td class="list_td<?php print $i; ?>">
							<a href="javascript:fnAdminUserDeleteCheck(<?php print $userNo; ?>,'<?php print $name; ?>');">削除</a>
						</td>
					</tr>
				<?php
					$i = ($i + 1) % 2;
				}
				?>
			</table>
		</div>
	</form>
<?php
}




//
//ユーザー情報編集画面
//
function subAdminUserEdit()
{
	$conn = fnDbConnect();

	$userNo = $_REQUEST['userNo'];

	if ($userNo) {
		$sql  = fnSqlAdminUserEdit($userNo);
		$res  = mysqli_query($conn, $sql);
		$row  = mysqli_fetch_array($res);

		$name      = htmlspecialchars($row[0]);
		$id        = htmlspecialchars($row[1]);
		$password  = htmlspecialchars($row[2]);
		$authority = htmlspecialchars($row[3]);

		$purpose  = '更新';
		$btnImage = 'btn_load.png';
	} else {
		$purpose = '登録';
		$btnImage = 'btn_enter.png';
	}

	subMenu();
?>
	<script type="text/javascript" src="./js/adminUser.js"></script>

	<h1>ユーザー情報<?php print $purpose; ?></h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" />
		<input type="hidden" name="userNo" value="<?php print $userNo; ?>" />

		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th>名前<span class="red">（必須）</span></th>
				<td><input type="text" name="name" value="<?php print $name; ?>" /></td>
			</tr>
			<tr>
				<th>ID<span class="red">（必須）</span></th>
				<td><input type="text" name="id" value="<?php print $id; ?>" /></td>
			</tr>
			<tr>
				<th>PASS<span class="red">（必須）</span></th>
				<td><input type="text" name="password" value="<?php print $password; ?>" /></td>
			</tr>
			<tr>
				<th>所属</th>
				<td><input type="radio" name="auth" value="0" checked="checked" /> <?php print fnAuthorityName(0); ?>
					<input type="radio" name="auth" value="1" <?php if ($authority == 1) print ' checked="checked"'; ?> /> <?php print fnAuthorityName(1); ?>
				</td>
			</tr>
		</table>

		<a href="javascript:fnAdminUserEditCheck();"><img src="./images/<?php print $btnImage; ?>" /></a>　
		<a href="javascript:form.act.value='adminUser';form.submit();"><img src="./images/btn_return.png" /></a>
	</form>
<?php
}




//
//ユーザー情報編集完了処理
//
function subAdminUserEditComplete()
{
	$conn = fnDbConnect();

	$userNo    = mysqli_real_escape_string($conn, $_REQUEST['userNo']);
	$name      = mysqli_real_escape_string($conn, $_REQUEST['name']);
	$id        = mysqli_real_escape_string($conn, $_REQUEST['id']);
	$password  = mysqli_real_escape_string($conn, $_REQUEST['password']);
	$authority = mysqli_real_escape_string($conn, $_REQUEST['auth']);

	if ($userNo) {
		$sql = fnSqlAdminUserUpdate($userNo, $name, $id, $password, $authority);
		$res = mysqli_query($conn, $sql);
	} else {
		$sql = fnSqlAdminUserInsert(fnNextNo('USER'), $name, $id, $password, $authority);
		$res = mysqli_query($conn, $sql);
	}

	$_REQUEST['act'] = 'adminUser';
	subAdminUser();
}




//
//ユーザー情報削除処理
//
function subAdminUserDelete()
{
	$conn = fnDbConnect();

	$userNo = $_REQUEST['userNo'];

	$sql = fnSqlAdminUserDelete($userNo);
	$res = mysqli_query($conn, $sql);

	$_REQUEST['act'] = 'adminUser';
	subAdminUser();
}
?>