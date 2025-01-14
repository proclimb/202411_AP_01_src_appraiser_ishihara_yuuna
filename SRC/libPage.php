<?php
//
//ページ処理
//
function fnPage($c,$p,$a){
	$pages = (int)(($c - 1) / PAGE_MAX ) + 1;

	if($pages < $p){
		$p--;
	}

	if($p > 1 && $pages > 1){
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.sPage.value=<?php print $p - 1;?>;form.submit();">前へ</a> |
<?php
	}

	if($p - 4 < 1 || $pages < 10){
		$min = 1;
	}else{
		if($pages - $p < 4){
			$min = $pages - 7;
		}else{
			$min = $p - 4;
		}
	}

	if($p + 4 > $pages || $pages < 10){
		$max = $pages;
	}else{
		if($p < 5){
			$max = 9;
		}else{
			$max = $p + 4;
		}
	}

	for($i = $min;$i <= $max;$i++){
		if($p == $i){
?>
<?php print $i;?> |
<?php
		}else{
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.sPage.value=<?php print $i;?>;form.submit();"><?php print $i;?></a> |
<?php
		}
	}

	if($p < $pages){
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.sPage.value=<?php print $p + 1;?>;form.submit();">次へ</a>
<?php
	}
?>
検索結果：<?php print $c;?>件<br />
<?php
	return($p);
}




//
//オーダー処理
//
function fnOrder($n,$a){
	if($_REQUEST['orderBy'] == $n && $_REQUEST['orderTo'] == 'asc'){
?>
<span class="red">▲</span>
<?php
	}else{
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.orderBy.value='<?php print $n;?>';form.orderTo.value='asc';form.sPage.value=1;form.submit();">▲</a>
<?php
	}

	if($_REQUEST['orderBy'] == $n && $_REQUEST['orderTo'] == 'desc'){
?>
<span class="red">▼</span>
<?php
	}else{
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.orderBy.value='<?php print $n;?>';form.orderTo.value='desc';form.sPage.value=1;form.submit();">▼</a>
<?php
	}
}




//
//オーダー処理（工事管理表：工期用）
//
function fnOrderConstWork($n1,$n2,$a){
	if($_REQUEST['orderBy'] == $n1){
?>
<span class="red">▲</span>
<?php
	}else{
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.orderBy.value='<?php print $n1;?>';form.orderTo.value='asc';form.sPage.value=1;form.submit();">▲</a>
<?php
	}

	if($_REQUEST['orderBy'] == $n2){
?>
<span class="red">▼</span>
<?php
	}else{
?>
<a href="javascript:form.act.value='<?php print $a;?>';form.orderBy.value='<?php print $n2;?>';form.orderTo.value='asc';form.sPage.value=1;form.submit();">▼</a>
<?php
	}
}




//
//
//
function fnAuthorityName($n){
	$tmp[0] = '管理者';
	$tmp[1] = '一般';

	return($tmp[$n]);
}




//
//
//
function fnRankName($n){
	return(substr('ABCDEFGHIJKLMNOPQRSTUVWXY ',$n,1));
}




//
//
//
function fnDistanceName($n){
	$tmp[0] = 'A（5分以内）';
	$tmp[1] = 'B（10分以内）';
	$tmp[2] = 'C（15分以内）';
	$tmp[3] = 'D（15分以上）';

	return($tmp[$n]);
}




//
//
//
function fnHowName($n){
	$tmp[0] = '会社案件';
	$tmp[1] = '新規業者（TEL,FAX）';
	$tmp[2] = '新規業者（訪問）';
	$tmp[3] = '既存業者（契約有）';
	$tmp[4] = '既存業者（契約無）';
	$tmp[5] = 'その他';

	return($tmp[$n]);
}




//
//
//
function fnConstFlgName($n){
	$tmp[0] = '工事前';
	$tmp[1] = '工事中';
	$tmp[2] = '工事終了';
	$tmp[3] = '物件終了';

	return($tmp[$n]);
}




//
//
//
function fnContentName($n){
	$tmp[0] = '案内';
	$tmp[1] = 'OP';
	$tmp[2] = '下見';

	return($tmp[$n]);
}




//
//
//
function fnToFormYMD($ymd){
	if($ymd){
		return(str_replace('-','/',substr($ymd,0,10)));
	}else{
		return;
	}
}




//
//
//
function fnToFormH($h){
	if($h){
		return(substr($h,11,2));
	}else{
		return;
	}
}




//
//
//
function fnToFormM($m){
	if($m){
		return(substr($m,14,2));
	}else{
		return;
	}
}




//
//
//
function fnToSqlYMDHM($ymd,$h,$i){
	if($ymd <> '' && $h <> '' && $i <> ''){
		$h = substr('00'.$h,-2);
		$i = substr('00'.$i,-2);
		return($ymd." $h:$i:00");
	}else{
		return;
	}
}




//
//
//
function fnNumFormat($n){
	$y = '';
	if($n){
		while(strlen($n) > 3){
			$y = ','.substr($n,-3,3).$y;
			$n = substr($n,0,strlen($n) - 3);
		}
		$y = $n.$y;
	}

	return($y);
}
?>