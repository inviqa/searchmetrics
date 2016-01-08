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

    /**
     * Get the full URL to the Searchmetrics API based on the coniguration. This is the URL that will be used for any
     * subsequent requests.
     *
     * At the time of writing, the Searchmetrics API does not support HTTPS. If you add HTTPS, then it will not
     * be corrected, so it may result in an error.
     *
     * @return string
     *   The full URL with a non-secure HTTP prepended if not provided.
     */
    public function getFullApiUrl()
    {

        $url = [];

        if (preg_match('/^https?:\/\//', $this->apiUrl) !== 1) {
            // We're only adding one slash here as the later implosion will add
            // the second.
            $url[] = 'http:/';
        }

        array_push(
            $url,
            $this->apiUrl,
            $this->apiVersion
        );

        return implode('/', $url);
    }

    /**
     * Get the entire URL including endpoint.
     *
     * @param string $endpoint
     *   The endpoint you wish to query (e.g.. ResearchKeywordsGetListRelatedKeywords)
     *
     * @return string
     *   The full URL to the endpoint you want to query.
     */
    public function getApiEndpointUrl($endpoint)
    {
        return $this->getFullApiUrl() . '/' . $endpoint . '.json';
    }
}
