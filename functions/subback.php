<?php
$Out->Set("board_subback");

$list = "";

$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
$ArraySubject = explode("\n", $Subject);
$Cnt = count($ArraySubject);
for( $i=0;$i<$Cnt;$i++ ) {
	$SubjectData = SubjectParse($ArraySubject[$i]);
	$ThreadID = str_replace(".dat", "", $SubjectData["Dat"]);
	$num = $i+1;
	$list .= "<a href=\"{$ThreadID}/l50\">{$num}: {$SubjectData["Title"]} ({$SubjectData["Res"]})</a>\n";
}

$ThreadList = $list;
