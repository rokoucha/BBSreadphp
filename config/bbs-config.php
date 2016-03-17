<?php
// BBSreadphp config file

// Path config

// index.php path
// If you don't know where are script dir, write `str_replace("/config/bbs-config.php", "", __FILE__)`
$RootFolder = str_replace("/config/bbs-config.php", "", __FILE__);

// Board file path
$BoardPath = $RootFolder."/files/bbs";

// Index.php name
// If you don't know where are index.php, write `((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"])`
$IndexPath = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"]);


// System config

// ID crypt key
// Set random string.
// If complete setup,You need change this string.
$CryptKey = "The sample key";

// View res
$ResCnt = 5;

// Cookie(star) expires
$CookieExpires = 100000;


// BBS config

// Administrator name
$BBSAdmin = "Atnanasi★";

// BBS Name
$BBSName = "BBSreadphp";

// BBS Description
$BBSDescription = "Simple \"2channel\" clone";

?>