<?php

namespace LaLitTests;

use LaLit\Array2XML;

class Array2XMLTest extends TestCase
{
    public function testInvalidAttributeNameThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('[Array2XML] Illegal character in attribute name. attribute: #attribute1 in node: root');
        Array2XML::createXML(
            'root',
            [
                '@attributes' => [
                        '#attribute1' => '',
                    ],
            ]
        );
    }

    public function testInvalidSimpleTagNameThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('[Array2XML] Illegal character in tag name. tag: #node in node: root');
        Array2XML::createXML(
            'root',
            [
                '#node' => 'bad node name',
            ]
        );
    }
}
