<?php

/*
 * Bear Framework HTML Template
 * https://github.com/bearframework/html-template
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class HTMLTemplateTest extends HTMLTemplateTestCase
{

    /**
     * 
     */
    public function testConstructor()
    {
        $template = new BearFramework\HTMLTemplate('<html>'
                . '<body>'
                . '<div>{{body}}</div>'
                . '<footer>{{footer}}</footer>'
                . '</body>'
                . '</html>');
        $template->insert('body', '<html>'
                . '<head>'
                . '<style>background-color:black;</style>'
                . '</head>'
                . '<body>Hello</body>'
                . '</html>');
        $template->insert('footer', '<body>The footer</body>');
        $expectedResult = '<!DOCTYPE html><html><head><style>background-color:black;</style></head><body><div>Hello</div><footer>The footer</footer></body></html>';
        $this->assertTrue($expectedResult === $template->getResult());
    }

}
