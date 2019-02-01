# LaLit's XML2Array / Array2XML

[![Build Status](https://img.shields.io/travis/digitickets/lalit.svg?style=for-the-badge&logo=travis)](https://travis-ci.org/digitickets/lalit)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/digitickets/lalit.svg?style=for-the-badge&logo=scrutinizer)](https://scrutinizer-ci.com/g/digitickets/lalit/)
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

# Version History

Please read the [CHANGELOG](CHANGELOG.md) document.

# @todo

1. Add support for `<!-- comments -->` within the XML, such that when converting from XML -> PHP -> XML, the comments are preserved.
