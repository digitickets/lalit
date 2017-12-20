<?php

use LaLit\Array2XML;
use LaLit\XML2Array;

require_once __DIR__.'/../../vendor/autoload.php';

/**
 * @param string|string[] $tags
 *
 * @return array
 */
function generateTags($tags)
{
    if (is_array($tags)) {
        $tag = array_shift($tags);
    } else {
        $tag = $tags;
    }

    $attributeSet = [
        'No attributes' => '',
        'Empty attribute' => ' attribute1=""',
        'Encoded attribute' => ' attribute2="&lt;important&gt;"',
        'Simple attribute' => ' attribute3="1"',
        'Quoted and encoded attribute' => ' attribute4="\'&lt;important&gt;\'"',
        'Empty quoted attribute' => ' attribute5="\'\'"',
        'Null attribute' => ' attribute6="null"',
        'All attributes' => ' attribute1="" attribute2="&lt;important&gt;" attribute3="1" attribute4="\'&lt;important&gt;\'" attribute5="\'\'"  attribute6="null"',
    ];

    $cDataSet = [
        'Null value' => 'null',
        'Empty value' => '',
        'Zero value' => '0',
        'Simple value' => 'normal',
        'Encoded value' => '&lt;escaped&gt;',
        'Empty CDATA' => '<![CDATA[]]>',
        'CDATA with tagged value' => '<![CDATA[<very_important>]]>',
    ];

    if (is_array($tags) && count($tags) > 0) {
        $cDataSet = array_merge($cDataSet, generateTags($tags));
    }

    $results = [];

    foreach ($attributeSet as $attributeType => $attribute) {
        foreach ($cDataSet as $cdataType => $cdata) {
            if (!is_array($tag)) {
                $results[$attributeType.' - '.$cdataType] = "<{$tag}{$attribute}>{$cdata}</{$tag}>";
            } else {
                $result = '';
                foreach (range(1, $tag[1]) as $repeat) {
                    $result .= "<{$tag[0]}{$attribute}>{$cdata}</{$tag[0]}>";
                }
                $results[$attributeType.' - '.$cdataType.' with '.$tag[1].' nodes'] = $result;
            }
        }
    }

    return $results;
}

$docs = [];

$docs = array_merge($docs, generateTags(['root']));
$docs = array_merge($docs, generateTags(['root', 'node']));
$docs = array_merge($docs, generateTags(['root', 'collection', ['node', 2]]));
$docs = array_unique($docs);

$testData = [];
foreach ($docs as $key => $value) {
    $php = XML2Array::createArray($value);

    $testData[$key] = [
        unserialize(str_replace('s:4:"null";', 'N;', serialize($php))),
        str_replace('null', '', Array2XML::createXML('root', $php['root'])->saveXML()),
        $key,
    ];
}

file_put_contents(__DIR__.'/../files/testData.inc', '<?php return '.var_export(array_values($testData), true).';');
