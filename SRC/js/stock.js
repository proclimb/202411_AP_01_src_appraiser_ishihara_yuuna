//
//仕入管理チェック
//
function fnStockEditCheck(){
	tmp = form.charge.value;
	if(tmp.length > 100){
		alert('担当は100文字以内で入力してください');
		return;
	}

	tmp = form.article.value;
	if(tmp.length == 0){
		alert('物件名を入力してください');
		return;
	}
	if(tmp.length > 100){
		alert('物件名は100文字以内で入力してください');
		return;
	}

	tmp = form.articleFuri.value;
	if(tmp.length > 100){
		alert('物件名（よみ）は100文字以内で入力してください');
		return;
	}

	tmp = form.room.value;
	if(tmp.length > 100){
		alert('部屋は100文字以内で入力してください');
		return;
	}

	tmp = form.area.value;
	if(tmp.length > 6 || tmp.match(/[^0-9\.]+/)){
		alert('面積は3桁以内（小数点以下2桁以内）の半角数字で入力してください');
		return;
	}

	tmp = form.station.value;
	if(tmp.length > 100){
		alert('最寄駅は100文字以内で入力してください');
		return;
	}

	tmp = form.agent.value;
	if(tmp.length > 100){
		alert('業者名は100文字以内で入力してください');
		return;
	}

	tmp = form.store.value;
	if(tmp.length > 100){
		alert('店舗名は100文字以内で入力してください');
		return;
	}

	tmp = form.cover.value;
	if(tmp.length > 100){
		alert('担当者は100文字以内で入力してください');
		return;
	}

	if( !fnYMDCheck( "正しい内見日付", form.visitDT ) ) { return; }

	tmp = form.deskPrice.value;
	if(tmp.length > 5 || tmp.match(/[^0-9]+/)){
		alert('机上金額は5桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.vendorPrice.value;
	if(tmp.length > 5 || tmp.match(/[^0-9]+/)){
		alert('売主希望金額は5桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.note.value;
	if(tmp.length > 1000){
		alert('備考は1000文字以内で入力してください');
		return;
	}

	if(confirm('この内容で登録します。よろしいですか？')){
		form.act.value = 'stockEditComplete';
		form.submit();
	}
}



function fnStockDeleteCheck(no){
	if(confirm('削除します。よろしいですか？')){
		form.stockNo.value = no;
		form.act.value = 'stockDelete';
		form.submit();
	}
}



//
//仕入管理一括削除用チェックボックス全選択
//
function fnStockListDeleteAllCheck(){
	if (!document.form.delStock) {
		// 検索結果が0件の場合は何もしない
		return;
	}

	if (document.form.delStock.length) {
		// 検索結果が複数レコードの場合
		for(count = 0; count < document.form.delStock.length; count++){
			document.form.delStock[count].checked = document.form.delStockAll.checked;
		}
	} else {
		// 検索結果が１件の場合
		document.form.delStock.checked = document.form.delStockAll.checked;
	}
}



//
// 仕入管理一括削除
//
function fnStockListDeleteCheck(){
	// 削除対象のStockNo受け渡し用
	var stockList = "";

	form.delStockList.value = "";

	if (document.form.delStock.length) {
		// 検索結果が複数レコードの場合
		for(count = 0; count < document.form.delStock.length; count++){
			if(document.form.delStock[count].checked) {
				// 複数件選択されている場合には「,」で区切る
				if (stockList != "") {
					stockList += ",";
				}
				stockList += document.form.delStock[count].value;
			}
		}
	} else {
		// 検索結果が１件の場合
		if (document.form.delStock.checked) {
			stockList += document.form.delStock.value;
		}
	}

	if (stockList == "") {
		alert('削除対象が未選択です。');
		return;
	}

	if(confirm('削除します。よろしいですか？')){
		form.delStockList.value = stockList;
		form.act.value = 'stockListDelete';
		form.submit();
	}
}
