<?php

namespace Searchmetrics\Config;

/**
 * Class ConnectionConfig.
 *
 * @package Searchmetrics\Config
 */
class ConnectionConfig
{

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $apiVersion = 'v3';

    /**
     * ConnectionConfig constructor.
     *
     * @param string $apiKey
     *   The public API key for the account to connect to Searchmetrics with.
     * @param string $apiSecret
     *   The secret API key for the account to connect to Searchmetrics with.
     * @param string $apiUrl
     *   The URL for the Searchmetrics endpoint (default: api.searchmetrics.com)
     */
    public function __construct(
        $apiKey,
        $apiSecret,
        $apiUrl = 'api.searchmetrics.com'
    ) {

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiUrl = $apiUrl;

    }

    /**
     * Getter for apiKey.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Getter for apiSecret.
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * Getter for apiUrl.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Getter for apiVersion.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }
}
