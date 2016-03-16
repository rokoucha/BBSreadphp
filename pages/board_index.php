<?php
echo <<< EOT
<!DOCTYPE html>
	<head>
		<title>{$_SETTING["BBS_TITLE"]}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="{$_SETTING["BBS_TITLE"]}"/>
		<meta property="og:url" content="{$FullPath}"/>
		<meta property="og:description" content="{$BBSDescription}"/>
		<base href="#BBSURL#">
		<style>body{margin:0;padding:0;}
		</style>
	</head>
	<body text=#000000 bgcolor="#FFFFFF" link=#0000FF alink=#FF0000 vlink=#660099>
		<div align=center>
			<a href="{$FullPath}" border=0>{$_SETTING["BBS_TITLE"]}</a>
		</div>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor=#CCFFCC align=center>
			<tr>
				<td align=center>
					<table border=0 cellpadding=1 width=100%>
						<tr>
							<td nowrap COLSPAN=2>
								<font size=+1>
									<b>{$_SETTING["BBS_TITLE"]}</b>
								</font>
								<br>
							</td>
							<td nowrap width=5% align=right valign=top>
							</td>
						</tr>
						<tr>
							<td colspan=3>
								#ABOUTBOARD#
							</td>
						</tr>
						<tr>
							<td nowrap align=right>
							</td>
						</tr>
					</table>
					<b>
						<a href=./topost/>書き込む前に読んでね</a>
						 | 
						<a href=./howtouse/>BBSreadphpガイド</a>
						 | 
						<a href="./faq/">FAQ</a>
					</b>
				</td>
			</tr>
		</table>
		<br>
		<a name="menu"></a>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor="#CCFFCC"align=center>
			<tr>
				<td>
					<font size=2>
						<div align="left">
							<a href="subback.php">
								<b>スレッド一覧はこちら</b>
							</a>
						</div>
							#THREADLIST#
					</font>
				</td>
			</tr>
		</table>
		<br>
		<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor="#EFEFEF" align=center>
			<tr>
				<td>
					#THREADDATA#
				</td>
			</tr>
		</table><br>
		<center>
			<table border=1 cellspacing=7 cellpadding=3 width=95% bgcolor=#CCFFCC align=center>
				<tr>
					<td>
						<form method=POST action="./test/bbs.php">
							<td nowrap>
								タイトル：<input type=text name=subject size=40>
								<input type=submit value="新規スレッド作成" name=submit><br>
								名前：<input type=text name=FROM size=19 value="#FORMNAME#">
								E-mail：<input type=text name=mail size=19 value="#FORMMAIL#"><br>
								内容：<textarea rows=5 cols=60 wrap=OFF name=MESSAGE></textarea>
								<input type=hidden name=bbs value="#BOARDID#">
							</td>
						</form>
					</td>
				</tr>
			</table>
		</center>
		<p style="text-align: center; color: #333;">
			<a href="https://github.com/atnanasi/BBSreadphp/">BBSreadphp</a> index.php #VERSION# - #RELEASEDATE#<br>
		 </p>
	</body>
</html>
EOT;
