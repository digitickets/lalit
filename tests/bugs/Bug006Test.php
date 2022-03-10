<?php

namespace LaLitTests\Bugs;

use LaLit\Array2XML;

/**
 * Class Bug006Test.
 */
class Bug006Test extends \PHPUnit\Framework\TestCase
{
    public function testZeroValues()
    {
        $array = [
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
        ];

        $actualResults = Array2XML::createXML('root', $array)->saveXML();

        $expectedResults = <<< 'END_XML'
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<root>
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

END_XML;

        $this->assertEquals($expectedResults, $actualResults, 'Failed to handle empty @values');
    }
}
