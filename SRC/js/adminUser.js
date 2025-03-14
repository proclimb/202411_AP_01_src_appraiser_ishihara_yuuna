//
//ユーザー情報チェック
//
function fnAdminUserEditCheck() {
	tmp = form.name.value;
	if (tmp.length == 0) {
		alert('名前を入力してください');
		return;
	}
	if (tmp.length > 10) {
		alert('名前は10文字以内で入力してください');
		return;
	}

	tmp = form.id.value;
	if (tmp.length == 0) {
		alert('IDを入力してください');
		return;
	}
	if (tmp.length < 4 || tmp.length > 16 || tmp.match(/[^0-9a-zA-Z]+/)) {
		alert('IDは4桁以上16桁以下の半角英数字で入力してください');
		return;
	}

	check = form.userNo.value; // userNoとpasswordの値を取得
	tmp = form.password.value;
	if (check.length == 0 && tmp.length == 0) { // ユーザー番号とパスワードが両方とも空の場合、
		alert('PASSを入力してください'); // アラートを表示
		return; //処理を終了
	}
	if (!tmp.length == 0 && tmp.length < 4 || tmp.length > 16 || tmp.match(/[^0-9a-zA-Z]+/)) { // パスワードが空ではない & 4桁以下 or 16桁以上 or 半角英数字以外の文字が含まれているる場合
		alert('PASSは4桁以上16桁以下の半角英数字で入力してください'); // アラートを表示
		return; //処理を終了
	}

	if (confirm('この内容で登録します。よろしいですか？')) { // ユーザーに確認ダイアログを表示し、「OK」を選択した場合のみフォームを送信
		form.act.value = 'adminUserEditComplete'; // フォームのactionを設定（編集完了）
		form.submit(); // フォーム送信
	}
}

function fnAdminUserDeleteCheck(no, nm) {
	if (confirm('「' + nm + '」を削除します。よろしいですか？')) {
		form.userNo.value = no;
		form.act.value = 'adminUserDelete';
		form.submit();
	}
}
