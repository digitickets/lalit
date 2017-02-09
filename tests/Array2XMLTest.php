<?php

namespace LaLit;

class Array2XMLTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage [Array2XML] Illegal character in attribute name. attribute: #attribute1 in node: root
     */
    public function testInvalidAttributeNameThrowsException()
    {
        Array2XML::createXML(
            'root',
            [
                '@attributes' => [
                        '#attribute1' => '',
                    ],
            ]
        );
    }

    /**
     * @expectedException \Exception
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
