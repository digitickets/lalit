<?php
namespace LaLit;

class MainLaLitTest extends \PHPUnit_Framework_TestCase
{
    public function provideTestData()
    {
        return include __DIR__ . '/files/testData.inc';
    }

    /**
     * @dataProvider provideTestData
     *
     * @param string $php
     * @param string $xml
     * @param string $structure
     */
    public function testArrayToXML($php, $xml, $structure)
    {
        $actualResults   = Array2XML::createXML('root', $php['root'])->saveXML();
        $expectedResults = $xml;

        $this->assertEquals($expectedResults, $actualResults, $structure);
    }

    /**
     * @dataProvider provideTestData
     *
     * @param string $php
     * @param string $xmlString
     * @param string $structure
     */
    public function testXMLToArray($php, $xmlString, $structure)
    {
        $xmlDOM                     = new \DOMDocument(1.0, 'UTF-8');
        $xmlDOM->xmlStandalone      = false;
        $xmlDOM->preserveWhiteSpace = false;
        $xmlDOM->loadXML($xmlString);
        $xmlDOM->formatOutput = true;

        $xmlStringResults = XML2Array::createArray($xmlString);
        $xmlDOMResults    = XML2Array::createArray($xmlDOM);

        $this->assertEquals($php, $xmlStringResults, $structure);
        $this->assertEquals($php, $xmlDOMResults, $structure);
    }
}
