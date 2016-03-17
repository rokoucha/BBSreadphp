<?php
//VanillaPHP

namespace VanillaPHP;

require_once "vanillaphp/vanilla.php";

autoload();

$_PATH = GetQueryByPath();

$Out = new Output;

$Out->Init();

$_GLOBAL = parse_ini_file("config/global.ini" ,1);

require_once "functions/main.php";

require_once "functions/view.php";

?>
