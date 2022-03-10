<?php

namespace LaLit;

use DOMDocument;

trait InitTrait
{
    /**
     * @var DOMDocument
     */
    protected static $xml = null;

    /**
     * @var string
     */
    protected static $domVersion = Constants::DEFAULT_DOM_VERSION;

    /**
     * @var string
     */
    protected static $encoding = Constants::DEFAULT_ENCODING;

    /**
     * @var bool
     */
    protected static $standalone = Constants::DEFAULT_STANDALONE;

    /**
     * @var bool
     */
    protected static $formatOutput = Constants::DEFAULT_FORMAT_OUTPUT;

    /**
     * @var string
     */
    protected static $labelAttributes = Constants::LABEL_ATTRIBUTES;

    /**
     * @var string
     */
    protected static $labelCData = Constants::LABEL_CDATA;

    /**
     * @var string
     */
    protected static $labelDocType = Constants::LABEL_DOCTYPE;

    /**
     * @var string
     */
    protected static $labelValue = Constants::LABEL_VALUE;

    /**
     * Initialize the root XML node and labels [optional].
     *
     * Supplying `null` to any parameter will cause the value to be reset to its default value.
     *
     * @param string|null $version Defaults to '1.0' (Constants::DEFAULT_DOM_VERSION)
     * @param string|null $encoding Defaults to 'utf-8' (Constants::DEFAULT_ENCODING)
     * @param bool|null $standalone Defaults to false (Constants::DEFAULT_STANDALONE)
     * @param bool|null $format_output Defaults to true (Constants::DEFAULT_FORMAT_OUTPUT)
     * @param string|null $labelAttributes Defaults to '@attributes' (Constants::LABEL_ATTRIBUTES)
     * @param string|null $labelCData Defaults to '@cdata' (Constants::LABEL_CDATA)
     * @param string|null $labelDocType Defaults to '@docType' (Constants::LABEL_DOCTYPE)
     * @param string|null $labelValue Defaults to '@value' (Constants::LABEL_VALUE)
     */
    public static function init(
        string $version = null,
        string $encoding = null,
        bool $standalone = null,
        bool $format_output = null,
        string $labelAttributes = null,
        string $labelCData = null,
        string $labelDocType = null,
        string $labelValue = null
    ) {
        self::setDomVersion($version);
        self::setEncoding($encoding);
        self::setStandalone($standalone);
        self::setFormatOutput($format_output);

        self::setLabelAttributes($labelAttributes);
        self::setLabelCData($labelCData);
        self::setLabelDocType($labelDocType);
        self::setLabelValue($labelValue);

        self::$xml = new DomDocument(self::getDomVersion(), self::getEncoding());
        self::$xml->xmlStandalone = self::isStandalone();
        self::$xml->formatOutput = self::isFormatOutput();
    }


    public static function getDomVersion(): string
    {
        return self::$domVersion;
    }

    public static function getEncoding(): string
    {
        return self::$encoding;
    }

    public static function isStandalone(): bool
    {
        return self::$standalone;
    }

    public static function isFormatOutput(): bool
    {
        return self::$formatOutput;
    }

    protected static function setDomVersion(string $domVersion = null)
    {
        self::$domVersion = $domVersion ?? Constants::DEFAULT_DOM_VERSION;
    }

    protected static function setEncoding(string $encoding = null)
    {
        self::$encoding = $encoding ?? Constants::DEFAULT_ENCODING;
    }

    protected static function setStandalone(bool $standalone = null)
    {
        self::$standalone = $standalone ?? Constants::DEFAULT_STANDALONE;
    }

    protected static function setFormatOutput(bool $formatOutput = null)
    {
        self::$formatOutput = $formatOutput ?? Constants::DEFAULT_FORMAT_OUTPUT;
    }

    public static function getLabelAttributes(): string
    {
        return self::$labelAttributes;
    }

    public static function getLabelCData(): string
    {
        return self::$labelCData;
    }

    public static function getLabelDocType(): string
    {
        return self::$labelDocType;
    }

    public static function getLabelValue(): string
    {
        return self::$labelValue;
    }

    protected static function setLabelAttributes(string $labelAttributes = null)
    {
        self::$labelAttributes = $labelAttributes ?? Constants::LABEL_ATTRIBUTES;
    }

    protected static function setLabelCData(string $labelCData = null)
    {
        self::$labelCData = $labelCData ?? Constants::LABEL_CDATA;
    }

    protected static function setLabelDocType(string $labelDocType = null)
    {
        self::$labelDocType = $labelDocType ?? Constants::LABEL_DOCTYPE;
    }

    protected static function setLabelValue(string $labelValue = null)
    {
        self::$labelValue = $labelValue ?? Constants::LABEL_VALUE;
    }
}
