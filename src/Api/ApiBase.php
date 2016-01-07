<?php namespace Searchmetrics\Api;

/**
 * Class ApiBase.
 *
 * @package Searchmetrics\Api
 */
interface ApiBase
{

    /**
     * Make a POST request to the Searchmetrics API.
     *
     * @param string $url
     *   The URL to make the request against.
     * @param array $body
     *   The data to send to the API.
     *
     * @return array
     *   Result of the API request.
     */
    public function makePostRequest($url, $body = array());

    /**
     * Make a GET request to the Searchmetrics API.
     *
     * @param string $url
     *   The URL to make the request against.
     * @param array $query_params
     *   The data to send to the API.
     *
     * @return array
     *   Result of the API request.
     */
    public function makeGetRequest($url, $query_params = array());
}
