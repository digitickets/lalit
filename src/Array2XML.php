<?php
namespace LaLit;

use \DOMDocument;
use \DOMNode;
use \Exception;

/**
 * Array2XML: A class to convert array in PHP to XML
 * It also takes into account attributes names unlike SimpleXML in PHP
 * It returns the XML in form of DOMDocument class for further manipulation.
 * It throws exception if the tag name or attribute name has illegal chars.
 *
 * Author : Lalit Patel
 * Website: http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes
 * License: Apache License 2.0
 *          http://www.apache.org/licenses/LICENSE-2.0
 * Version: 0.1 (10 July 2011)
 * Version: 0.2 (16 August 2011)
 *          - replaced htmlentities() with htmlspecialchars() (Thanks to Liel Dulev)
 *          - fixed a edge case where root node has a false/null/0 value. (Thanks to Liel Dulev)
 * Version: 0.3 (22 August 2011)
 *          - fixed tag sanitize regex which didn't allow tagnames with single character.
 * Version: 0.4 (18 September 2011)
 *          - Added support for CDATA section using @cdata instead of @value.
 * Version: 0.5 (07 December 2011)
 *          - Changed logic to check numeric array indices not starting from 0.
 * Version: 0.6 (04 March 2012)
 *          - Code now doesn't @cdata to be placed in an empty array
 * Version: 0.7 (24 March 2012)
 *          - Reverted to version 0.5
 * Version: 0.8 (02 May 2012)
 *          - Removed htmlspecialchars() before adding to text node or attributes.
 *
 * Version: 1.0 (29 April 2015)
 *          - Copied to GitHub by RQuadling.
 *
 * Version: 1.2 (09 September 2015)
 *          - Static Analysis and documentation (Thanks to Maxence Winandy)
 *
 * Usage:
 *       $xml = Array2XML::createXML('root_node_name', $php_array);
 *       echo $xml->saveXML();
 */
class Array2XML
{
    /**
     * @var string $encoding
     */
    private static $encoding = 'UTF-8';

    /**
     * @var DomDocument|null $xml
     */
    private static $xml = null;

    /**
     * Convert an Array to XML
     *
     * @param string $node_name - name of the root node to be converted
     * @param array  $arr       - aray to be converterd
     *
     * @return DomDocument
     */
    public static function createXML($node_name, $arr = [])
    {
        $xml = self::getXMLRoot();
        $xml->appendChild(self::convert($node_name, $arr));

        self::$xml = null;    // clear the xml node in the class for 2nd time use.
        return $xml;
    }

    /**
     * Initialize the root XML node [optional]
     *
     * @param string $version
     * @param string $encoding
     * @param bool   $standalone
     * @param bool   $format_output
     */
    public static function init($version = '1.0', $encoding = 'UTF-8', $standalone = false, $format_output = true)
    {
        self::$xml                = new DomDocument($version, $encoding);
        self::$xml->xmlStandalone = $standalone;
        self::$xml->formatOutput  = $format_output;
        self::$encoding           = $encoding;
    }

    /**
     * Get string representation of boolean value
     *
     * @param mixed $v
     *
     * @return string
     */
    private static function bool2str($v)
    {
        //convert boolean to text value.
        $v = $v === true ? 'true' : $v;
        $v = $v === false ? 'false' : $v;

        return $v;
    }

    /**
     * Convert an Array to XML
     *
     * @param string $node_name - name of the root node to be converted
     * @param array  $arr       - array to be converted
     *
     * @return DOMNode
     * @throws Exception
     */
    private static function convert($node_name, $arr = [])
    {
        //print_arr($node_name);
        $xml  = self::getXMLRoot();
        $node = $xml->createElement($node_name);

        if (is_array($arr)) {
            // get the attributes first.;
            if (isset($arr['@attributes'])) {
                foreach ($arr['@attributes'] as $key => $value) {
                    if (!self::isValidTagName($key)) {
                        throw new Exception('[Array2XML] Illegal character in attribute name. attribute: ' . $key . ' in node: ' . $node_name);
                    }
                    $node->setAttribute($key, self::bool2str($value));
                }
                unset($arr['@attributes']); //remove the key from the array once done.
            }

            // check if it has a value stored in @value, if yes store the value and return
            // else check if its directly stored as string
            if (isset($arr['@value'])) {
                $node->appendChild($xml->createTextNode(self::bool2str($arr['@value'])));
                unset($arr['@value']);    //remove the key from the array once done.
                //return from recursion, as a note with value cannot have child nodes.
                return $node;
            } else if (isset($arr['@cdata'])) {
                $node->appendChild($xml->createCDATASection(self::bool2str($arr['@cdata'])));
                unset($arr['@cdata']);    //remove the key from the array once done.
                //return from recursion, as a note with cdata cannot have child nodes.
                return $node;
            }
        }

        //create subnodes using recursion
        if (is_array($arr)) {
            // recurse to get the node for that key
            foreach ($arr as $key => $value) {
                if (!self::isValidTagName($key)) {
                    throw new Exception('[Array2XML] Illegal character in tag name. tag: ' . $key . ' in node: ' . $node_name);
                }
                if (is_array($value) && is_numeric(key($value))) {
                    // MORE THAN ONE NODE OF ITS KIND;
                    // if the new array is numeric index, means it is array of nodes of the same kind
                    // it should follow the parent key name
                    foreach ($value as $k => $v) {
                        $node->appendChild(self::convert($key, $v));
                    }
                } else {
                    // ONLY ONE NODE OF ITS KIND
                    $node->appendChild(self::convert($key, $value));
                }
                unset($arr[$key]); //remove the key from the array once done.
            }
        }

        // after we are done with all the keys in the array (if it is one)
        // we check if it has any text value, if yes, append it.
        if (!is_array($arr)) {
            $node->appendChild($xml->createTextNode(self::bool2str($arr)));
        }

        return $node;
    }

    /**
     * Get the root XML node, if there isn't one, create it.
     *
     * @return DomDocument|null
     */
    private static function getXMLRoot()
    {
        if (empty(self::$xml)) {
            self::init();
        }

        return self::$xml;
    }

    /**
     * Check if the tag name or attribute name contains illegal characters
     * Ref: http://www.w3.org/TR/xml/#sec-common-syn
     *
     * @param string $tag
     *
     * @return bool
     */
    private static function isValidTagName($tag)
    {
        $pattern = '/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i';

        return preg_match($pattern, $tag, $matches) && $matches[0] == $tag;
    }
}
