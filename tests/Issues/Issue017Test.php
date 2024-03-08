<?php

namespace LaLitTests\Issues;

use LaLit\Array2XML;
use Exception;
use LaLitTests\TestCase;

class Issue017Test extends TestCase
{
    public function testInvalidCharactersInValueThrowsException()
    {

        $array = ['bad_text' => 'The ascii value of the next character is 2:'.chr(2)];

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegularExpression('`\[Array2XML\] Illegal character : The ascii value of the next character is 2:\x02 in node: bad_text`');

        Array2XML::createXML('root', $array);
    }

    public function testInvalidCharactersInAtValueThrowsException()
    {
        $array = [
            'bad_value' => [
                '@value' => 'The ascii value of the next character is 2:'.chr(2),
            ],
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegularExpression('`\[Array2XML\] Illegal character in value : The ascii value of the next character is 2:\x02 in node: bad_value`');

        Array2XML::createXML('root', $array);
    }

    public function testInvalidCharactersInAtCDataThrowsException()
    {
        $array = [
            'bad_value' => [
                '@cdata' => 'The ascii value of the next character is 2:'.chr(2),
            ],
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegularExpression('`\[Array2XML\] Illegal character in CData : The ascii value of the next character is 2:\x02 in node: bad_value`');

        Array2XML::createXML('root', $array);
    }
}
