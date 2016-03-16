<?php
echo <<< EOT
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Script-Type" content="text/javascript"/>
		<meta http-equiv="Content-Style-Type" content="text/css"/>
		<meta name="Description" CONTENT="{$BBSDescription}">
		<meta name="KeyWords" CONTENT="{$BBSKeyword}">
		<meta name="Author" CONTENT="{$BBSAuthor}">

		<title>{$BBSTitle}</title>
	</head>
	<body>
		<h1>Yo</h1>
		<a href={$RootFolder}/bbsmenu.html>BBSMENU</a>
	</body>
</html>
EOT;
?>