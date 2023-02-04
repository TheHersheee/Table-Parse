<?php

require __DIR__ . '/vendor/autoload.php';

use voku\helper\HtmlDomParser;

$page = file_get_contents('https://umnozhenie-delenie.ru/tablitsa-umnozheniya');
$html = HtmlDomParser::str_get_html($page);
$table = $html->findOne('.table_tab_umn');
$file = fopen('result.csv', 'w');

foreach($table as $tr) {
    if ($tr->nodeName != 'tr') {
        continue;
    }
    $row = [];
    foreach($tr as $cell) {
        if ($cell->nodeName != 'th' && $cell->nodeName != 'td') {
            continue;
        }
        $row[] = $cell->innertext;
    }
    fputcsv($file, $row);
}

fclose($file);