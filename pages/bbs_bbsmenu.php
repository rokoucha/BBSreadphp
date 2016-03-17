<?php
$data = <<< EOT
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<TITLE>BBS MENU for {$BBSName}</TITLE>
<BASE TARGET="cont">
</HEAD>
<BODY TEXT="#CC3300" BGCOLOR="#FFFFFF" link="#0000FF" alink="#ff0000" vlink="#660099">
<BR>
<font size=2>
<A HREF={$FullPath} TARGET="_top">{$BBSName}</A><br>
<BR><BR><B>メイン</B><BR>
<A HREF={$IndexPath}/board/>メイン</A><br>
<br>更新日16/03/17
</font>
</BODY></HTML>

EOT;

echo mb_convert_encoding($data, "SJIS", "UTF-8");
