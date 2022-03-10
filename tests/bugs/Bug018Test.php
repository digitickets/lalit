<?php

namespace LaLitTests\Bugs;

use LaLit\Array2XML;
use LaLit\XML2Array;
use PHPUnit\Framework\TestCase;

/**
 * Class Bug018Test.
 */
class Bug018Test extends TestCase
{
    public function testNewLinesAndTabsInXML()
    {
        $xml = str_replace(
            ['>>0A<<', '>>0D<<'],
            ["\x0a", "\x0d"],
            <<< 'END_XML'
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE root PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<root>
  <container>
    <newline_and_tabs>
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
    </newline_and_tabs>
    <newline_and_tabs_cdata>
<![CDATA[
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
]]>
    </newline_and_tabs_cdata>
  </container>
</root>

END_XML
        );

        $array = [
            '@docType' => [
                'name' => 'root',
                'entities' => null,
                'notations' => null,
                'publicId' => '-//W3C//DTD XHTML 1.0 Transitional//EN',
                'systemId' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd',
                'internalSubset' => null,
            ],
            'root' => [
                'container' => [
                    'newline_and_tabs' => str_replace(
                        ['>>0A<<', '>>0D<<'],
                        ["\x0a", "\x0d"],
                        '
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
    '
                    ),
                    'newline_and_tabs_cdata' => [
                        '@cdata' => str_replace(
                            ['>>0A<<', '>>0D<<'],
                            ["\x0a", "\x0d"],
                            '
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
'
                        ),
                    ],
                ],
            ],
        ];

        $html = str_replace(
            ['>>0A<<', '>>0D<<'],
            ["\x0a", "\x0d"],
            <<< 'END_HTML'
<root><container><newline_and_tabs>
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
    </newline_and_tabs><newline_and_tabs_cdata>
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
</newline_and_tabs_cdata></container></root>

END_HTML
        );

        // Convert the supplied XML and data to their counterparts.
        $generatedArray = XML2Array::createArray($xml);
        $generatedXml = Array2XML::createXML('root', $array['root'], $array[Array2XML::getLabelDocType()])->saveXML();

        $tempHTMLFilename = tempnam(sys_get_temp_dir(), 'bug018');
        Array2XML::createXML('root', $array['root'], $array[Array2XML::getLabelDocType()])->saveHTMLFile($tempHTMLFilename);
        $generatedHtml = file_get_contents($tempHTMLFilename);
        unlink($tempHTMLFilename);

        // Compare the generated values with the originals.

        // HTML allows \r and \n, so no amendments to the generatedHtml needed for the comparison.
        $this->assertEquals($html, $generatedHtml);

        // XML does NOT allow \r and outputs &#13; instead.
        $this->assertEquals($xml, str_replace('&#13;', "\r", $generatedXml));

        // PHP read \r but then converted it \n, convert the \r to \n in the original data.
        $array['root']['container']['newline_and_tabs'] = str_replace(
            "\r",
            "\n",
            $array['root']['container']['newline_and_tabs']
        );
        $array['root']['container']['newline_and_tabs_cdata'] = str_replace(
            "\r",
            "\n",
            $array['root']['container']['newline_and_tabs_cdata']
        );
        $this->assertEquals($array, $generatedArray);
    }
}
