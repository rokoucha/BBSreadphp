<?php
echo <<< EOT
<!DOCTYPE html>
<head>
<title>{$_SETTING["BBS_TITLE"]}</title>
<meta property="og:title" content="{$_SETTING["BBS_TITLE"]}" />
<meta property="og:description" content="{$BBSDescription}" />
<meta property="og:url" content="{$FullPath}" />
<meta property="og:site_name" content="{$BBSName}" />
<meta property="og:locale" content="ja_JP" />
<base href="{$IndexPath}/test/read.cgi/{$BoardID}/"
<style type="text/css"><!--
a { margin-right: 1em; }div.floated { border: 1px outset honeydew; float: left; height: 20em; line-height: 1em; margin: 0 0 .5em 0; padding: .5em; }div.floated, div.block { background-color: honeydew; }div.floated a, div.block a { display: block; margin-right: 0; text-decoration: none; white-space: nowrap; }div.floated a:hover, div.block a:hover { background-color: cyan; }div.floated a:active, div.block a:active { background-color: gold; }div.right { clear: left; text-align: right; }div.right a { margin-right: 0; }div.right a.js { background-color: dimgray; border: 1px outset dimgray; color: palegreen; text-decoration: none; }
-->
</style>
</head>
<body>
<div>
<small id="trad">
{$ThreadList}
</small>
</div>
</body>
</html>
EOT;

