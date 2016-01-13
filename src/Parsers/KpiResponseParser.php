<?php

namespace Searchmetrics\Parsers;

/**
 * Class KpiResponseParser
 * @package Searchmetrics\Parsers
 */
class KpiResponseParser implements ParserInterface
{

    /**
     * An instantiated header parser.
     *
     * @var \Drupal\searchmetrics\Parsers\SearchmetricsHeadingParser
     */
    protected $headingParser;

    protected $response;

    protected $markup;

    /**
     * Construct a SearchmetricsKpiResponseParser instance.
     */
    public function __construct(\SearchmetricsScan $scan)
    {
        $this->response = unserialize($scan->kpi_response);
        $this->markup = $scan->markup;

        // Let us manage our own errors.
        libxml_use_internal_errors(TRUE);
        $this->domDocument = $this->getDomDocument();
    }

    /**
     * Get a DOMDocument instance containing the scanned text.
     *
     * @return \DOMDocument
     *   A DOMDocument instance containing the scanned text.
     */
    private function getDomDocument()
    {

        $dom = new \DOMDocument();
        $dom->loadHTML($this->markup);

        return $dom;
    }

    /**
     * Get the content of all headings on the page.
     *
     * @param string $heading_type
     *   The type of heading you want the values for (i.e. H1 or H2).
     *
     * @return array
     *   An array containing the values of all of the specified levels of heading
     *   requested.
     */
    private function getHeadingContent($heading_type = 'h1')
    {

        $tags = $this->domDocument->getElementsByTagName($heading_type);
        $heading_content = array();

        foreach ($tags as $tag) {
            $heading_content[] = $tag->nodeValue;
        }

        return $heading_content;

    }

    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        $parsed = array();
        $word_count = array();
        $word_count['own_term_count'] = $this->getOwnTermCount($this->response);
        $word_count['new_term_count'] = $this->getNewTermCount($this->response);

        $own_heading_term_counts = $this->getOwnHeadingCounts($this->markup);

        $h1_count = array();
        $h1_count['own_term_count'] = $own_heading_term_counts['h1'];
        $h1_count['new_term_count'] = $this->getHeaderNewTermCount($this->response, 'h1');

        $h2_count = array();
        $h2_count['own_term_count'] = $own_heading_term_counts['h2'];
        $h2_count['new_term_count'] = $this->getHeaderNewTermCount($this->response, 'h2');

        $parsed['word_count'] = $word_count;
        $parsed['h1_count'] = $h1_count;
        $parsed['h2_count'] = $h2_count;

        $parsed['heading_content'] = $this->getHeadingContentArray();

        return $parsed;
    }

    /**
     * Get heading content from a Searchmetrics scan.
     *
     * @return array
     *   An array containing header content for all H1s and H2s on the scanned
     *   text, as well as all header terms for all other scanned pages, with
     *   their count as the value.
     */
    private function getHeadingContentArray()
    {

        return array(
            'h1' => $this->getHeadingContent(),
            'h2' => $this->getHeadingContent('h2'),
            'top_keywords_in_headings' => $this->getTopKeywordsInHeadings(5),
        );

    }

    /**
     * Get the crawls own term count.
     *
     * @param array $response
     *   The main response.
     *
     * @return int $own_term_count
     *   The own term word count.
     */
    private function getOwnTermCount(array $response)
    {
        $own_term_count = 0;
        if (isset($response['crawl'])) {
            $own_crawl = array_shift($response['crawl']);
            $own_term_count = $own_crawl['termCount'];
        }
        return $own_term_count;
    }

    /**
     * Get the crawls new term count.
     *
     * @param array $response
     *   The main response.
     *
     * @return int $new_term_count
     *   The new term word count.
     */
    private function getNewTermCount(array $response)
    {
        $new_term_count = 0;
        $crawls = $response['crawl'];

        // Remove the first element as that's the 'own term' count.
        reset($crawls);
        $key = key($crawls);
        unset($crawls[$key]);

        $url_term_count_total = 0;

        if (!empty($crawls)) {
            foreach ($crawls as $crawl) {
                $url_term_count_total += $crawl['termCount'];
            }
        }

        $new_term_count = (int)ceil($url_term_count_total / $response['crawled_urls']);

        return $new_term_count;
    }

    /**
     * Get the crawls new term count.
     *
     * @param array $response
     *   The main response.
     * @param string $tag
     *   The html tag we're getting counts for.
     *
     * @return int $new_term_count
     *   The new term word count.
     */
    private function getHeaderNewTermCount(array $response, $tag = 'h1')
    {
        $new_term_count = 0;
        $crawls = $response['crawl'];

        // Remove the first element as that's the 'own term' count.
        reset($crawls);
        $key = key($crawls);
        unset($crawls[$key]);

        $url_term_count_total = 0;
        if (!empty($crawls)) {
            foreach ($crawls as $crawl) {
                if (isset($crawl[$tag])) {
                    $url_term_count_total += count($crawl[$tag]);
                }
            }
        }
        $new_term_count = (int)ceil($url_term_count_total / $response['crawled_urls']);
        return $new_term_count;
    }

    /**
     * Parse the crawled markup and return h1 and h2 counts.
     *
     * @param string $markup
     *    The html string that was crawled.
     *
     * @return array
     *    The counts of h1 and h2 tags in $markup.
     */
    private function getOwnHeadingCounts($markup = '')
    {

        return array(
            'h1' => $this->domDocument->getElementsByTagName('h1')->length,
            'h2' => $this->domDocument->getElementsByTagName('h2')->length,
        );

    }

    /**
     * Sort the keywords used in the headings of all sites by usage.
     *
     * @param null|int $limit
     *   The amount of results to return post-sort. NULL or no value will return
     *   ALL values.
     *
     * @return array
     *   An array of word counts for words used in headings keyed by the term
     *   itself.
     */
    private function getTopKeywordsInHeadings($limit = NULL)
    {

        $keywords = $this->getAllHeaderTerms();

        $keyword_count = array_count_values($keywords);
        arsort($keyword_count);

        return array_slice($keyword_count, 0, $limit);
    }

    /**
     * Get all headings from every site scanned.
     *
     * @return array
     *   An array of all headings combined into a single array. Does not
     *   differentiate between H1 and H2.
     */
    private function getAllHeadings()
    {

        $crawl = $this->response['crawl'];
        // Remove the first crawl item, as that's our provided text.
        unset($crawl[0]);

        $headings = array();

        // Get all heading content.
        foreach ($crawl as $crawl_item) {

            $headings[] = $crawl_item['h1'];
            $headings[] = $crawl_item['h2'];

        }

        // Loop over all elements recursively and pull out the headings.
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($headings));

        $processed_headings = array();

        foreach ($iterator as $heading_item) {

            $processed_headings[] = $heading_item;

        }

        return array_filter($processed_headings);

    }

    /**
     * Split each heading used into individual terms.
     *
     * @return array
     *   An unordered array of every word used in a heading for each scanned
     *   sites.
     */
    private function getAllHeaderTerms()
    {

        $headings = $this->getAllHeadings();
        $processed = array();

        foreach ($headings as $heading) {

            // We use preg_split here instead of explode() to account for multiple
            // spaces in between words.
            $processed = array_merge($processed, preg_split('/\s+/', trim($heading)));

        }

        return $processed;
    }
}
