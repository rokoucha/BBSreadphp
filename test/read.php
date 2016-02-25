<?php
//read.php 01.01.01
//Atnanasi
chdir("..");

include "./config.php";

include "./libboard.php";

//$Config = parse_ini_file("./config.ini",1);

$URLData = str_replace($_SERVER["SCRIPT_NAME"]."/", "", $_SERVER["REQUEST_URI"]);
$URLQuery = explode("/",$URLData);

if(isset($_GET["bbs"])) {
	$BoardID = $_GET["bbs"];
}elseif(isset ($URLQuery[0])){
	$BoardID = $URLQuery[0];
}else{
	ThrowError("不正なURL");
}

if(isset($_GET["key"])) {
	if(ThreadExists($BoardID, $_GET["key"])) {
		$ThreadID = $_GET["key"];
		$ThreadDat = file_get_contents("./{$BoardID}/dat/{$_GET["key"]}.dat");
	}else{
		ThrowError("指定されたスレッドはない。");
	}
}elseif(isset ($URLQuery[1])) {
	if(ThreadExists($BoardID, $URLQuery[1])) {
		$ThreadID = $URLQuery[1];
		$ThreadDat = file_get_contents("./{$BoardID}/dat/{$URLQuery[1]}.dat");
	}else{
		ThrowError("指定されたスレッドはない。");
	}
}else{
	ThrowError("不正なURL");
}
	
if (isset($_GET["st"])) {
	$St = $_GET["st"];
}else{
	$St = "";
}

if (isset($_GET["to"])) {
	$To = $_GET["to"];
}else{
	$To = "";
}

if (isset($_GET["ls"])) {
	$Ls = $_GET["ls"];
}else{
	$Ls = "";
}

if (isset($_COOKIE["SETCOOKIE"])) {
	$FormMAIL = $_COOKIE["MAIL"];
	if (isset($_COOKIE["NAME"])) {
		$FormNAME = $_COOKIE["NAME"];
	}else{
		$FormNAME ="";
	}
}else{
	$FormNAME = "";
	$FormMAIL = "";
	setcookie("SETCOOKIE", "", time()-1);
	setcookie("NAME", "", time()-1);
	setcookie("MAIL", "", time()-1);
	setcookie("EXPIRES", "", time()-1);
}

//名前系
$ThreadName = GetThreadTitle($BoardID, $ThreadID);

$Newer = GetResNumber($BoardID, $ThreadID);
$FileSize = "";

$ThreadData = "";

//スレ表示
//メールあり <dt>803 ：<a href="mailto:{$Mail}"><b>{$Name}</b></a>：2016/01/22(金) 17:52:57.41 ID:{$ID}<dd> {$Text} <br><br>
//メールなし <dt>804 ：<font color=green><b>{$Name}</b></font>：2016/01/22(金) 19:35:26.24 ID:{$ID}<dd> {$Text} <br><br>
$ArrayDats = explode("\n", $ThreadDat);
$ResCnt = GetResNumber($BoardID, $ThreadID);

if ($St === "") {
	$i = 0;
}else{
	$i = $St-1;
}

if ($To === "") {
	$Cnt = $ResCnt;
}else{
	$Cnt = $To-1;
}

if (!($Ls === "")) {
	if ($ResCnt < $Ls ) {
		$Cnt = $ResCnt;
	}else{
		$Cnt = $ResCnt-$Ls;
	}
}
	
for( $i;$i<$Cnt;$i++ ) {
	$ResNum = $i+1;
	$sore = $ArrayDats[$i];
	$Parse=DatParse($sore);

	$Text = $Parse["Text"];
	
	if ($Parse["Mail"] === ""){
		$ThreadData .= "			<dt>{$ResNum} ：<font color=green><b>{$Parse["Name"]}</b></font>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
	}else{
		$ThreadData .= "			<dt>{$ResNum} ：<a href=\"mailto:{$Parse["Mail"]}\"><b>{$Parse["Name"]}</b></a>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
	}
}

$BaseText = file_get_contents("./theme/{$Theme}/read.html");

$ReplaceText = str_replace("#BOARDNAME#", $BoardName, $BaseText);
$ReplaceText = str_replace("#THREADNAME#", $ThreadName, $ReplaceText);
$ReplaceText = str_replace("#THREADID#", $ThreadID, $ReplaceText);
$ReplaceText = str_replace("#NEWRES#", $Newer, $ReplaceText);
$ReplaceText = str_replace("#THISURL#", $ThisURL, $ReplaceText);
$ReplaceText = str_replace("#BBSURL#", $BBSURL, $ReplaceText);
$ReplaceText = str_replace("#HOMEURL#", $HomeURL, $ReplaceText);
$ReplaceText = str_replace("#DESCRIPTION#", $BoardName, $ReplaceText);
$ReplaceText = str_replace("#ABOUTBOARD#", $AboutBoard, $ReplaceText);
$ReplaceText = str_replace("#FILESIZE#", $FileSize, $ReplaceText);
$ReplaceText = str_replace("#FORMNAME#", $FormNAME, $ReplaceText);
$ReplaceText = str_replace("#FORMMAIL#", $FormMAIL, $ReplaceText);
$ReplaceText = str_replace("#BOARDID#", $BoardID, $ReplaceText);
$ReplaceText = str_replace("#VERSION#", $Version, $ReplaceText);
$ReplaceText = str_replace("#RELEASEDATE#", $ReleaseDate, $ReplaceText);
$ReplaceText = str_replace("#THREADDATA#", $ThreadData, $ReplaceText);

echo $ReplaceText;

?>