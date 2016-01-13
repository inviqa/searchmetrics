<?php

namespace Searchmetrics\Parsers;

/**
 * Class MustHaveKeywordResponseParser
 * @package Searchmetrics\Parsers
 */
class MustHaveKeywordResponseParser implements ParserInterface
{

    /**
     * Construct a SearchmetricsMustHaveKeywordResponseParser instance.
     */
    public function __construct(\SearchmetricsScan $scan)
    {
        $this->response = unserialize($scan->mh_keywords_response);
        $this->kpiResponse = unserialize($scan->kpi_response);
    }

    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        $parsed = array();

        foreach ($this->response as $response_item) {
            $parsed[] = array(
                'keyword' => $this->getKeyword($response_item),
                'own_weighting' => $this->getOwnWeighting($response_item),
                'own_frequency' => $this->getOwnFrequency($response_item),
                'market_weighting' => $this->getMarketWeighting($response_item),
                'own_term_count' => $this->getOwnTermCount($response_item),
                'new_term_count' => $this->getNewTermCount($response_item),
                'recommended_frequency' => round($this->getRecommendedFrequency($response_item)),
            );
        }

        return $parsed;
    }

    /**
     * Get the recommended keyword.
     *
     * @param array $response_item
     *   A single item from the main response.
     *
     * @return string
     *   A recommended keyword.
     */
    private function getKeyword(array $response_item)
    {
        return $response_item['keyword'];
    }

    /**
     * Get the own weighting of a keyword.
     *
     * @param array $response_item
     *   A single item from the main response.
     *
     * @return string
     *   The own weighting of a keyword
     */
    private function getOwnWeighting(array $response_item)
    {
        return $response_item['opt_wdf'];
    }

    /**
     * Get the own frequency of a keyword.
     *
     * @param array $response_item
     *   A single item from the main response.
     *
     * @return string
     *   The own frequency of a keyword.
     */
    private function getOwnFrequency(array $response_item)
    {
        return $response_item['opt_tf'];
    }

    /**
     * Get the market weighting for the keyword.
     *
     * @param array $response_item
     *   A single item from the main response.
     *
     * @return string
     *   The market weighting for the keyword
     */
    private function getMarketWeighting(array $response_item)
    {
        return $response_item['wdf_max'];
    }

    /**
     * Get the own term count from a response.
     *
     * @return string
     *   The own term count from a response.
     */
    private function getOwnTermCount()
    {
        return $this->kpiResponse['crawl'][0]['termCount'];
    }

    /**
     * Get the new term count from a response.
     *
     * @return string
     *   The new term count from a response.
     */
    private function getNewTermCount()
    {

        $crawl_count = $this->kpiResponse['crawled_urls'];
        $term_total = 0;

        // We start at one so we don't include the text we sent to Searchmetrics.
        for ($i = 1; $i <= $crawl_count; $i++) {
            $term_total += $this->kpiResponse['crawl'][$i]['termCount'];
        }

        // We need to ensure we remove the provided text from the total.
        return $term_total / $crawl_count - 1;
    }

    /**
     * Get the recommended frequency of the keyword.
     *
     * @param array $response_item
     *   A single item from the main response.
     *
     * @return string
     *   The recommended frequency of the keyword
     */
    private function getRecommendedFrequency(array $response_item)
    {
        $own_frequency = $this->getOwnFrequency($response_item);
        $own_weighting = $this->getOwnWeighting($response_item);
        $market_weighting = $this->getMarketWeighting($response_item);
        $own_term_count = $this->getOwnTermCount($response_item);
        $new_term_count = $this->getNewTermCount($response_item);

        if (($own_weighting * $market_weighting) <= 0 || ($own_term_count <= 0)) {
            return 0;
        }

        return (($own_frequency / $own_weighting * $market_weighting) / $own_term_count) * $new_term_count;
    }
}