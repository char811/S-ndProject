<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.01.15
 * Time: 23:25
 */
use Sunra\PhpSimple\HtmlDomParser;

class Sunra
{
    protected $parser;

    /**
     * @param HtmlDomParser $parser
     */
    public function __construct(HtmlDomParser $parser)
    {
        $this->parser = $parser;
    }

    public function getHtml()
    {
        $html = $this->parser->file_get_html('http://habrahabr.ru/hubs/');

        dd($html);
    }
}