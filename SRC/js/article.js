//
//物件管理チェック
//
function fnArticleEditCheck() {
	tmp = form.article.value;
	if (tmp.length == 0) {
		alert('物件名を入力してください');
		return;
	}
	if (isLength(100, "物件名", form.article)) { return; }

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'articleEditComplete';
		form.submit();
	}
}



function fnArticleDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.articleNo.value = no;
		form.act.value = 'articleDelete';
		form.submit();
	}
}
