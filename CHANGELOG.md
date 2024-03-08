# Version History

## 3.4.0 - 2024/03/08

- Removed Scrutinzer, Stickler, and TravisCI configurations.
- Allow any/all versions for testing, remove Mockery (as it is unused) and introduce a Diff check for the more complex
  comparisons with running unit tests.
- Add parameter type hints up to PHP 7.0 standards.
- Stop warnings about null being used as a value.
- Replace invalid XML document warnings with an exception.
- Add support for namespaces in root node (Thank you blagi [#20](https://github.com/digitickets/lalit/issues/20)).
- Throw `Exception` for invalid characters when using `Array2XML::createXML()` for normal values, `@value`, and `cdata`
  values (Thank you Jānis Elmeris [#17](https://github.com/digitickets/lalit/issues/17)).
- Introduce GitHub workflow, testing the library on all versions from PHP 7.0 to 8.3

### Significant upgrades to unit test files:
- Introduce a proxy for PHPUnit's deprecation of `expectExceptionMessageRegExp($messageRegExp)`.
- Partially fix the PHPUnit `phpunit.xml` configuration file.
- Use the new proxy for all tests.
- Replace the deprecated docblock entries for `@exceptedException` / `@expectedExceptionMessage` with their equivalent
  method calls `$this->expectedException()` / `$this->exceptedExceptionMessage()`.
- Fix all data providers that have keys for the value in the datasets to match the parameter names of the test method.
  The use of named parameters was introduced in PHP 8.0.
- Introduce the new attributes mechanism for data providers. This does NOT conflict with the older `@dataProvider`
  docblock annotation.

## v3.3.0 - 2022/03/10

- Fix namespaced attributes (Thank you Nitin Patel and Mirko Temperini [#10](https://github.com/digitickets/lalit/issues/10))

## v3.2.0 - 2022/03/10

- Allow alternative labels to be defined (Thank you Frank Aguirre [#16](https://github.com/digitickets/lalit/pull/16))
- Fix leading, embedded, and trailing newlines (no longer trims the data being).

## v3.1.0 - 2019/02/01

- Limited support for <!DOCTYPE> (only PUBLIC and SYSTEM DTDs supported at the moment) (Thank you Nezabor [#8](https://github.com/digitickets/lalit/issues/8))

## v3.0.1 - 2017/12/21

- Zero values/cdata are now handled appropriately (Thank you Daniel Carl [#6](https://github.com/digitickets/lalit/pull/6))

## v3.0 - 2017/02/09

- Dropped support for PHP < 7.0

## v2.0 - 2016/11/17

- Ownership transferred to Digitickets

## v1.6 - 2016/07/27

- Empty values/attributes/cdata are now handled appropriately (Fixes [#3](https://github.com/rquadling/lalit/issues/3))

## v1.5 - 2016/06/29

- Reintroduce support for hhvm
- Upgrade dependencies
- Fixed hhvm reading of broken xml not generating an exception
- Added CHANGELOG and removed version data from classes

## v1.4 - 2016/04/05

- Enhanced to support Travis-CI, Scrutinizer.
- Enhanced with appropriate .gitattributes and .gitignore
- Introduced PHPUnit and unit tests
- Added README
- ISSUE: Removed support for hhvm in Travis-CI.

## v1.3 - 2015/11/05

- Fix empty nodes no longer reset any accumulated content for that level (Fixes [#2](https://github.com/rquadling/lalit/issues/2))

## v1.2 - 2015/09/09

- Enhanced static analysis and added DocBlocks

## v1.1 - 2015/09/06

- Fix namespace issue when combined with Symfony (Thank you Maxence Winandy [#1](https://github.com/rquadling/lalit/pull/1))

## v1.0 - 2015/04/29

- Initial commit of Lalit Patel's XML2Array and Array2XML classes that allow XML <=> Array operation.
