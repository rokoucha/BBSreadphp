<?php
echo <<< EOT
<!DOCTYPE html>
	<head>
		<title>{$ThreadName} {$_SETTING["BBS_TITLE"]}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="{$ThreadName} {$_SETTING["BBS_TITLE"]}"/>
		<meta property="og:url" content="{$FullPath}"/>
		<meta property="og:description" content="{$BBSDescription}"/>
		<base href="{$IndexPath}/{$BoardID}/">
	</head>
	<body bgcolor=#efefef text=black link=blue alink=red vlink=#660099>
		
		<div style='margin-top:1em;'><span style='float:left;'><div style="margin-top:1em;"><span style='float:left;'>
			<a href="{$IndexPath}">トップへ</a>
			<a href="./">■掲示板に戻る■</a>
			<a href="../test/read.cgi/{$BoardID}/{$ThreadID}">全部</a>
			<a href="../test/read.cgi/{$BoardID}/{$ThreadID}/l50">最新50</a>
		</span>
		<span style='float:right;'>
		</span>&nbsp;</div>
		<hr style="background-color:#888;color:#888;border-width:0;height:1px;position:relative;top:-.4em;">
		<h1 style="color:red;font-size:larger;font-weight:normal;margin-right: 185px;word-wrap: break-word;">{$ThreadName}</h1>
		<div><dl class="thread" style="margin-right:185px;word-wrap:break-word; ">
{$ThreadData}
		</div>
		<font color=red face="Arial"><b>{$FileSize}KB</b></font>
		<hr>
		<center><a href="../test/read.cgi/{$BoardID}/{$ThreadID}/l{$ResCnt}">新着レスの表示</a></center>
		<hr>
		<a href="./">■掲示板に戻る■</a>
		<a href="../test/read.cgi/{$BoardID}/{$ThreadID}/">全部</a>
		<a href="../test/read.cgi/{$BoardID}/{$ThreadID}/l50">最新50</a>
		<form method=POST action="../test/bbs.cgi">
			<input type=submit value="書き込む" name="submit">
			名前： <input name=FROM size=19 value="{$FormNAME}">
			E-mail<font size=1> (省略可) </font>: <input name=mail size=19 value="{$FormMAIL}"><br>
			<textarea rows=5 cols=70 wrap=off name="MESSAGE"></textarea>
			<input type=hidden name="bbs" value="{$BoardID}">
			<input type=hidden name="key" value="{$ThreadID}">
		</form>
		<br><br>index.php ver {$_GLOBAL["application"]["version"]} - {$_GLOBAL["application"]["releasedate"]} <font color=#FE642E><strong>Atnanasi★</strong></font><br>
		<font color=green><b>{$BBSAdmin}</b></font> <a href="http://user.otyakani.xyz/atnanasi/" target="_blank">BBSreadphp</a>
	</body>
</html>
EOT;
