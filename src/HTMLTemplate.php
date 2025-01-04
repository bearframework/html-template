<?php

/*
 * Bear Framework HTML Template
 * https://github.com/bearframework/html-template
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

use IvoPetkov\HTML5DOMDocument;

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
    public function insert(string $html, ?string $target = null): \BearFramework\HTMLTemplate
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
            $dom = new HTML5DOMDocument();
            foreach ($this->pendingInserts as $pendingInsert) {
                if ($pendingInsert['target'] !== null) {
                    $this->html = str_replace('{{' . $pendingInsert['target'] . '}}', $dom->createInsertTarget($pendingInsert['target']), $this->html);
                }
            }
            $dom->loadHTML($this->html, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
            $dom->insertHTMLMulti($this->pendingInserts);
            $dom->modify(
                HTML5DOMDocument::FIX_DUPLICATE_METATAGS |
                    HTML5DOMDocument::FIX_MULTIPLE_BODIES |
                    HTML5DOMDocument::FIX_MULTIPLE_HEADS |
                    HTML5DOMDocument::FIX_MULTIPLE_TITLES |
                    HTML5DOMDocument::OPTIMIZE_HEAD
            );
            $this->pendingInserts = [];
            $this->html = $dom->saveHTML();
        }
        return $this->html;
    }

}
