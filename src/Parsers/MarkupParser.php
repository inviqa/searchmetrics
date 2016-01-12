<?php namespace Searchmetrics\Parsers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class MarkupParser.
 *
 * @package Searchmetrics\Parsers
 */
class MarkupParser
{

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    /**
     * MarkupParser constructor.
     *
     * @param string|Crawler $markup
     *   The markup string to parse. You can also pass an instantiated Symfony DomCrawler instance.
     */
    public function __construct($markup)
    {

        // If the provided markup is not a DomCrawler instance, then convert it to one so we know what we're working
        // with.
        if (!$markup instanceof Crawler) {
            $markup = new Crawler($markup);
        }

        $this->crawler = $markup;

    }

    /**
     * Get the DomCrawler instance created from markup provided during class instantiation.
     *
     * @return Crawler
     *   The DomCrawler instance created from markup provided during class instantiation.
     */
    public function getCrawler()
    {

        return $this->crawler;

    }

    /**
     * Get the raw markup that was provided to the class during instantiation.
     *
     * @return string
     *   The raw markup that was provided to the class during instantiation.
     */
    public function getMarkup()
    {

        return $this->crawler->html();

    }

    /**
     * Get the amount of tags present in the provided HTML string.
     *
     * @param string $tag
     *   The HTML tag to count in the provided HTML string.
     *
     * @return int
     *   The amount of required tags present in the provided markup.
     */
    public function getTagCount($tag)
    {

        $elements = $this->crawler->filter($tag);
        return count($elements);

    }

    /**
     * Get the content in the headings of the provided markup.
     *
     * @param string $heading
     *   The level of heading to grab the content for. Defaults to H1.
     *
     * @return array
     *   An array containing the contents of all required heading elements in the provided markup.
     */
    public function getHeadingContent($heading = 'h1')
    {

        $headings = $this->crawler->filter($heading);
        return $headings->extract('_text');

    }


}
