<?php
//Main script

switch ($_PATH[0]) {
	case "":
		require_once 'functions/index.php';
		break;

	case "index.html":
		require_once 'functions/index.php';
		break;
	
	case "bbsmenu.html":
		require_once 'functions/bbsmenu.php';
		break;
	
	case "test":
		switch ($_PATH) {
			case "read.cgi":
				require_once 'functions/read.php';
				break;
			
			case "bbs.cgi":
				require_once 'functions/bbs.php';
				break;

			default:
				break;
		}
		break;
		
	default:
		switch ($_PATH[1]) {
			case "subback.html":
				require_once 'functions/subback.php';
				break;
			
			case "subject.html":
				require_once 'functions/subject.php';
				break;
			
			case "SETTING.TXT":
				require_once 'functions/SETTING.php';
				break;
			
			case "dat":
				require_once 'functions/dat.php';
				break;

			default:
				break;
		}
		break;
}
