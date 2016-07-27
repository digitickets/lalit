<?php
namespace LaLit;

use PHPUnit_Framework_TestCase;

/**
 * Class Bug003
 *
 * @package LaLit
 * @group   bugfixes
 */
class Bug003 extends PHPUnit_Framework_TestCase
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

        $expectedResults = <<< END_XML
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

        self::assertEquals($expectedResults, $actualResults, 'Failed to handle empty @values');
    }
}
