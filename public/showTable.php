<?php
namespace Alltables;

use Animir\Alltables\ProjectOptions;
use Animir\Alltables\ParserFactory;

error_reporting(E_ALL);
ini_set('display_errors', true);
header('Content-Type: text/html; charset=utf-8');
require_once '../tests/bootstrap.php';
if (!isset($_GET['name'])) {
    echo 'Parser name in GET not exists. Please, set up, for example "?name=unicode"';
    exit();
} else {
    $name = $_GET['name'];
}
$parser = ParserFactory::factory($name);
$data = $parser->getArray();

$ch = curl_init(ProjectOptions::getProjectOption('test_url'));
$dataWithConfig = [
    'data' => $data,
    'info' => $parser->getOptions(),
    'imp_fields' => $parser->getImpFieldsPositions()
];
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['data' => json_encode($dataWithConfig)]);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$html = curl_exec($ch);
curl_close($ch);

$pattern = array('/href\s*=\s*\"\s*(?!http:\/\/|https:\/\/|ftp:\/\/)/','/src\s*=\s*\"\s*(?!http:\/\/|https:\/\/|ftp:\/\/)/');
$replacement = array('href="http://' . ProjectOptions::getProjectOption('test_site') . '/','src="http://'. ProjectOptions::getProjectOption('test_site') . '/');
echo preg_replace($pattern, $replacement, $html);

