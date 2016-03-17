<?php
$Out->Set("read");

if(isset($_GET["bbs"])) {
	$BoardID = $_GET["bbs"];
}elseif(isset ($_PATH[2])){
	$BoardID = $_PATH[2];
}else{
	$ErrorText = "スレッドが分からないよ";
}

if(isset($_GET["key"])) {
	if(ThreadExists($BoardID, $_GET["key"])) {
		$ThreadID = $_GET["key"];
		$ThreadDat = file_get_contents($BoardPath."/".$BoardID."/dat/".$ThreadID.".dat");
	}else{
		ThrowError("指定されたスレッドはない。");
	}
}elseif(isset ($_PATH[3])) {
	if(ThreadExists($BoardPath, $BoardID, $_PATH[3])) {
		$ThreadID = $_PATH[3];
		$ThreadDat = file_get_contents($BoardPath."/".$BoardID."/dat/".$ThreadID.".dat");
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

//名前系
$_SETTING = parse_ini_file($BoardPath."/".$BoardID."/SETTING.TXT");

$ThreadName = GetThreadTitle($BoardPath, $BoardID, $ThreadID);

$Newer = GetResNumber($BoardPath, $BoardID, $ThreadID);
$FileSize = filesize($BoardPath."/".$BoardID."/dat/".$ThreadID.".dat") / 1000;

$ThreadData = "";

//スレ表示
//メールあり <dt>803 ：<a href="mailto:{$Mail}"><b>{$Name}</b></a>：2016/01/22(金) 17:52:57.41 ID:{$ID}<dd> {$Text} <br><br>
//メールなし <dt>804 ：<font color=green><b>{$Name}</b></font>：2016/01/22(金) 19:35:26.24 ID:{$ID}<dd> {$Text} <br><br>
$ArrayDats = explode("\n", $ThreadDat);
$ResCnt = GetResNumber($BoardPath, $BoardID, $ThreadID);

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
