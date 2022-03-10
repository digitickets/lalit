# Version History

**3.2.0** (2022/03/10)

* Allow alternative labels to be defined (Thank you Frank Aguirre [#16](https://github.com/digitickets/lalit/pull/16))
* Fix leading, embedded, and trailing newlines (no longer trims the data being).

**3.1.0** (2019/02/01)

* Limited support for <!DOCTYPE> (only PUBLIC and SYSTEM DTDs supported at the moment) (Thank you Nezabor [#8](https://github.com/digitickets/lalit/issues/8))

**3.0.1** (2017/12/21)

* Zero values/cdata are now handled appropriately (Thank you Daniel Carl [#6](https://github.com/digitickets/lalit/pull/6))

**3.0** (2017/02/09)

* Dropped support for PHP < 7.0

**2.0** (2016/11/17)

* Ownership transferred to Digitickets

**1.6** (2016/07/27)

* Empty values/attributes/cdata are now handled appropriately (Fixes [#3](https://github.com/rquadling/lalit/issues/3))

**1.5** (2016/06/29)

* Reintroduce support for hhvm
* Upgrade dependencies
* Fixed hhvm reading of broken xml not generating an exception
* Added CHANGELOG and removed version data from classes

**1.4** (2016/04/05)

* Enhanced to support Travis-CI, Scrutinizer.
* Enhanced with appropriate .gitattributes and .gitignore
* Introduced PHPUnit and unit tests
* Added README
* ISSUE: Removed support for hhvm in Travis-CI.

**1.3** (2015/11/05)

* Fix empty nodes no longer reset any accumulated content for that level (Fixes [#2](https://github.com/rquadling/lalit/issues/2))

**1.2** (2015/09/09)

* Enhanced static analysis and added DocBlocks

**1.1** (2015/09/06)

* Fix namespace issue when combined with Symfony (Thank you Maxence Winandy [#1](https://github.com/rquadling/lalit/pull/1))

**1.0** (2015/04/29)

* Initial commit of Lalit Patel's XML2Array and Array2XML classes that allow XML <=> Array operation.
