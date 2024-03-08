<?php

namespace LaLitTests;

use Exception;
use LaLit\XML2Array;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use stdClass;

class XML2ArrayTest extends PHPUnitTestCase
{
    public static function provideInvalidObjects(): array
    {
        return [
            [new stdClass()],
        ];
    }

    public static function provideInvalidTypes(): array
    {
        return [
            [0],
            [1.1],
            [null],
            [true],
            [false],
        ];
    }

    public static function provideInvalidXML(): array
    {
        return [
            ['<?xml version="1.0" encoding="UTF-8"?><root>'],
            ['<?xml version="1.0" encoding="UTF-8"?><root><head>'],
        ];
    }

    /**
     * @param object $invalidObject
     *
     * @throws Exception
     * @dataProvider provideInvalidObjects
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideInvalidObjects')]
    public function testXMLFileToArrayRejectsInvalidObjects($invalidObject)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('[XML2Array] The input XML object should be of type: DOMDocument.');
        XML2Array::createArray($invalidObject);
    }

    /**
     * @param mixed $invalidType
     *
     * @throws Exception
     * @dataProvider provideInvalidTypes
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideInvalidTypes')]
    public function testXMLFileToArrayRejectsInvalidTypes($invalidType)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('[XML2Array] Invalid input');
        XML2Array::createArray($invalidType);
    }

    /**
     * @param string $invalidXML
     *
     * @throws Exception
     * @dataProvider provideInvalidXML
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideInvalidXML')]
    public function testXMLFileToArrayRejectsInvalidXML(string $invalidXML)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('[XML2Array] Error parsing the XML string.');
        XML2Array::createArray($invalidXML);
    }
}
