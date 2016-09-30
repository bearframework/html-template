<?php

/*
 * Bear Framework HTML Template
 * https://github.com/bearframework/html-template
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * 
 */
class HTMLTemplate
{

    private $htmlCode = '';
    private $insertedData = [];

    public function __construct($htmlCode)
    {
        $this->htmlCode = $htmlCode;
    }

    public function insert($name, $htmlCode)
    {
        $this->insertedData[$name] = $htmlCode;
    }

    public function getResult()
    {
        if ($this->htmlCode === '') {
            return '';
        }
        $domDocument = new \IvoPetkov\HTML5DomDocument();
        $htmlCode = $this->htmlCode;
        foreach ($this->insertedData as $targetName => $targetHtmlCode) {
            $htmlCode = str_replace('{{' . $targetName . '}}', $domDocument->createInsertTarget($targetName), $htmlCode);
        }
        $domDocument->loadHTML($htmlCode);
        foreach ($this->insertedData as $targetName => $targetHtmlCode) {
            $domDocument->insertHTML($targetHtmlCode, $targetName);
        }
        return $domDocument->saveHTML();
    }

}
