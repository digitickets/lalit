<?php
namespace LaLit;

use PHPUnit_Framework_TestCase;

class XML2ArrayTest extends PHPUnit_Framework_TestCase
{
    public function provideInvalidObjects()
    {
        return [
            [new \stdClass()],
        ];
    }

    public function provideInvalidTypes()
    {
        return [
            [0],
            [1.1],
            [null],
            [true],
            [false],
        ];
    }

    public function provideInvalidXML()
    {
        return [
            ['<?xml version="1.0" encoding="UTF-8"?><root>'],
            ['<?xml version="1.0" encoding="UTF-8"?><root><head>'],
        ];
    }

    public function provideValidXML()
    {
        return array_map(
            function ($file) {
                return [$file];
            },
            glob(__DIR__.'/files/XML/*.xml')
        );
    }

    /**
     * @param object $invalidObject
     *
     * @throws \Exception
     * @expectedException \Exception
     * @expectedExceptionMessage [XML2Array] The input XML object should be of type: DOMDocument.
     * @dataProvider provideInvalidObjects
     */
    public function testXMLFileToArrayRejectsInvalidObjects($invalidObject)
    {
        XML2Array::createArray($invalidObject);
    }

    /**
     * @param mixed $invalidType
     *
     * @throws \Exception
     * @expectedException \Exception
     * @expectedExceptionMessage [XML2Array] Invalid input
     * @dataProvider provideInvalidTypes
     */
    public function testXMLFileToArrayRejectsInvalidTypes($invalidType)
    {
        XML2Array::createArray($invalidType);
    }

    /**
     * @param string $invalidXML
     *
     * @throws \Exception
     * @expectedException \Exception
     * @expectedExceptionMessage [XML2Array] Error parsing the XML string.
     * @dataProvider provideInvalidXML
     */
    public function testXMLFileToArrayRejectsInvalidXML($invalidXML)
    {
        XML2Array::createArray($invalidXML);
    }

    /**
     * @dataProvider provideValidXML
     *
     * @param string $testFilename
     *
     * @throws \Exception
     */
    public function testXMLToArray($testFilename)
    {
        $xmlString = file_get_contents($testFilename);
        $xmlDOM = new \DOMDocument(1.0, 'UTF-8');
        $xmlDOM->xmlStandalone = false;
        $xmlDOM->preserveWhiteSpace = false;
        $xmlDOM->loadXML($xmlString);
        $xmlDOM->formatOutput = true;

        if (file_exists(__DIR__.'/files/PHP/'.basename($testFilename, '.xml').'.php')) {
            $expectedResults = @include __DIR__.'/files/PHP/'.basename($testFilename, '.xml').'.php';
        } else {
            $this->fail('Missing ' . __DIR__.'/files/PHP/'.basename($testFilename, '.xml').'.php');
        }

        $xmlStringResults = XML2Array::createArray($xmlString);
        $xmlDOMResults = XML2Array::createArray($xmlDOM);

        $this->assertEquals($expectedResults, $xmlStringResults, basename($testFilename, '.xml'));
        $this->assertEquals($expectedResults, $xmlDOMResults, basename($testFilename, '.xml'));
    }
}
