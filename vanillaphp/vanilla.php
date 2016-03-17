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
	$data = explode("/",trim($_SERVER['PATH_INFO'], "/"));
	array_push($data, "");
	return $data;
}

class Output {
	private $output;
	
	public function Set($text) {
		$this->output .= $text;
	}
	
	public function Get(){
		return $this->output;
	}
	
	public function Init() {
		$this->output = "";
	}
}

?>