<?php namespace Searchmetrics\Connection;

use CommerceGuys\Guzzle\Oauth2\GrantType\ClientCredentials;
use CommerceGuys\Guzzle\Oauth2\GrantType\GrantTypeInterface;
use CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Searchmetrics\Config\ConnectionConfig;
use Teapot\HttpException;
use Teapot\StatusCode;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class GuzzleConnection.
 *
 * @package Searchmetrics\Connection
 */
class GuzzleConnection implements Connection
{

    /**
     * @var ConnectionConfig
     */
    protected $config;

    /**
     * @var Client
     */
    protected $authClient;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * GuzzleConnection constructor.
     *
     * @param \Searchmetrics\Config\ConnectionConfig $config
     */
    public function __construct(ConnectionConfig $config)
    {

        $this->config = $config;
        $this->httpClient = $this->createClient();

    }

    /**
     * {inheritDoc}
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->httpClient;
    }

    /**
     * Create a Guzzle client complete with Oauth2 subscriber to the Searchmetrics API.
     *
     * @return \GuzzleHttp\Client
     */
    private function createClient()
    {

        $authClient = $this->getAuthClient();
        $grantType = $this->getGrantType($authClient);
        $oauth2 = $this->getOauth2Subscriber($grantType);

        return new Client([
            'defaults' => [
                'auth' => 'oauth2',
                'subscribers' => [
                    $oauth2
                ],
            ],
        ]);

    }

    /**
     * Get the OAuth2 subscriber based on our credentials.
     *
     * @param GrantTypeInterface $grantType
     *   The grant type as returned by getGrantType().
     *
     * @return \CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber
     *   An OAuth 2 subscriber for use in client connections.
     */
    private function getOauth2Subscriber(GrantTypeInterface $grantType)
    {
        return new Oauth2Subscriber($grantType);
    }

    /**
     * Get the client object for getting the security token.
     *
     * @return \GuzzleHttp\Client
     *   A Guzzle\Client instance tied to the API URL.
     */
    private function getAuthClient()
    {

        // Authorization client - this is used to request OAuth access tokens.
        $authClient = new Client([
            // URL for access_token request.
            'base_url' => $this->config->getFullApiUrl(),
        ]);

        return $authClient;
    }

    /**
     * Get the Credentials for making any further connections.
     *
     * @param ClientInterface $auth_client
     *   The initial, unauthenticated Guzzle Auth Client.
     *
     * @return \CommerceGuys\Guzzle\Oauth2\GrantType\ClientCredentials
     *   A grant type containing client credentials.
     */
    private function getGrantType(ClientInterface $authClient)
    {

        $authConfig = [
            "client_id" => $this->config->getApiKey(),
            "client_secret" => $this->config->getApiSecret(),
            "token_url" => $this->config->getApiVersion() . '/token',
        ];

        return new ClientCredentials($authClient, $authConfig);

    }

    /**
     * {inheritDoc}
     */
    public function makePostRequest($endpoint, $body = [])
    {

        $request = $this->httpClient->createRequest(
            'post',
            $this->config->getApiEndpointUrl($endpoint),
            [
                'body' => $body,
            ]
        );

        return $this->makeRequest($request);

    }

    /**
     * {inheritDoc}
     */
    public function makeGetRequest($endpoint, $queryParams = [])
    {

        $request = $this->httpClient->createRequest(
            'get',
            $this->config->getApiEndpointUrl($endpoint),
            [
                'query' => $queryParams,
            ]
        );

        return $this->makeRequest($request);

    }

    /**
     * A lower level way to submit a request to the Searchmetrics API.
     *
     * @param RequestInterface $request
     *    A Guzzle request instance.
     *
     * @see SearchmetricsApiBase::makeGetRequest()
     * @see SearchmetricsApiBase::makePostRequest()
     *
     * @return array
     *   The JSON response from the Searchmetrics API, or an empty array if no
     *   response was given or if the status code was incorrect.
     */
    private function makeRequest(RequestInterface $request)
    {

        $response = $this->httpClient->send($request);

        $this->checkStatusCode($response);

        $json = $response->json();

        return $json;

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
    protected function checkStatusCode(ResponseInterface $response)
    {

        $statusCode = $response->getStatusCode();

        if ($statusCode !== StatusCode::OK) {
            throw new HttpException(
                $response->getBody(),
                $statusCode
            );

        }

        return $statusCode;

    }
}
