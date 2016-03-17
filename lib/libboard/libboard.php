<?php
//libboard 2.0.0
//Atnanasi

//エラーを表示する
function MakeError($text) {
    $data = <<< ThrowErrorEOT
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
    return $data;
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
	preg_match("/\((.+?)\)$/", $ThreadSplit[1], $ResNumber);
	
	$Data["Dat"] = $SubjectSplit[0];
	$Data["Title"] = $ThreadSplit[0];
	$Data["Res"] = $ResNumber[1];
	return $Data;
}

//1行のSubject.txtをパースしてファイル名を返す
function GetDatName ($Subject) {
	$SubjectSplit = SubjectParse($Subject);
	return $SubjectSplit["Dat"];
}

//指定されたSubject.txtをパースしてスレッド名を返す
function GetThreadTitle ($BoardPath, $BoardID, $ThreadID) {
    $Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
    $ArraySubject = explode("\n", $Subject);
    $Cnt = count($ArraySubject);
    for( $i=0;$i<$Cnt;$i++ ) {
    	$SubjectThreadName = GetDatName($ArraySubject[$i]);
    	if ($SubjectThreadName === $ThreadID.".dat") {
		    $SubjectSplit = SubjectParse($ArraySubject[$i]);
		    $ThreadName = $SubjectSplit["Title"];
		    return $ThreadName;
		}
    }
}

//指定されたSubject.txtをパースしてレス番号を返す
function GetResNumber ($BoardPath, $BoardID, $ThreadID) {
	$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt");
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadName = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadName === $ThreadID.".dat") {
			$SubjectSplit = SubjectParse($ArraySubject[$i]);
			return $SubjectSplit["Res"];
		}
	}
}

