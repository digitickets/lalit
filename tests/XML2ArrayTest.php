<?php
namespace LaLit;

class XML2ArrayTest extends \PHPUnit_Framework_TestCase
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
}
