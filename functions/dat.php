<?php
$ErrorText = "404 NotFound";

if (isset($_PATH[2])) {
	$ThreadID = str_replace(".dat", "", $_PATH[2]);
	if (ThreadExists($BoardPath, $BoardID, $ThreadID)) {
		$Out->Set("dat");
	}else{
		$Out->Set("404");
	}
}else{
	$Out->Set("404");
}
