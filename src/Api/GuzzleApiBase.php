<?php

/**
 * @file
 * Contains Searchmetrics\Api\GuzzleApiBase.
 */

namespace Searchmetrics\Api;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Searchmetrics\Config\ConnectionConfig;
use Teapot\HttpException;
use Teapot\StatusCode;

/**
 * Class GuzzleApiBase.
 *
 * @package Searchmetrics\Api
 */
abstract class GuzzleApiBase implements ApiBase
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $httpClient;

    /**
     * @var \Searchmetrics\Config\ConnectionConfig
     */
    private $config;

    /**
     * Construct a SearchmetricsApiBase object.
     *
     * @param ConnectionConfig $config
     *    Searchmetrics configuration object.
     * @param ClientInterface $http_client
     *    An authenticated Guzzle instance connected to the Searchmetrics API.
     */
    public function __construct(
        ConnectionConfig $config,
        ClientInterface $httpClient
    ) {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function makePostRequest($url, $body = [])
    {
        // TODO: Implement makePostRequest() method.
    }

    /**
     * @inheritDoc
     */
    public function makeGetRequest($url, $query_params = [])
    {
        // TODO: Implement makeGetRequest() method.
    }

    /**
     * A lower level way to submit a request to the Searchmetrics API.
     *
     * @param RequestInterface $request
     *    A PSR-7 compatible RequestInterface instance.
     *
     * @see ApiBase::makeGetRequest()
     * @see ApiBase::makePostRequest()
     *
     * @return array
     *   The JSON response from the Searchmetrics API, or an empty array if no
     *   response was given or if the status code was incorrect.
     */
    private function makeRequest(RequestInterface $request, $method = 'GET')
    {

        $response = $this->httpClient->send($request);

        $this->checkStatusCode($response);

        $json_response = json_decode($this->body(), true);

        return $json_response;

    }

    /**
     * Check the status code of a request.
     *
     * @param ResponseInterface $response
     *   The Guzzle response object to check the status code for.
     *
     * @throws HttpException
     *   Thrown when the status code is anything other than 200.
     *
     * @return int
     *   200 if the response is OK. Otherwise an exception is thrown.
     */
    private function checkStatusCode(ResponseInterface $response)
    {

        $status_code = $response->getStatusCode();

        if ($status_code !== StatusCode::OK) {

            throw new HttpException(
                $response->getBody(),
                $status_code
            );

        }

        return $status_code;

    }
}
