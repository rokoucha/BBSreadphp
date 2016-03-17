<?php
//共通なヘッダ
if (isset($_POST["bbs"])) {
	$bbs = $_POST["bbs"];
}else{
	ThrowError("不正なヘッダ:bbs");
}
if (isset($_POST["submit"])) {
	$submit = $_POST["submit"];
}else{
	ThrowError("不正なヘッダ:submit");
}
if (isset($_POST["FROM"])) {
	$FROM = $_POST["FROM"];
}else{
	ThrowError("不正なヘッダ:FROM");
}
if (isset($_POST["mail"])) {
	$mail = $_POST["mail"];
}else{
	ThrowError("不正なヘッダ:mail");
}
if (isset($_POST["MESSAGE"])) {
	$MESSAGE = $_POST["MESSAGE"];
}else{
	ThrowError("不正なヘッダ:MESSAGE");
}

//レスかスレか
if (isset($_POST["key"])) {
	$key = $_POST["key"];
	AddResToThread($CryptKey, $bbs, $key, $submit, $FROM, $mail, $MESSAGE);
}elseif (isset($_POST["subject"])) {
	$subject = $_POST["subject"];
	NewThread($CryptKey, $bbs, $subject, $submit, $FROM, $mail, $MESSAGE);
}else{
	ThrowError("不正なヘッダ");
}


//レス
function AddResToThread ($CryptKey, $bbs, $key, $submit, $FROM, $mail, $MESSAGE) {
	global $_GLOBAL, $_PATH, $CookieExpires, $BoardPath, $Out, $ThreadID, $BoardID;
	
	$BoardID = $bbs;
	$ThreadID = $key;
	if (ThreadExists($BoardPath, $BoardID, $key) === 0) {
		ThrowError("存在しないThreadID");
	}
	
	$_SETTING = parse_ini_file($BoardPath."/".$BoardID."/SETTING.TXT");
	
	setcookie("SETCOOKIE", "OK", time()+$CookieExpires);
	setcookie("NAME", $FROM, time()+$CookieExpires);
	setcookie("MAIL", $mail, time()+$CookieExpires);
	setcookie("EXPIRES", time()+$CookieExpires, time()+$CookieExpires);
	
	if ($FROM === "") {
		$FROM = $_SETTING["BBS_NONAME_NAME"];
	}
	
	AddRes($CryptKey, $BoardPath, $BoardID, $ThreadID, $FROM, $mail, $MESSAGE);
	
	$Out->Set("bbs_res");
}

//スレ
function NewThread ($CryptKey, $bbs, $subject, $submit, $FROM, $mail, $MESSAGE) {
	global $_GLOBAL, $_PATH, $CookieExpires, $BoardPath, $Out, $ThreadID, $BoardID;
	$BoardID = $bbs;
	$ThreadName = $subject;
	
	setcookie("SETCOOKIE", "OK", time()+$CookieExpires);
	setcookie("NAME", $FROM, time()+$CookieExpires);
	setcookie("MAIL", $mail, time()+$CookieExpires);
	setcookie("EXPIRES", time()+$CookieExpires, time()+$CookieExpires);
	
	$_SETTING = parse_ini_file($BoardPath."/".$BoardID."/SETTING.TXT");
	
	if ($FROM === "") {
		$FROM = $_SETTING["BBS_NONAME_NAME"];
	}
	
	$ThreadID = AddThread($CryptKey, $BoardPath, $BoardID, $ThreadName, $FROM, $mail, $MESSAGE);
	
	$Out->Set("bbs_thread");
}
?>
