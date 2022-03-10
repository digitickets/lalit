<?php

namespace LaLitTests\Bugs;

use LaLit\Array2XML;
use LaLit\XML2Array;

/**
 * Class Bug0088Test.
 */
class Bug008Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $xml
     * @param array $array
     *
     * @throws \Exception
     *
     * @dataProvider provideDataForRootAttributesAndDocTypes
     */
    public function testRootAttributesAndDocTypes(string $xml, array $array)
    {
        $actualXMLResults = Array2XML::createXML('root', $array['root'] ?? [], $array['@docType'] ?? [])->saveXML();
        $actualArrayResults = XML2Array::createArray($xml);

        $this->assertEquals($xml, $actualXMLResults, '');
        $this->assertEquals($array, $actualArrayResults, '');
    }

    public function provideDataForRootAttributesAndDocTypes()
    {
        return
            [
                'Public DTD' => [
                    'xml' => <<< 'END_XML'
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE root PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<root root_attribute="root_attribute_value">
  <container>
    <item present="none" zero="0">
      <term>description</term>
      <label></label>
      <zero>0</zero>
      <zeroCData>
<![CDATA[0]]>
      </zeroCData>
      <node present="years" empty="" zero="0">0</node>
    </item>
  </container>
</root>

END_XML
                    ,
                    'array' => [
                        'root' => [
                            'container' => [
                                'item' => [
                                    'term' => 'description',
                                    'label' => null,
                                    'zero' => 0,
                                    'zeroCData' => [
                                        '@cdata' => 0,
                                    ],
                                    '@attributes' => [
                                        'present' => 'none',
                                        'zero' => 0,
                                    ],
                                    'node' => [
                                        '@attributes' => [
                                            'present' => 'years',
                                            'empty' => null,
                                            'zero' => 0,
                                        ],
                                        '@value' => 0,
                                    ],
                                ],
                            ],
                            '@attributes' => [
                                'root_attribute' => 'root_attribute_value',
                            ],
                        ],
                        '@docType' => [
                            'name' => 'root',
                            'entities' => null,
                            'notations' => null,
                            'publicId' => '-//W3C//DTD XHTML 1.0 Transitional//EN',
                            'systemId' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd',
                            'internalSubset' => null,
                        ],
                    ],
                ],
                'External DTD' => [
                    'xml' => <<< 'END_XML'
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<!DOCTYPE root SYSTEM "external.dtd">
<root root_attribute="root_attribute_value">
  <container>
    <item present="none" zero="0">
      <term>description</term>
      <label></label>
      <zero>0</zero>
      <zeroCData><![CDATA[0]]></zeroCData>
      <node present="years" empty="" zero="0">0</node>
    </item>
  </container>
</root>

END_XML
                    ,
                    'array' => [
                        'root' => [
                            'container' => [
                                'item' => [
                                    'term' => 'description',
                                    'label' => null,
                                    'zero' => 0,
                                    'zeroCData' => [
                                        '@cdata' => 0,
                                    ],
                                    '@attributes' => [
                                        'present' => 'none',
                                        'zero' => 0,
                                    ],
                                    'node' => [
                                        '@attributes' => [
                                            'present' => 'years',
                                            'empty' => null,
                                            'zero' => 0,
                                        ],
                                        '@value' => 0,
                                    ],
                                ],
                            ],
                            '@attributes' => [
                                'root_attribute' => 'root_attribute_value',
                            ],
                        ],
                        '@docType' => [
                            'name' => 'root',
                            'entities' => null,
                            'notations' => null,
                            'publicId' => null,
                            'systemId' => 'external.dtd',
                            'internalSubset' => null,
                        ],
                    ],
                ],
            ];
    }
}
