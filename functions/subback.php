<?php
//BBSreadphp 01.01.01
//Atnanasi
$Root = __DIR__;
$Version = "01.01.01";
$ReleaseDate = "2016/2/22";

include "./libboard.php";

$BoardID = "board";

$BoardName = "BBSreadphp";

//URL
$BBSURL = "./index.php";
$ThisURL = "./index.php";



echo <<< EOT1
<html lang="ja">
	<head>
		<title>{$BoardName}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<base href="{$ThisURL}">
		<style type="text/css"><!--
			a { margin-right: 1em; }div.floated { border: 1px outset honeydew; float: left; height: 20em; line-height: 1em; margin: 0 0 .5em 0; padding: .5em; }div.floated, div.block { background-color: honeydew; }div.floated a, div.block a { display: block; margin-right: 0; text-decoration: none; white-space: nowrap; }div.floated a:hover, div.block a:hover { background-color: cyan; }div.floated a:active, div.block a:active { background-color: gold; }div.right { clear: left; text-align: right; }div.right a { margin-right: 0; }div.right a.js { background-color: dimgray; border: 1px outset dimgray; color: palegreen; text-decoration: none; }
			-->
		</style>
	</head>
	<body>
		<div>
			<small id="trad">
EOT1;

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

echo <<< EOT2
			</small>
		</div>
	</body>
</html>
EOT2;
