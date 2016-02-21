<?php
//bbs.php 01.01.00
//Atnanasi
chdir("..");
$Root = __DIR__;
$Version = "01.01.00";
$ReleaseDate = "2016/02/21";

include "./libboard.php";

$NoName = "名無しさん";

$CryptKey = "725d1fa4-59b5-418d-a8bf-dbd53e0dd8c0";
$expires = 100000;

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
	AddResToThread($CryptKey, $bbs, $key, $submit, $FROM, $mail, $MESSAGE, $expires, $NoName);
}elseif (isset($_POST["subject"])) {
	$subject = $_POST["subject"];
	NewThread($CryptKey, $bbs, $subject, $submit, $FROM, $mail, $MESSAGE, $expires, $NoName);
}else{
	ThrowError("不正なヘッダ");
}

//レス
function AddResToThread ($CryptKey, $bbs, $key, $submit, $FROM, $mail, $MESSAGE, $expires, $NoName) {
	$BoardID = $bbs;
	$ThreadID = $key;
	if (ThreadExists($BoardID, $key) === 0) {
		ThrowError("存在しないThreadID");
	}

	setcookie("SETCOOKIE", "OK", time()+$expires);
	setcookie("NAME", $FROM, time()+$expires);
	setcookie("MAIL", $mail, time()+$expires);
	setcookie("EXPIRES", time()+$expires, time()+$expires);
	
	if ($FROM === "") {
		$FROM = $NoName;
	}
	
	AddRes($CryptKey, $BoardID, $ThreadID, $FROM, $mail, $MESSAGE);
	
	echo <<< EOT1
<html>
<head>
<title>書きこみました。</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content=5;URL=./read.php?bbs={$BoardID}&key={$ThreadID}&ls=50 http-equiv=refresh>
</head>
<body>書きこみが終わりました。<br><br>
画面を切り替えるまでしばらくお待ち下さい。<br><br>
<br><br><br><br><br>
<center>
</center>
</body>
</html>
EOT1;
}

//スレ
function NewThread ($CryptKey, $bbs, $subject, $submit, $FROM, $mail, $MESSAGE, $expires, $NoName) {
	$BoardID = $bbs;
	$ThreadName = $subject;
	
	setcookie("SETCOOKIE", "OK", time()+$expires);
	setcookie("NAME", $FROM, time()+$expires);
	setcookie("MAIL", $mail, time()+$expires);
	setcookie("EXPIRES", time()+$expires, time()+$expires);
	
	if ($FROM === "") {
		$FROM = $NoName;
	}
	
	$ThreadID = AddThread($CryptKey, $BoardID, $ThreadName, $FROM, $mail, $MESSAGE);
	
	echo <<< EOT2
<html>
<head>
<title>書きこみました。</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content=5;URL=./read.php?bbs={$BoardID}&key={$ThreadID}&ls=50 http-equiv=refresh>
</head>
<body>書きこみが終わりました。<br><br>
画面を切り替えるまでしばらくお待ち下さい。<br><br>
<br><br><br><br><br>
<center>
</center>
</body>
</html>
EOT2;
}
?>
