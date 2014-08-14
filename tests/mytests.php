<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once './bootstrap.php';
$test = new Animir\Alltables\Parser\UnicodeTest();
$test->testParseNode();