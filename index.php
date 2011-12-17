<?php
session_start();
include("Language.php");

$lang = new Language();

$lang->load("about");

echo "<h1>Index value</h1>";
echo "<p>" . $lang->line("about.index") . "</p>";
echo "<a href='index.php?lang=zh-TW'>Chinese</a> | <a href='index.php?lang=en-US'>English</a><br />";
