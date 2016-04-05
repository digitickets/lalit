<?php
namespace LaLit;

use DOMDocument;
use DOMNode;
use Exception;

/**
 * XML2Array: A class to convert XML to array in PHP
 * It returns the array which can be converted back to XML using the Array2XML script
 * It takes an XML string or a DOMDocument object as an input.
 *
 * See Array2XML: http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes
 *
 * Author : Lalit Patel
 * Website: http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array
 * License: Apache License 2.0
 *          http://www.apache.org/licenses/LICENSE-2.0
 * Version: 0.1 (07 Dec 2011)
 * Version: 0.2 (04 Mar 2012)
 *            Fixed typo 'DomDocument' to 'DOMDocument'
 *
 * Version: 1.0 (29 April 2015)
 *          - Copied to GitHub by RQuadling.
 *
 * Version: 1.2 (09 September 2015)
 *          - Static Analysis and documentation (Thanks to Maxence Winandy)
 *
 * Usage:
 *       $array = XML2Array::createArray($xml);
 */
class XML2Array
{
    /**
     * @var string $encoding
     */
    private static $encoding = 'UTF-8';

    /**
     * @var DOMDocument
     */
    private static $xml = null;

    /**
     * Convert an XML to Array
     *
     * @param string|DOMDocument $input_xml
     *
     * @return array
     * @throws Exception
     */
    public static function createArray($input_xml)
    {
        $xml = self::getXMLRoot();
        if (is_string($input_xml)) {
            try {
                $xml->loadXML($input_xml);
            } catch (Exception $ex) {
                throw new Exception('[XML2Array] Error parsing the XML string.' . PHP_EOL . $ex->getMessage());
            }
        } elseif (is_object($input_xml)) {
            if (get_class($input_xml) != 'DOMDocument') {
                throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
            }
            $xml = self::$xml = $input_xml;
        } else {
            throw new Exception('[XML2Array] Invalid input');
        }
        $array[$xml->documentElement->tagName] = self::convert($xml->documentElement);
        self::$xml                             = null;    // clear the xml node in the class for 2nd time use.
        return $array;
    }

    /**
     * Initialize the root XML node [optional]
     *
     * @param string $version
     * @param string $encoding
     * @param bool   $standalone
     * @param bool   $format_output
     */
    public static function init($version = '1.0', $encoding = 'utf-8', $standalone = false, $format_output = true)
    {
        self::$xml                = new DomDocument($version, $encoding);
        self::$xml->xmlStandalone = $standalone;
        self::$xml->formatOutput  = $format_output;
        self::$encoding           = $encoding;
    }

    /**
     * Convert an Array to XML
     *
     * @param DOMNode $node - XML as a string or as an object of DOMDocument
     *
     * @return array
     */
    private static function convert(DOMNode $node)
    {
        $output = [];

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
                $output['@cdata'] = trim($node->textContent);
                break;

            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;

            case XML_ELEMENT_NODE:

                // for each child node, call the covert function recursively
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v     = self::convert($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        // assume more nodes of same kind are coming
                        if (!isset($output[$t])) {
                            $output[$t] = [];
                        }
                        $output[$t][] = $v;
                    } else {
                        //check if it is not an empty node
                        if (!empty($v)) {
                            $output = $v;
                        }
                    }
                }

                if (is_array($output)) {
                    // if only one node of its kind, assign it directly instead if array($value);
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1) {
                            $output[$t] = $v[0];
                        }
                    }
                    if (empty($output)) {
                        //for empty nodes
                        $output = '';
                    }
                }

                // loop through the attributes and collect them
                if ($node->attributes->length) {
                    $a = [];
                    foreach ($node->attributes as $attrName => $attrNode) {
                        $a[$attrName] = $attrNode->value;
                    }
                    // if its an leaf node, store the value in @value instead of directly storing it.
                    if (!is_array($output)) {
                        $output = ['@value' => $output];
                    }
                    $output['@attributes'] = $a;
                }
                break;
        }

        return $output;
    }

    /**
     * Get the root XML node, if there isn't one, create it.
     *
     * @return DOMDocument
     */
    private static function getXMLRoot()
    {
        if (empty(self::$xml)) {
            self::init();
        }

        return self::$xml;
    }
}
