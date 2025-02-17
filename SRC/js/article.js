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
	if (isLength(100, "部屋番号", form.room)) { return; }
	if (isLength(200, "鍵場所", form.keyPlace)) { return; }
	if (isLength(100, "住所", form.address)) { return; }
	if (isLength(200, "備考", form.articleNote)) { return; }
	if (isLength(100, "キーBox番号", form.keyBox)) { return; }
	if (isLength(100, "3Dパース", form.drawing)) { return; }
	if (isLength(100, "営業担当者", form.sellCharge)) { return; }


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
