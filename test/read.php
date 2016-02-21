<?php
//read.php 01.01.00
//Atnanasi
chdir("..");
$Root = __DIR__;
$Version = "01.01.00";
$ReleaseDate = "2016/02/21";

include "./libboard.php";

//$Config = parse_ini_file("./config.ini",1);

if(isset($_GET["bbs"])) {
	$BoardID = $_GET["bbs"];
}else{
	ThrowError("不正なURL");
}

if(isset($_GET["key"])) {
	if (ThreadExists($BoardID, $_GET["key"])) {
		$ThreadID = $_GET["key"];
		$ThreadDat = file_get_contents("./{$BoardID}/dat/{$_GET["key"]}.dat");
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

//変数設定

//URL
$BBSURL = "../index.php";
$ThisURL = "./read.php";

//名前系
$ThreadName = GetThreadTitle($BoardID, $ThreadID);

$Newer = GetResNumber($BoardID, $ThreadID);
$FileSize = "";

//ページ表示
echo <<< EOT1
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="{$ThreadName}"/>
		<meta property="og:url" content="{$ThisURL}"/>
		<meta property="og:description" content=""/>
		<base href="{$BBSURL}">
		<title>{$ThreadName}</title>
	</head>
	<body bgcolor=#efefef text=black link=blue alink=red vlink=#660099>
		
		<div style='margin-top:1em;'><span style='float:left;'><div style="margin-top:1em;"><span style='float:left;'>
			<a href="{$BBSURL}">トップへ</a>
			<a href="./">■掲示板に戻る■</a>
			<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}">全部</a>
			<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&ls=50">最新50</a>
		</span>
		<span style='float:right;'>
		</span>&nbsp;</div>
		<hr style="background-color:#888;color:#888;border-width:0;height:1px;position:relative;top:-.4em;">
		<h1 style="color:red;font-size:larger;font-weight:normal;margin-right: 185px;word-wrap: break-word;">{$ThreadName}</h1>
		<div><dl class="thread" style="margin-right:185px;word-wrap:break-word; ">

EOT1;
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
		$Data = "<dt>{$ResNum} ：<font color=green><b>{$Parse["Name"]}</b></font>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
	}else{
		$Data = "<dt>{$ResNum} ：<a href=\"mailto:{$Parse["Mail"]}\"><b>{$Parse["Name"]}</b></a>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
	}
	echo "		".$Data;
}

echo <<< EOT2
		
		</div>
		<font color=red face="Arial"><b>{$FileSize}</b></font>
		<hr>
		<center><a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&st={$Newer}">新着レスの表示</a></center>
		<hr>
		<a href="./">■掲示板に戻る■</a>
		<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}">全部</a>
		<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&ls=50">最新50</a>
		<form method=POST action="./test/bbs.php">
			<input type=submit value="書き込む" name="submit">
			名前： <input name=FROM size=19 value="{$FormNAME}">
			E-mail<font size=1> (省略可) </font>: <input name=mail size=19 value="{$FormMAIL}"><br>
			<textarea rows=5 cols=70 wrap=off name="MESSAGE"></textarea>
			<input type=hidden name="bbs" value="{$BoardID}">
			<input type=hidden name="key" value="{$ThreadID}">
		</form>
		<br><br>read.php ver {$Version} {$ReleaseDate} <font color=#FE642E><strong>Atnanasi★</strong></font><br>
		<font color=green><b>Atnanasi ★</b></font> <a href="http://otyakani.xyz/~atnanasi/" target="_blank">BBSreadphp</a>
	</body>
</html>
EOT2;
?>