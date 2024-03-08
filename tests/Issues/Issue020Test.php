<?php

namespace LaLitTests\Issues;

use DiffMatchPatch\DiffMatchPatch;
use LaLit\Array2XML;
use LaLit\XML2Array;
use LaLitTests\TestCase;

class Issue020Test extends TestCase
{
    public function testMultipleNamespaces()
    {
        $sourceXML = 'https://www.revenue.ie/en/online-services/support/software-developers/documents/aeoi/sample-xml-files/new.xml';
        $originalXML = file_get_contents($sourceXML);
        $originalConversion = XML2Array::createArray($originalXML);
        $rootNode = key($originalConversion);
        Array2XML::init(null, 'UTF-8'); // Source document uses UPPER-CASE.
        $newXML = Array2XML::createXML($rootNode, $originalConversion[$rootNode])->saveXML();

        // Remove leading spaces, and line breaks on both documents as one is `tab` / CRLF and the other is `spaces` / LF.
        $originalXML = preg_replace('`(^\s*|\s*$)`sim', '', $originalXML);
        $newXML = preg_replace('`(^\s*|\s*$)`sim', '', $newXML);

        $this->assertNotEquals($originalXML, $newXML);

        // Validate the expected differences.
        //
        // 1. BOM present on original document.
        // 2. Presence of 'standalone="no"'.
        // 3. No line breaks between multiple namespaces, and original order of the namespaces not matched.
        //
        // Whilst these differences exist, they do not alter the content of the XML file in any meaningful way.
        $dmp = new DiffMatchPatch();
        $this->assertStringEqualsFile(
            __DIR__.'/Fixtures/Issue020Test.diff',
            $dmp->patch_toText(
                $dmp->patch_make(
                    $originalXML,
                    $newXML
                )
            ),
            'None of the expected differences were found by DiffMatchPatch.'
        );
    }
}
