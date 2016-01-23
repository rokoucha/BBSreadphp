<?php
//libboard 1.00
//Atnanasi

//エラーを表示する
function ThrowError($text) {
	echo <<< ThrowErrorEOT
<html>
	<head>
		<title>エラー</title>
	</head>
	<body>
		<h1>エラー</h1>
		<p>{$text}</p>
	</body>
</html>
ThrowErrorEOT;
	exit;
}

//1行のDatをパースする
function DatParse($Dat) {	
	$DatSplit = preg_split("/<>/", ltrim($Dat));
	$Data["Name"] = $DatSplit[0];
	$Data["Mail"] = $DatSplit[1];
	$DTI = $DatSplit[2];
	$Data["Text"] = $DatSplit[3];

	$DTISprit = preg_split("/ /",$DTI);
	$Data["Date"] = $DTISprit[0];
	$Data["Time"] = $DTISprit[1];
	$Data["ID"] = $DTISprit[2];

	return $Data;
}

//1行のSubject.txtをパースする
function SubjectParse($Subject) {
	$SubjectSplit = preg_split("/<>/", $Subject);
	
	$ThreadSplit = preg_split("/ /", $SubjectSplit[1]);
	preg_match("/\((.+?)\)/", $ThreadSplit[1], $ResNumber);
	
	$Data["Dat"] = $SubjectSplit[0];
	$Data["TitleRes"] = $SubjectSplit[1];
	$Data["Title"] = $ThreadSplit[0];
	$Data["Res"] = $ResNumber[1];
	return $Data;
}

//1行のSubject.txtをパースしてファイル名を返す
function GetDatName ($Subject) {
	$SubjectSplit = preg_split("/<>/", $Subject);
	$DatFile = $SubjectSplit[0];
	return $DatFile;
}

//指定されたSubject.txtをパースしてスレッド名を返す
function GetThreadTitle ($BoardID, $ThreadID) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadName = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadName === $ThreadID.".dat") {
			$SubjectSplit = preg_split("/<>/", $ArraySubject[$i]);
			$ThreadSplit = preg_split("/ /", $SubjectSplit[1]);
			$ThreadName = $ThreadSplit[0];
			return $ThreadName;
		}
	}

}

//指定されたSubject.txtをパースしてレス番号を返す
function GetResNumber ($BoardID, $ThreadID) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadName = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadName === $ThreadID.".dat") {
			$SubjectSplit = preg_split("/<>/", $ArraySubject[$i]);
			$ThreadSplit = preg_split("/ /", $SubjectSplit[1]);
			preg_match("/\((.+?)\)/", $ThreadSplit[1], $ResNumber);
			return $ResNumber[1];
		}
	}
}

//指定されたSubject.txtをパースしてスレッドがあるか確認する
function ThreadExists ($BoardID, $ThreadID) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadName = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadName === $ThreadID.".dat") {
			return true;
		}
	}
	return false;
}

//指定されたスレッドに投稿、Subject.txtのレス番号を変更
function AddRes ($BoardID, $ThreadID, $FROM, $mail ,$MESSAGE) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$Num = GetResNumber($BoardID, $ThreadID)+1;
	SetResNumber($BoardID, $ThreadID, $Num);
	$DatFile = "./{$BoardID}/dat/{$ThreadID}.dat";
	$htmlFROM = htmlspecialchars($FROM);
	$htmlmail = htmlspecialchars($mail);
	$ID = MakeID($_SERVER["REMOTE_ADDR"]);
	$Date = date("Y/m/d(w) H:i:s.00",time());
	$DateJP = preg_replace("/\((.+?)\)/", "(".JapaneseDay(date("w")).")", $Date);
	$BRMESSAGE = \str_replace(array("\r\n", "\r", "\n"),"<br>",htmlspecialchars($MESSAGE));
	$WriteData = "\n {$htmlFROM}<>{$htmlmail}<>{$DateJP} ID:{$ID}<>{$BRMESSAGE}<>";
	$sfp = fopen( $DatFile, "a" );
	fwrite($sfp, $WriteData);
	fclose($sfp);
}

//Subject.txtの指定されたスレッドのレス番号を変更
function SetResNumber ($BoardID, $ThreadID, $Num) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadID = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadID === $ThreadID.".dat") {
			$NewSubject[$i] = preg_replace("/\((.+?)\)/", "(".$Num.")", $ArraySubject[$i])."\n";
		}else{
			$NewSubject[$i] = $ArraySubject[$i]."\n";
		}
	}
	$NewSubject[$Cnt-1] = rtrim($NewSubject[$Cnt-1]);
	$fp=fopen("./".$BoardID."/subject.txt","w");
	foreach ($NewSubject as $a){
		fputs($fp, $a);
	}
	
	fclose($fp);
}

//IPアドレスからIDを生成する
function MakeID ($IP) {
	return $IP;
}

function JapaneseDay ($Day) {
	$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
	return $weekday[$Day];
}

function AddThread ($BoardID, $ThreadName, $FROM, $mail ,$MESSAGE) {
	$Subject = file_get_contents("./".$BoardID."/subject.txt", true);
	$ThreadID = time();
	$sfp = fopen( "./".$BoardID."/subject.txt", "a" );
	fwrite($sfp, "\n{$ThreadID}.dat<>{$ThreadName} (0)");
	fclose($sfp);
	
	touch("./{$BoardID}/dat/".$ThreadID.".dat");
	
	$Num = GetResNumber($BoardID, $ThreadID)+1;
	SetResNumber($BoardID, $ThreadID, $Num);
	$DatFile = "./{$BoardID}/dat/{$ThreadID}.dat";
	$htmlFROM = htmlspecialchars($FROM);
	$htmlmail = htmlspecialchars($mail);
	$ID = MakeID($_SERVER["REMOTE_ADDR"]);
	$Date = date("Y/m/d(w) H:i:s.00",time());
	$DateJP = preg_replace("/\((.+?)\)/", "(".JapaneseDay(date("w")).")", $Date);
	$BRMESSAGE = \str_replace(array("\r\n", "\r", "\n"),"<br>",htmlspecialchars($MESSAGE));
	$WriteData = " {$htmlFROM}<>{$htmlmail}<>{$DateJP} ID:{$ID}<>{$BRMESSAGE}<>{$ThreadName}";
	$sfp = fopen( $DatFile, "w" );
	fwrite($sfp, $WriteData);
	fclose($sfp);
	
	return $ThreadID;
}