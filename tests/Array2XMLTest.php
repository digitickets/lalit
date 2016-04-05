<?php
namespace LaLit;

use Exception;
use PHPUnit_Framework_TestCase;

class Array2XMLTest extends PHPUnit_Framework_TestCase
{
    public function provideValidPHP()
    {
        return array_map(
            function ($file) {
                return [$file];
            },
            glob(__DIR__.'/files/PHP/*.php')
        );
    }

    /**
     * @dataProvider provideValidPHP
     *
     * @param string $testFilename
     *
     * @throws \Exception
     */
    public function testArrayToXML($testFilename)
    {
        $php = include $testFilename;

        $actualResults = Array2XML::createXML('root', $php['root'])->saveXML();
        $expectedResults = file_get_contents(__DIR__.'/files/XML/'.basename($testFilename, '.php').'.xml');

        $this->assertEquals($expectedResults, $actualResults, basename($testFilename, '.php'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage [Array2XML] Illegal character in attribute name. attribute: #attribute1 in node: root
     */
    public function testInvalidAttributeNameThrowsException()
    {
        Array2XML::createXML(
            'root',
            [
                '@attributes' =>
                    [
                        '#attribute1' => '',
                    ],
            ]
        );
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage [Array2XML] Illegal character in tag name. tag: #node in node: root
     */
    public function testInvalidSimpleTagNameThrowsException()
    {
        Array2XML::createXML(
            'root',
            [
                '#node' => 'bad node name',
            ]
        );
    }
}
