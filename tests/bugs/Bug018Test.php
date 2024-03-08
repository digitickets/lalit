<?php

namespace LaLitTests\Bugs;

use LaLit\Array2XML;
use LaLit\XML2Array;
use LaLitTests\TestCase;

/**
 * Class Bug018Test.
 */
class Bug018Test extends TestCase
{
    public function testNewLinesAndTabsInXML()
    {
        $xml = str_replace(
            ['>>0A<<', '>>0D<<'],
            [chr(10), chr(13)],
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
                        [chr(10), chr(13)],
                        '
      description 1>>0A<<with embedded x0a
      description 2>>0D<<with embedded x0d
      multiple	lines	with	tabs	too	for	fun
    '
                    ),
                    'newline_and_tabs_cdata' => [
                        '@cdata' => str_replace(
                            ['>>0A<<', '>>0D<<'],
                            [chr(10), chr(13)],
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
            [chr(10), chr(13)],
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

        // Oddities by OS.
        if (PHP_OS === 'Darwin') {
            $this->assertEquals($html, $generatedHtml, 'HTML does not match');
            $this->assertEquals($xml, str_replace('&#13;', chr(13), $generatedXml), 'XML does not match');
        } else {
            $this->assertEquals($html, str_replace('&#13;', chr(13), $generatedHtml), 'HTML does not match');
            $this->assertEquals($xml, str_replace('&#13;', chr(13), $generatedXml), 'XML does not match');
        }

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
