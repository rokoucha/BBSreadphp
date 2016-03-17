<?php
echo mb_convert_encoding(file_get_contents($BoardPath."/".$BoardID."/dat/".$ThreadID.".dat" ,true), "SJIS", "UTF-8");
