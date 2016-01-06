<?php namespace Searchmetrics\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Searchmetrics\Config\ConnectionConfig;

/**
 * Class GuzzleConnection.
 *
 * @package Searchmetrics\Connection
 */
class GuzzleConnection implements ConnectionFactory
{

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    private $handlerStack;

    /**
     * @var \Searchmetrics\Config\ConnectionConfig
     */
    protected $config;

    /**
     * GuzzleConnection constructor.
     *
     * @param $config
     */
    public function __construct(ConnectionConfig $config)
    {
        $this->config = $config;
        $this->handlerStack = HandlerStack::create();
    }


    /**
     * @inheritdoc
     */
    public function getClient()
    {
        // Add the Oauth stack onto the client.
        $oauthMiddleware = $this->getOauthMiddlewareStack();

        $this->handlerStack->push($oauthMiddleware);

        return new Client([
            'base_uri' => $this->config->getApiUrl(),
            'handler' => $this->handlerStack,
            'auth' => 'oauth'
        ]);
    }

    /**
     * Retrieve the Oauth middleware to push onto the handler stack.
     *
     * @return \GuzzleHttp\Subscriber\Oauth\Oauth1
     */
    private function getOauthMiddlewareStack()
    {

        return new Oauth1([
            'consumer_key' => $this->config->getApiKey(),
            'consumer_secret' => $this->config->getApiSecret(),
        ]);

    }
}
