<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
header('Content-Type: text/html; charset=utf-8');
require_once './bootstrap.php';
$test = new Animir\Alltables\Parser\UnicodeTest();
$test->testParseNode();