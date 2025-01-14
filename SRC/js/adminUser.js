//
//ユーザー情報チェック
//
function fnAdminUserEditCheck(){
	tmp = form.name.value;
	if(tmp.length == 0){
		alert('名前を入力してください');
		return;
	}
	if(tmp.length > 10){
		alert('名前は10文字以内で入力してください');
		return;
	}

	tmp = form.id.value;
	if(tmp.length == 0){
		alert('IDを入力してください');
		return;
	}
	if(tmp.length < 4 || tmp.length > 16 || tmp.match(/[^0-9a-zA-Z]+/)){
		alert('IDは4桁以上16桁以下の半角英数字で入力してください');
		return;
	}

	tmp = form.password.value;
	if(tmp.length == 0){
		alert('PASSを入力してください');
		return;
	}
	if(tmp.length < 4 || tmp.length > 16 || tmp.match(/[^0-9a-zA-Z]+/)){
		alert('PASSは4桁以上16桁以下の半角英数字で入力してください');
		return;
	}

	if(confirm('この内容で登録します。よろしいですか？')){
		form.act.value = 'adminUserEditComplete';
		form.submit();
	}
}



function fnAdminUserDeleteCheck(no,nm){
	if(confirm('「' + nm + '」を削除します。よろしいですか？')){
		form.userNo.value = no;
		form.act.value = 'adminUserDelete';
		form.submit();
	}
}
