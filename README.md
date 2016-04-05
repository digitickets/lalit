[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rquadling/lalit.svg?style=plastic)](https://scrutinizer-ci.com/g/rquadling/lalit/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/rquadling/lalit.svg?style=plastic)](https://scrutinizer-ci.com/coverage/g/rquadling/lalit/?branch=master)
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/rquadling/lalit.svg?style=plastic)](https://scrutinizer-ci.com/build/g/rquadling/lalit/?branch=master)
[![Travid Build Status](https://img.shields.io/travis/rquadling/lalit.svg?style=plastic)](https://travis-ci.org/rquadling/lalit)
[![Latest Stable Version](https://img.shields.io/packagist/v/rquadling/lalit.svg?style=plastic)](https://packagist.org/packages/rquadling/lalit)
[![Packagist](https://img.shields.io/packagist/dt/rquadling/lalit.svg?style=plastic)](https://packagist.org/packages/rquadling/lalit)

LaLit's XML2Array / Array2XML
=============================

A `\RQuadling\LaLit` allows you to convert XML to a PHP array and back again.

The base code was developed by Lalit Patel and is available from http://www.lalit.org/lab/

XML2Array : http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array/
Array2XML : http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes/

I've added additional unit tests via a generator (so probably too many tests)

@todo
=====

1. Add support for <!-- comments --> within the XML, such that when converting from XML -> PHP -> XML, the comments are preserved.
