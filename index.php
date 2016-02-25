<?php
//BBSreadphp 01.02.00
//Atnanasi

include "./config.php";

include "./libboard.php";

$BoardID = "board";

//$Config = parse_ini_file("./{$BoardID}/config.ini",1);

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

$FileSize = "";

$ThreadList = "";
$ThreadData = "";

$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
$ArraySubject = explode("\n", $Subject);
$Cnt = count($ArraySubject);
for( $i=0;$i<$Cnt;$i++ ) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	$ThreadList .= "\n						<a href=\"./test/read.php?bbs={$BoardID}&key={$ThreadID}\" target=\"body\">{$num}:</a>\n";
	$ThreadList .= "\n						<a href=\"#{$num}\"> {$SubjectData["TitleRes"]}</a>\n";
}

for ( $i=0;$i<$Cnt;$i++) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	$ThreadData .=  <<< EOTS1
					<dl class="thread">
						<a name="{$num}"></a>
						<b>【{$num}:{$SubjectData["Res"]}】<font size=5 color="#FF0000"> {$SubjectData["Title"]}</font></b>\n
EOTS1;
	$ThreadDat = file_get_contents("./{$BoardID}/dat/{$ThreadID}.dat");
	$ArrayDats = explode("\n", $ThreadDat);
	
	if ($ResCnt > $SubjectData["Res"]) {
		$ResCnt = $SubjectData["Res"];
	}
	
	for( $t=0;$t<$ResCnt;$t++ ) {

		$ResNum = $t+1;
		$sore = $ArrayDats[$t];
		$Parse=DatParse($sore);
		
		$Text = $Parse["Text"];
	
		if ($Parse["Mail"] === ""){
			$Data = "<dt>{$ResNum} ：<font color=green><b>{$Parse["Name"]}</b></font>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
		}else{
			$Data = "<dt>{$ResNum} ：<a href=\"mailto:{$Parse["Mail"]}\"><b>{$Parse["Name"]}</b></a>：{$Parse["Date"]} {$Parse["Time"]} {$Parse["ID"]}<dd> {$Text} <br><br>\n";
		}
		$ThreadData .= "						".$Data;
	}


//						<font color="green">（省略されました・・全てを読むには<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&st=$Res&to=$Res" target="_blank">ここ</a>を押してください）</font>
	$ThreadData .= <<< EOTS2
						<br><br>
						<dd>
							<form method=POST action="./test/bbs.php?guid=ON">
								<input type=hidden name=bbs value="{$BoardID}">
								<input type=hidden name=key value="{$ThreadID}">
								<input type=submit value="書き込む" name="submit">
								名前：	<input type=text name=FROM size=19 value="{$FormNAME}">
								E-mail：<input type=text name=mail size=19 value="{$FormMAIL}">
								<ul>
									<textarea rows=5 cols=64 wrap=OFF name=MESSAGE></textarea><br>
									<b>
									<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}">全部</a>
									<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&ls=50">最新50</a>
										<a href="#menu">板のトップ</a>
										<a href="./">リロード</a>
									</b>
								</ul>
							</form>
						</dd>
					</dl>\n
EOTS2;
}

$BaseText = file_get_contents("./theme/{$Theme}/index.html");

$ReplaceText = str_replace("#BOARDNAME#", $BoardName, $BaseText);
$ReplaceText = str_replace("#THISURL#", $ThisURL, $ReplaceText);
$ReplaceText = str_replace("#BBSURL#", $BBSURL, $ReplaceText);
$ReplaceText = str_replace("#DESCRIPTION#", $BoardName, $ReplaceText);
$ReplaceText = str_replace("#ABOUTBOARD#", $AboutBoard, $ReplaceText);
$ReplaceText = str_replace("#FORMNAME#", $FormNAME, $ReplaceText);
$ReplaceText = str_replace("#FORMMAIL#", $FormMAIL, $ReplaceText);
$ReplaceText = str_replace("#BOARDID#", $BoardID, $ReplaceText);
$ReplaceText = str_replace("#VERSION#", $Version, $ReplaceText);
$ReplaceText = str_replace("#RELEASEDATE#", $ReleaseDate, $ReplaceText);
$ReplaceText = str_replace("#THREADLIST#", $ThreadList, $ReplaceText);
$ReplaceText = str_replace("#THREADDATA#", $ThreadData, $ReplaceText);

echo $ReplaceText;

?>