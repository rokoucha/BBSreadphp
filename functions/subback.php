<?php
$BoardID = $_PATH[0];

//URL
$BBSURL = "index.php";
$ThisURL = "index.php/{$BoardID}";

$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
$ArraySubject = explode("\n", $Subject);
$Cnt = count($ArraySubject);
for( $i=0;$i<$Cnt;$i++ ) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	$list = "\n						<a href=\"/test/read.cgi?bbs={$BoardID}&key={$ThreadID}\" target=\"body\">{$num}:</a>\n";
	$list = "\n						<a href=\"#{$num}\"> {$SubjectData["TitleRes"]}</a>";
}

$BaseText = file_get_contents("pages/board_subback.php");

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

$Out->add($ReplaceText);
