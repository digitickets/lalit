<?php

namespace LaLitTests\PullRequests;

use LaLit\Array2XML;
use LaLit\XML2Array;
use PHPUnit\Framework\TestCase;

class Pr016Test extends TestCase
{
    /**
     * @param array $data
     * @param string|null $labelAttributes
     * @param string|null $labelCData
     * @param string|null $labelDocType
     * @param string|null $labelValue
     *
     * @dataProvider provideLabels
     */
    public function testLabels(
        array $data,
        string $labelAttributes = null,
        string $labelCData = null,
        string $labelDocType = null,
        string $labelValue = null
    ) {
        $xml = <<< 'END_XML'
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

END_XML;

        // Initialise with the required labels.
        Array2XML::init(
            null,
            null,
            null,
            null,
            $labelAttributes,
            $labelCData,
            $labelDocType,
            $labelValue
        );
        XML2Array::init(
            null,
            null,
            null,
            null,
            $labelAttributes,
            $labelCData,
            $labelDocType,
            $labelValue
        );

        // Convert the known XML to an array and compare with supplied data.
        $resultsFromXml2ArrayCreateArray = XML2Array::createArray($xml);
        $this->assertEquals($data, $resultsFromXml2ArrayCreateArray);

        // Convert the supplied data and compare with the known XML.
        $resultsFromArray2XmlCreateXml = Array2XML::createXML('root', $data['root'], $data[Array2XML::getLabelDocType()])->saveXML();
        $this->assertEquals($xml, $resultsFromArray2XmlCreateXml);
    }

    public function provideLabels()
    {
        return [
            'Normal labels' => [
                'data' => [
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
            'Different labels' => [
                'data' => [
                    'root' => [
                        'container' => [
                            'item' => [
                                'term' => 'description',
                                'label' => null,
                                'zero' => 0,
                                'zeroCData' => [
                                    '@differentcdata' => 0,
                                ],
                                '@differentattributes' => [
                                    'present' => 'none',
                                    'zero' => 0,
                                ],
                                'node' => [
                                    '@differentattributes' => [
                                        'present' => 'years',
                                        'empty' => null,
                                        'zero' => 0,
                                    ],
                                    '@differentvalue' => 0,
                                ],
                            ],
                        ],
                        '@differentattributes' => [
                            'root_attribute' => 'root_attribute_value',
                        ],
                    ],
                    '@differentdocType' => [
                        'name' => 'root',
                        'entities' => null,
                        'notations' => null,
                        'publicId' => '-//W3C//DTD XHTML 1.0 Transitional//EN',
                        'systemId' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd',
                        'internalSubset' => null,
                    ],
                ],
                'attributesLabel' => '@differentattributes',
                'cdataLabel' => '@differentcdata',
                'docTypeLabel' => '@differentdocType',
                'valueLabel' => '@differentvalue',
            ],
            'Only CData and Value labels' => [
                'data' => [
                    'root' => [
                        'container' => [
                            'item' => [
                                'term' => 'description',
                                'label' => null,
                                'zero' => 0,
                                'zeroCData' => [
                                    '@differentcdata' => 0,
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
                                    '@differentvalue' => 0,
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
                'attributesLabel' => null,
                'cdataLabel' => '@differentcdata',
                'docTypeLabel' => null,
                'valueLabel' => '@differentvalue',
            ],
        ];
    }
}
