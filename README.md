# LaLit's XML2Array / Array2XML

[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/digitickets/lalit/.github%2Fworkflows%2Ftest.yml?style=for-the-badge&logo=GitHub)](https://github.com/digitickets/lalit/actions)
[![GitHub issues](https://img.shields.io/github/issues/digitickets/lalit.svg?style=for-the-badge&logo=github)](https://github.com/digitickets/lalit/issues)

[![PHP Version](https://img.shields.io/packagist/php-v/digitickets/lalit.svg?style=for-the-badge)](https://github.com/digitickets/lalit)
[![Stable Version](https://img.shields.io/packagist/v/digitickets/lalit.svg?style=for-the-badge&label=Latest)](https://packagist.org/packages/digitickets/lalit)

[![Total Downloads](https://img.shields.io/packagist/dt/digitickets/lalit.svg?style=for-the-badge&label=Total+downloads)](https://packagist.org/packages/digitickets/lalit)
[![Monthly Downloads](https://img.shields.io/packagist/dm/digitickets/lalit.svg?style=for-the-badge&label=Monthly+downloads)](https://packagist.org/packages/digitickets/lalit)
[![Daily Downloads](https://img.shields.io/packagist/dd/digitickets/lalit.svg?style=for-the-badge&label=Daily+downloads)](https://packagist.org/packages/digitickets/lalit)

`\digitickets\LaLit` allows you to convert XML to a PHP array and back again.

The base code was developed by Lalit Patel and is available from http://www.lalit.org/lab/

XML2Array : http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array/
Array2XML : http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes/

I've added additional unit tests via a generator (so probably too many tests)

# Extended usage

## Alternative labelling

As of v3.2.0, the `init()` method has been expanded to allow the labels used in the output `XML2Array::createArray()` and
the input to `Array2XML::createXML()` to be changed. Any value, where `null` is supplied will revert to the default value.

# Version History

Please read the [CHANGELOG](CHANGELOG.md) document.

# @todo

1. Add support for `<!-- comments -->` within the XML, such that when converting from XML -> PHP -> XML, the comments are preserved.
