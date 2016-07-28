<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use LaLit\Array2XML;
use LaLit\XML2Array;

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
                $results[$attributeType . ' - ' . $cdataType] = "<{$tag}{$attribute}>{$cdata}</{$tag}>";
            } else {
                $result = '';
                foreach (range(1, $tag[1]) as $repeat) {
                    $result .= "<{$tag[0]}{$attribute}>{$cdata}</{$tag[0]}>";
                }
                $results[$attributeType . ' - ' . $cdataType . ' with ' . $tag[1] . ' nodes'] = $result;
            }
        }
    }

    return $results;
}

$outputPath = __DIR__ . '/../files';
@mkdir($outputPath . '/PHP', 0666, true);
@mkdir($outputPath . '/XML', 0666, true);

echo 'Deleting existing tests', PHP_EOL;
array_map('unlink', glob($outputPath . '/*/*.*'));

$docs = [];
$docs = array_merge($docs, generateTags(['root']));
$docs = array_merge($docs, generateTags(['root', 'node']));
$docs = array_merge($docs, generateTags(['root', 'collection', ['node', 5]]));
$docs = array_unique($docs);

$docCount = 0;
foreach ($docs as $key => $value) {
    echo 'Saving test #', number_format(++$docCount), "\r";

    $php = XML2Array::createArray($value);
    $xml = Array2XML::createXML('root', $php['root'])->saveXML();

    $php = unserialize(str_replace('s:4:"null";', 'N;', serialize($php)));
    $xml = str_replace('null', '', $xml);

    file_put_contents($outputPath . '/php/' . $key . '.php', "<?php\nreturn " . var_export($php, true) . ";\n");
    file_put_contents($outputPath . '/xml/' . $key . '.xml', $xml);
}
