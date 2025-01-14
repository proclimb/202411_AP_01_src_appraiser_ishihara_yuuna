//
//ファイルマネージャー物件管理チェック
//
function fnFManagerEditCheck() {
	tmp = form.name.value;
	if (tmp.length == 0) {
		alert('物件名を入力してください');
		return;
	}
	if (tmp.length > 50) {
		alert('物件名は50文字以内で入力してください');
		return;
	}

	tmp = form.room.value;
	if (tmp.length > 50) {
		alert('部屋は50文字以内で入力してください');
		return;
	}

	tmp = form.note.value;
	if (tmp.length > 100) {
		alert('備考は100文字以内で入力してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'fManagerEditComplete';
		form.submit();
	}
}

function fnFManagerDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.fMNo.value = no;
		form.act.value = 'fManagerDelete';
		form.submit();
	}
}



//
//ファイルマネージャー書類チェック
//
function fnFManagerViewEditCheck() {
	tmp = form.note.value;
	if (tmp.length > 100) {
		alert('備考は100文字以内で入力してください');
		return;
	}

	tmp = form.pdfFile.value;
	if (!form.pdfNo.value && tmp.slice(-4) != '.pdf' && tmp.slice(-4) != '.PDF') {
		alert('PDFファイルを指定してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'fManagerViewEditComplete';
		form.submit();
	}
}



function fnFManagerViewDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.pdfNo.value = no;
		form.act.value = 'fManagerViewDelete';
		form.submit();
	}
}
