<?php
use Animir\Alltables\ParserFactory;
use Animir\Alltables\ProjectOptions;

error_reporting(E_ALL);
ini_set('display_errors', true);
header('Content-Type: text/html; charset=utf-8');
require_once './bootstrap.php';
$parser = ParserFactory::factory('PhpFopenMode', ProjectOptions::getAllParsersOptions());
$parser->getArray();