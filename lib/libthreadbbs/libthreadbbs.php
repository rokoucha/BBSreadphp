<?php
//libThreadBBS
namespace ThreadBBS;

class Res {
	public $name;
	public $mail;
	public $date;
	public $time;
	public $id;
	public $message;
	
	//DAT to object
	public function toObject($string) {
		preg_match("/^(.+)<>(.+)<>(.+) (.+) ID:(.+)<>(.+)<>(.*)/", $string, $matches);
		$this->name = $matches[1];
		$this->mail = $matches[2];
		$this->date = $matches[3];
		$this->time = $matches[4];
		$this->id = $matches[5];
		$this->message = $matches[6];
	}
	
	//object to DAT
	public function toString() {

		$return = "{$this->name}<>{$this->mail}<>{$this->date} {$this->time} ID:{$this->id}<>{$this->message}<>";
		
		return $return;
	}
	
}
