<?php
echo mb_convert_encoding(file_get_contents($BoardPath."/".$BoardID."/1000.txt" ,true), "SJIS", "UTF-8");
