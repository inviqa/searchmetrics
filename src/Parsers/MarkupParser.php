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
    public function __construct(Crawler $markup)
    {

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
    public function getElementCount($tag)
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

    /**
     * Get a list of all words in the provided markup.
     *
     * @return array
     *   An array of words usage counts used in the markup snippet provided, keyed by word. Sorted from highest
     *   frequency to lowest.
     */
    public function getTerms()
    {

        // Remove tags and lowercase all words to prevent duplicates.
        $cleanMarkup = strip_tags(strtolower($this->getMarkup()));

        // Count the output and sort from highest to lowest.
        $namePattern = '/[\s,:?!]+/u';
        $wordsArray = preg_split($namePattern, $cleanMarkup, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_count_values($wordsArray);
        asort($words);
        $words = array_reverse($words);

        return $words;

    }

    /**
     * Get a word count of the provided markup.
     *
     * @return int
     *  Count the words in the markup string provided.
     */
    public function getTermCount()
    {
        return array_sum($this->getTerms());
    }

    /**
     * Get a duplicate of the API crawl key for the provided markup.
     *
     * @return array
     *   An array of element counts that duplicate the response from Searchmetrics.
     */
    public function getKpiApiResponse()
    {

        $crawl = [
            'url' => 'text',
            'elements' => [
                'h1' => $this->getElementCount('h1'),
                'h2' => $this->getElementCount('h2'),
                'img' => $this->getElementCount('img'),
                'video' => $this->getElementCount('video'),
                'author' => $this->getElementCount('author'),
            ],
            'termCount' => $this->getTermCount(),
        ];

        return $crawl;

    }

    /**
     * Get the count for the amount of terms in the provided markup.
     *
     * @param string $term
     *   The term to look for in the provided markup.
     *
     * @return int
     *   The number of times the provided string appears in the markup.
     */
    public function getKeywordFrequency($term)
    {

        $terms = $this->getTerms();

        return (isset($terms[$term])) ? $terms[$term] : 0;

    }
}
