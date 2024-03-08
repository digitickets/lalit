<?php

namespace LaLitTests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    // Provide a proxy for the deprecated expectExceptionMessageRegExp()
    public function expectExceptionMessageRegularExpression(string $messageRegExp)
    {
        if (method_exists($this, 'expectExceptionMessageMatches')) {
            $this->expectExceptionMessageMatches($messageRegExp);
        } else {
            parent::expectExceptionMessageRegExp($messageRegExp);
        }
    }
}