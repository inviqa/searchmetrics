<?php namespace Searchmetrics\Connection;

/**
 * Class GuzzleConnection.
 *
 * @package Searchmetrics\Connection
 */
interface Connection
{
    /**
     * Get the connection instance to the established Searchmetrics session.
     *
     * @return \GuzzleHttp\Client
     *   A Guzzle client instance that represents the connection to Searchmetrics.
     */
    public function getClient();

    /**
     * Make a POST request to the Searchmetrics API.
     *
     * @param string $endpoint
     *   The endpoint to make the request against.
     * @param array $body
     *   The data to send to the API.
     *
     * @return array
     *   Result of the API request.
     */
    public function makePostRequest($endpoint, $body = []);

    /**
     * Make a GET request to the Searchmetrics API.
     *
     * @param string $endpoint
     *   The endpoint to make the request against.
     * @param array $query
     *   The query to send to the API.
     *
     * @return array
     *   Result of the API request.
     */
    public function makeGetRequest($endpoint, $query_params = []);
}