//指定されたSubject.txtをパースしてスレッドがあるか確認する
function ThreadExists ($BoardPath, $BoardID, $ThreadID) {
	$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
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

//スレッドを作成して投稿
function AddThread ($CryptKey, $BoardPath, $BoardID, $ThreadName, $FROM, $mail ,$MESSAGE) {
	$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
	$ThreadID = time();
	$sfp = fopen( $BoardPath."/".$BoardID."/subject.txt", "a" );
	fwrite($sfp, "\n{$ThreadID}.dat<>{$ThreadName} (0)");
	fclose($sfp);
	
	touch($BoardPath."/".$BoardID."/dat/".$ThreadID.".dat");
	
	if (strpos($FROM, "#") !== FALSE) {
		$FROMTripKey = substr($FROM, strpos($FROM, "#"), strlen($FROM));
		$Trip = MakeTrip($FROMTripKey);
		$FROMTrip = str_replace($FROMTripKey, $Trip, $FROM);
	}else{
		$FROMTrip = $FROM;
	}
	
	
	$Num = GetResNumber($BoardPath, $BoardID, $ThreadID)+1;
	SetResNumber($BoardPath, $BoardID, $ThreadID, $Num);
	$DatFile = $BoardPath."/".$BoardID."/dat/".$ThreadID.".dat";
	$htmlFROM = htmlescape($FROMTrip);
	$htmlmail = htmlescape($mail);
	$ID = MakeID($_SERVER["REMOTE_ADDR"], $CryptKey);
	$Date = date("Y/m/d(w) H:i:s.00",time());
	$DateJP = preg_replace("/\((.+?)\)/", "(".JapaneseDay(date("w")).")", $Date);
	$BRMESSAGE = \str_replace(array("\r\n", "\r", "\n"),"<br>", htmlescape($MESSAGE));
	$WriteData = " {$htmlFROM}<>{$htmlmail}<>{$DateJP} ID:{$ID}<>{$BRMESSAGE}<>{$ThreadName}";
	$sfp = fopen( $DatFile, "w" );
	fwrite($sfp, $WriteData);
	fclose($sfp);
	
	return $ThreadID;
}

//指定されたスレッドに投稿、Subject.txtのレス番号を変更
function AddRes ($CryptKey, $BoardPath, $BoardID, $ThreadID, $FROM, $mail ,$MESSAGE) {
	$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
	$Num = GetResNumber($BoardPath, $BoardID, $ThreadID)+1;
	SetResNumber($BoardPath, $BoardID, $ThreadID, $Num);
	$DatFile = $BoardPath."/".$BoardID."/dat/".$ThreadID.".dat";

	if (strpos($FROM, "#") !== FALSE) {
		$FROMTripKey = substr($FROM, strpos($FROM, "#"), strlen($FROM));
		$Trip = MakeTrip($FROMTripKey);
		$FROMTrip = str_replace($FROMTripKey, $Trip, $FROM);
	}else{
		$FROMTrip = $FROM;
	}

	$htmlFROM = htmlescape($FROMTrip);
	$htmlmail = htmlescape($mail);
	$ID = MakeID($_SERVER["REMOTE_ADDR"], $CryptKey);
	$Date = date("Y/m/d(w) H:i:s.00",time());
	$DateJP = preg_replace("/\((.+?)\)/", "(".JapaneseDay(date("w")).")", $Date);
	$BRMESSAGE = \str_replace(array("\r\n", "\r", "\n"),"<br>", htmlescape($MESSAGE));
	$WriteData = "\n {$htmlFROM}<>{$htmlmail}<>{$DateJP} ID:{$ID}<>{$BRMESSAGE}<>";
	$sfp = fopen( $DatFile, "a" );
	fwrite($sfp, $WriteData);
	fclose($sfp);
}

//Subject.txtの指定されたスレッドのレス番号を変更
function SetResNumber ($BoardPath, $BoardID, $ThreadID, $Num) {
	$Subject = file_get_contents($BoardPath."/".$BoardID."/subject.txt", true);
	$ArraySubject = explode("\n", $Subject);
	$Cnt = count($ArraySubject);
	for( $i=0;$i<$Cnt;$i++ ) {
		$SubjectThreadID = GetDatName($ArraySubject[$i]);
		if ($SubjectThreadID === $ThreadID.".dat") {
			$NewSubject[$i] = preg_replace("/\((.+?)\)$/", "(".$Num.")", $ArraySubject[$i])."\n";
		}else{
			$NewSubject[$i] = $ArraySubject[$i]."\n";
		}
	}
	$NewSubject[$Cnt-1] = rtrim($NewSubject[$Cnt-1]);
	$fp=fopen($BoardPath."/".$BoardID."/subject.txt","w");
	foreach ($NewSubject as $a){
		fputs($fp, $a);
	}
	
	fclose($fp);
}

function JapaneseDay ($Day) {
	$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
	if ($Day > 6) {
		return $weekday[$Day];
	}else{
		return;
	}

}

//IPアドレスからIDを生成する
function MakeID ($IP,$CryptKey) {
    $str_md5 = substr(md5($IP), 0, 30);
    $date_md5 = substr(md5(date("Y-m-d")), 0, 20);
    $key_md5 = substr(md5($CryptKey), 0, 10);

    $id_md5 = md5($str_md5 . $date_md5 . $key_md5);
    $id = substr(base64_encode($id_md5), 0, 8);

    return $id;
}

function MakeTrip($tripkey) {
    $tripkey = substr($tripkey, 1);
    $salt = substr($tripkey . 'H.', 1, 2);
    $salt = preg_replace('/[^\.-z]/', '.', $salt);
    $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
    $trip = crypt($tripkey, $salt);
    $trip = substr($trip, -10);
    $trip = '◆' . $trip;

    return $trip;
}

function htmlescape($data) {
	$specialchar = htmlspecialchars($data);
	$ampreplace = str_replace("&", "&amp;", $specialchar);
	$ltreplace = str_replace("<", "&lt;", $ampreplace);
	$gtreplace = str_replace(">", "&gt;", $ltreplace);
	$quotreplace = str_replace('"', "&quot;", $gtreplace);
	return $quotreplace;
}

function BoardList($ListPath) {
	$RawList = file_get_contents($ListPath."/boardlist.txt", true);
	$List = explode("\n", $RawList);
	
	return $List;
}

function BoardExists($ListPath, $name) {
	$List = BoardList($ListPath);
	
	foreach ($List as $value) {
		if ($value === $name) {
			return 1;
		}
	}
	return 0;
}
