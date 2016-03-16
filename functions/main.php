<?php
//Main script

require_once 'config/bbs-config.php';

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

