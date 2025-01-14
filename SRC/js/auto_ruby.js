/**
 *  auto_ruby.js var 1.0.0
 *  Presented by 2008 Source Create co.,ltd.(http://www.srce.jp)
 *  Author Akira Yoshimaru(akira@srce.jp)
 *
 * 原本から一部バグを修正されたものを公開していたサイトから流用し、
 * jquery用に修正したものです
 *
 *--------------------------------------------------------------------------*/

//--------設定--------
var convFlag  = 0;			//モードフラグ ひらがな→0、カタカナ→1
var nameField = '#name';	//名前のID
var rubyField = '#ruby';	//カナのID

//--------------------
var baseVal = "";
var beforeVal = "";

function setRuby() {
	var newVal = $( nameField ).val();
	if ( baseVal == newVal ) { return; }
	if ( newVal == "") {
		$( rubyField ).val( "" );
		baseVal = "";
		return;
	}
	var addVal = newVal;
	for( var i=baseVal.length; i >= 0; i-- ) {
		if ( newVal.substr(0,i) == baseVal.substr(0,i) ) {
			addVal = newVal.substr(i);
			break;
		}
	}
	baseVal = newVal;
	if ( addVal.match(/[^ 　ぁあ-んァー]/) ) { return; }
	var flg = 0;
	if ( addVal.match(/^[あ-ん]$/) ) {
		if ( beforeVal == addVal ) { flg = 1; }
		beforeVal = addVal;
	}
	if ( convFlag ) { addVal = convKana(addVal); }
	var q = $( rubyField ).val().slice( -1 * addVal.length );
	if ( flg == 0 && q == addVal ) { return; }
	$( rubyField ).val( $( rubyField ).val() + addVal );
}

function loopTimer() {
	setRuby();
	timer = setTimeout( "loopTimer()", 30 );
}

function convKana( val ) {
	var c, a = [];
	for( var i=val.length-1; 0 <= i; i-- ) {
			c = val.charCodeAt(i);
			a[i] = (0x3041 <= c && c <= 0x3096) ? c + 0x0060 : c;
	}
	return String.fromCharCode.apply( null, a );
}

var timer = false;
$(function() {
	loopTimer();
	$( rubyField ).onkeyup = setRuby();
});

