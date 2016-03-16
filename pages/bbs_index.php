<?php
echo <<< EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Script-Type" content="text/javascript"/>
		<meta http-equiv="Content-Style-Type" content="text/css"/>
		<meta name="Description" CONTENT="{$BBSDescription}">
		<meta name="KeyWords" CONTENT="{$BBSKeyword}">
		<meta name="Author" CONTENT="{$BBSAuthor}">

		<title>{$BBSTitle}◎</title>
		<style type="text/css" media="all">@import url(2ch_top.css);</style>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="header_inside">
					<div class="header_left">
						<a href="http://www2.2ch.net/2ch.html"><img src="images/2ch_logo.gif" width="151" height="40" alt="�ｼ偵■繧�繧薙�ｭ繧�" align="middle" border="0"/><a href="http://www2.2ch.net/2ch.html">謗ｲ遉ｺ譚ｿ</a>�ｽ�
						<a href="http://itest.2ch.net/">繧ｹ繝槭�帷沿繝�繧ｹ繝井ｸｭ縲�</a>�ｽ�
						<a href="http://c.2ch.net/">imode</a>
					</div>
					<form method=GET name=f action="http://search.2ch.net/search" style="margin:0px">
						<input size=25 name="q" value="" class="form_input" style="float:right;"> 
						<input type="image" src="images/search_button.gif" alt="讀懃ｴ｢" class="form_button" style="float:right;"><br/>
					</form>
				</div>
			</div> 
		</div>
		<div id="under_header">
			<a href="http://newsnavi.2ch.net/">繝九Η繝ｼ繧ｹ</a>�ｽ�<a href="http://headline.2ch.net/">邱丞粋縺ｮ莠ｺ豌励せ繝ｬ</a> | <a href="http://headline.2ch.net/bbynews/">繝倥ャ繝峨Λ繧､繝ｳ</a>�ｽ�<a href="http://www.2ch.net/kakolog.html">驕主悉繝ｭ繧ｰ蛟牙ｺｫ</a>
		</div>
		<div id="main">
			<a href="http://www2.2ch.net/2ch.html"><img src="http://www.2ch.net/2ch-logo.gif"></a>
			<br>
		</div> 
		<div id="footer_menu">
			<div class="guide">
				<a href="http://info.2ch.net/guide/">菴ｿ縺�譁ｹ�ｼ�豕ｨ諢�</a>�ｽ�<a href="http://qb5.2ch.net/saku2ch/">蜑企勁繧ｬ繧､繝峨Λ繧､繝ｳ</a>�ｽ�<a href="http://www2.2ch.net/2ch2.html">諡｡蠑ｵ迚医Γ繝九Η繝ｼ</a>�ｽ�<a href="http://senden.tv/infospace.html">蠎�蜻翫�ｮ縺疲｡亥��</a>
			</div>
		</div> 
		<div id="footer">
			<div class="footer_left">
			</div>
			<div class="footer_right">
			</div>
		</div> 
	</body>
</html>
EOT;
?>