<?php

namespace Eermolaev\Challenge\Model;

use DOMDocument;
use DOMNodeList;
use DOMXpath;

/**
 * Class DomDecorator
 * @package Eermolaev\Challenge\Model
 */
class DomDecorator
{
    /** @var DOMDocument */
    public $domDocument;

    /** @var DOMXpath */
    public $xpath;

    /**
     * DomDecorator constructor.
     * @param DOMDocument $domDocument
     */
    public function __construct(
        DOMDocument $domDocument
    )
    {
        $this->domDocument = $domDocument;
    }

    /**
     * @param $url
     */
    public function load($url)
    {

        $html = $this->loadHtml($url);
        $dom = $this->loadDomDocument($html);

        $this->generateXpath($dom);
    }

    /**
     * @param $url
     * @return false|string
     */
    public function loadHtml($url)
    {
        $html = file_get_contents($url);
        return $html;
    }

    /**
     * @param $html
     * @return DOMDocument
     */
    public function loadDomDocument($html)
    {
        $useErrors = libxml_use_internal_errors(true);

        $this->domDocument->loadHTML($html);

        libxml_use_internal_errors($useErrors);

        return $this->domDocument;
    }

    /**
     * @param $doc DOMDocument
     */
    public function generateXpath($doc)
    {
        $this->xpath = new DOMXpath($doc);
    }

    /**
     * @param $xpathQuery
     * @return DOMNodeList|false
     */
    public function query($xpathQuery)
    {
        $elements = $this->xpath->query($xpathQuery);
        return $elements;
    }

    /**
     * @param $query
     * @param $element
     * @return string
     */
    public function parseName($query, $element)
    {
        return $this->parseElementValue($query, $element);
    }

    /**
     * @param $query
     * @param $element
     * @return string
     */
    public function parseElementValue($query, $element)
    {
        $productProperty = null;
        $productPropertyNode = $this->getElement($query, $element);

        if ($productPropertyNode) {
            $productProperty = trim(preg_replace('/\s+/', ' ', strip_tags($productPropertyNode->nodeValue)));
        }

        return $productProperty;
    }

    /**
     * @param $query
     * @param $element
     * @return DOMNode|null
     */
    public function getElement($query, $element)
    {
        return $this->xpath->query($query, $element)->item(0);
    }

    /**
     * @param $query
     * @param $element
     * @return string
     */
    public function parsePrice($query, $element)
    {
        $price = $this->parseElementAttribute($query, $element);
        return $price;
    }

    /**
     * @param $query
     * @param $element
     * @return string
     */
    public function parseElementAttribute($query, $element, $attribute = 'content')
    {
        $result = null;
        $elementNode = $this->getElement($query, $element);

        if ($elementNode) {
            $result = $elementNode->getAttribute($attribute);
        }

        return $result;
    }

    /**
     * @param $query
     * @param $element
     * @return string
     */
    public function parseCurrency($query, $element)
    {
        $price = $this->parseElementAttribute($query, $element);
        return $price;
    }
}