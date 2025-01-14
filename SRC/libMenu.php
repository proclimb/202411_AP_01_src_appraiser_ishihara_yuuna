<?php
//
//メニュー画面
//
function subMenu() {
?>
<form name="menu" action="index.php" method="post">
	<input type="hidden" name="act" />

	<div id="head" class="clearfix">
		<div id="right"><img src="./images/logo.png"></div>

		<div id="left">
			<div id="navi1"><a href="javascript:menu.act.value='stock';menu.submit();"><img src="./images/navi1.png"></a></div>
			<div id="navi2"><a href="javascript:menu.act.value='guide';menu.submit();"><img src="./images/navi2.png"></a></div>
			<div id="navi3"><a href="javascript:menu.act.value='const';menu.submit();"><img src="./images/navi3.png"></a></div>
			<div id="navi4"><a href="javascript:menu.act.value='trade';menu.submit();"><img src="./images/navi4.png"></a></div>
			<div id="navi5"><a href="javascript:menu.act.value='article';menu.submit();"><img src="./images/navi5.png"></a></div>
			<div id="navi6"><a href="javascript:menu.act.value='sell';menu.submit();"><img src="./images/navi6.png"></a></div>
			<div id="navi7"><a href="javascript:menu.act.value='fManager';menu.submit();"><img src="./images/navi7.png"></a></div>
			<?php if($_COOKIE['authority'] == 0) { ?>
				<div id="navi10"><a href="javascript:menu.act.value='fTitle';menu.submit();"><img src="./images/navi10.png"></a></div>
				<div id="navi8"><a href="javascript:menu.act.value='adminUser';menu.submit();"><img src="./images/navi8.png"></a></div>
			<?php } ?>
			<div id="navi9"><a href="javascript:menu.act.value='logout';menu.submit();"><img src="./images/navi9.png"></a></div>
		</div>
	</div>
</form>

<?php
}


//
//メニュー2画面
//
function subMenu2() {
    ?>
<?php
}
?>
