<?php
//Main script

require_once 'config/bbs-config.php';

$FullPath = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

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

switch ($_PATH[0]) {
	case "":
		require_once 'functions/bbs_index.php';
		break;

	case "index.html":
		require_once 'functions/bbs_index.php';
		break;
	
	case "bbsmenu.html":
		require_once 'functions/bbs_bbsmenu.php';
		break;
	
	case "_service":
		switch ($_PATH[1]) {
			case "bbslist.txt":
				require_once 'functions/bbslist.php';
				break;

			default:
				require_once 'functions/404.php';
				break;
		}
		break;
	
	case "test":
		switch ($_PATH[1]) {
			case "read.cgi":
				require_once 'functions/read.php';
				break;
			
			case "bbs.cgi":
				require_once 'functions/bbs.php';
				break;

			default:
				require_once 'functions/404.php';
				break;
		}
		break;
		
	default:
		if (BoardExists($BoardPath, $_PATH[0])) {
			$BoardID = $_PATH[0];
			$_SETTING = parse_ini_file($BoardPath."/".$BoardID."/SETTING.TXT");
			switch ($_PATH[1]) {
				case "":
					require_once 'functions/board_index.php';
					break;

				case "index.html":
					require_once 'functions/board_index.php';
					break;

				case "subback.html":
					require_once 'functions/subback.php';
					break;

				case "subject.txt":
					require_once 'functions/subject.php';
					break;

				case "SETTING.TXT":
					require_once 'functions/SETTING.php';
					break;

				case "dat":
					require_once 'functions/dat.php';
					break;

				case "1000.txt":
					require_once 'functions/1000.php';
					break;

				case "head.txt":
					require_once 'functions/head.php';
					break;

				default:
					require_once 'functions/404.php';
					break;
			}
			break;	
		}else{
			require_once 'functions/404.php';
		}
		break;
}

