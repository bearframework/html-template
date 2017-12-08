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

    private $html = '';
    private $pendingInserts = [];

    /**
     * 
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * 
     * @param string $html
     * @param string $target
     * @return \BearFramework\HTMLTemplate Returns a reference to itself
     */
    public function insert(string $html, string $target = null): \BearFramework\HTMLTemplate
    {
        $this->pendingInserts[] = [
            'source' => $html,
            'target' => $target
        ];
        return $this;
    }

    /**
     * 
     * @param string $html
     * @return \BearFramework\HTMLTemplate Returns a reference to itself
     */
    public function set(string $html): \BearFramework\HTMLTemplate
    {
        $this->html = $html;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function get(): string
    {
        if ($this->html === '') {
            return '';
        }
        if (!empty($this->pendingInserts)) {
            $domDocument = new \IvoPetkov\HTML5DOMDocument();
            foreach ($this->pendingInserts as $pendingInsert) {
                if ($pendingInsert['target'] !== null) {
                    $this->html = str_replace('{{' . $pendingInsert['target'] . '}}', $domDocument->createInsertTarget($pendingInsert['target']), $this->html);
                }
            }
            $domDocument->loadHTML($this->html);
            $domDocument->insertHTMLMulti($this->pendingInserts);
            $this->pendingInserts = [];
            $this->html = $domDocument->saveHTML();
        }
        return $this->html;
    }

}
