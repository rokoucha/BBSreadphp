<?php
//VanillaPHP

namespace VanillaPHP;

require_once "vanillaphp/vanilla.php";

autoload();

$_PATH = GetQueryByPath();

$Out = new Output;

$Out->Init();

require_once "functions/main.php";

require_once "functions/view.php";

?>
