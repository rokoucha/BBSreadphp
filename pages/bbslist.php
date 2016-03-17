<?php
echo mb_convert_encoding(file_get_contents($BoardPath."/boardlist.txt" ,true), "SJIS", "UTF-8");
