<?php

namespace LaLitTests\Bugs;

use LaLit\Array2XML;
use LaLitTests\TestCase;

/**
 * Class Bug003Test.
 */
class Bug003Test extends TestCase
{
    public function testNullValues()
    {
        $array = [
            'container' => [
                'item' => [
                    'term' => 'description',
                    'label' => null,
                    'emptyCData' => [
                        '@cdata' => null,
                    ],
                    '@attributes' => [
                        'present' => 'none',
                    ],
                    'node' => [
                        '@attributes' => [
                            'present' => 'years',
                            'empty' => null,
                        ],
                        '@value' => null,
                    ],
                ],
            ],
        ];

        $actualResults = Array2XML::createXML('root', $array)->saveXML();

        $expectedResults = <<< 'END_XML'
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<root>
  <container>
    <item present="none">
      <term>description</term>
      <label></label>
      <emptyCData><![CDATA[]]></emptyCData>
      <node present="years" empty=""></node>
    </item>
  </container>
</root>

END_XML;

        $this->assertEquals($expectedResults, $actualResults, 'Failed to handle empty @values');
    }
}
