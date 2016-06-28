<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/19/2016
 * Time: 4:14 PM
 */
class PageCompiler
{
    private $_page;
    public function __construct(AbstractPage $page)
    {
        $this->_page = $page;
    }

    public function compile(){
        ob_start();
        $this->_page->createPage();
        $compiled_page = ob_get_clean();
        $xml = new DOMDocument("1.0", "ISO-8859-1");
        $xml->loadHTML($compiled_page);
        echo $xml->saveHTML();
    }
}