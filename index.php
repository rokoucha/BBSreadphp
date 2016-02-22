<?php
//BBSreadphp 01.01.01
//Atnanasi
$Root = __DIR__;
$Version = "01.01.01";
$ReleaseDate = "2016/02/22";

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

$ResCnt = 5;

//URL
$BBSURL = "./index.php";
$ThisURL = "./index.php";

//名前系
$BoardName = "BBSreadphp";
$AboutBoard = "BBSreadphpへようこそ！<br>ゆっくりしていってね<br>";

$FileSize = "";

echo <<< EOT1
<html>
	<head>
		<title>{$BoardName}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="{$BoardName}"/>
		<meta property="og:url" content="{$ThisURL}"/>
		<meta property="og:description" content=""/>
		<base href="{$ThisURL}">
		<style>body{margin:0;padding:0;}
		</style>
	</head>
	<body text=#000000 bgcolor="#FFFFFF" link=#0000FF alink=#FF0000 vlink=#660099>
		<div align=center>
			<a href="index.php" border=0>BBSreadphp</a>
		</div>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor=#CCFFCC align=center>
			<tr>
				<td align=center>
					<table border=0 cellpadding=1 width=100%>
						<tr>
							<td nowrap COLSPAN=2>
								<font size=+1>
									<b>BBSreadphp</b>
								</font>
								<br>
							</td>
							<td nowrap width=5% align=right valign=top>
							</td>
						</tr>
						<tr>
							<td colspan=3>
EOT1;

//掲示板です。<br>
echo "\n								".$AboutBoard."\n";
echo <<< EOT2
							</td>
						</tr>
						<tr>
							<td nowrap align=right>
							</td>
						</tr>
					</table>
					<b>
						<a href=./topost/>書き込む前に読んでね</a>
						 | 
						<a href=./howtouse/>BBSreadphpガイド</a>
						 | 
						<a href="./faq/">FAQ</a>
					</b>
				</td>
			</tr>
		</table>
		<br>
		<a name="menu"></a>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor="#CCFFCC"align=center>
			<tr>
				<td>
					<font size=2>
						<div align="left">
							<a href="subback.php">
								<b>スレッド一覧はこちら</b>
							</a>
						</div>
EOT2;

$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
$ArraySubject = explode("\n", $Subject);
$Cnt = count($ArraySubject);
for( $i=0;$i<$Cnt;$i++ ) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	echo "\n						<a href=\"./test/read.php?bbs={$BoardID}&key={$ThreadID}\" target=\"body\">{$num}:</a>\n";
	echo "\n						<a href=\"#{$num}\"> {$SubjectData["TitleRes"]}</a>";
}

echo <<< EOT3
					</font>
				</td>
			</tr>
		</table>
		<br>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor="#EFEFEF" align=center>
			<tr>
				<td>
EOT3;

for ( $i=0;$i<$Cnt;$i++) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	echo <<< EOTS1
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
		echo "						".$Data;
	}


//						<font color="green">（省略されました・・全てを読むには<a href="./test/read.php?bbs={$BoardID}&key={$ThreadID}&st=$Res&to=$Res" target="_blank">ここ</a>を押してください）</font>
	echo <<< EOTS2
						<br><br>
						<dd>
							<form method=POST action="./test/bbs.php?guid=ON">
								<input type=hidden name=bbs value={$BoardID}>
								<input type=hidden name=key value={$ThreadID}>
								<input type=submit value="書き込む" name="submit">
								名前：	<input type=text name=FROM size=19 value={$FormNAME}>
								E-mail：<input type=text name=mail size=19 value={$FormMAIL}>
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
					</dl>
EOTS2;
}

echo <<< EOT4
				</td>
			</tr>
		</table><br>
		<center>
			<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor=#CCFFCC align=center>
				<tr>
					<td>
						<form method=POST action="./test/bbs.php">
							<td nowrap>
								タイトル：<input type=text name=subject size=40>
								<input type=submit value="新規スレッド作成" name=submit><br>
								名前：<input type=text name=FROM size=19 value={$FormNAME}>
								E-mail：<input type=text name=mail size=19 value={$FormMAIL}><br>
								内容：<textarea rows=5 cols=60 wrap=OFF name=MESSAGE></textarea>
								<input type=hidden name=bbs value={$BoardID}>
							</td>
						</form>
					</td>
				</tr>
			</table>
		</center>
		<p style="text-align: center; color: #333;">
			<a href="#">BBSreadphp</a> index.php {$Version} - {$ReleaseDate}<br>
		 </p>
	</body>
</html>

EOT4;
?>