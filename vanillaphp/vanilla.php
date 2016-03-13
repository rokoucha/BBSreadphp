<?php
//VanillaPHP
namespace VanillaPHP;

function autoload() {
	$libini = parse_ini_file("config/library.ini", 1);
        foreach ($libini as $key => $value) {
            if (file_exists("lib/{$libini[$key]["file"]}")) {
                require_once "lib/{$libini[$key]["file"]}";
            }
        }
}

function GetQueryByPATH() {
	return explode("/",trim($_SERVER['PATH_INFO'], "/"));
}

?>