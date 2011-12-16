<?php

include("Language.php");

$lang = new Language();

$lang->load("about", "english");

echo $lang->line("index") . "\n";
