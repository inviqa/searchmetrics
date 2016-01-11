<?php namespace Searchmetrics\Factory\Api;

use Searchmetrics\Config\ConnectionConfig;

/**
 * Class ApiFactory.
 *
 * @package Searchmetrics\Factory
 */
interface ApiFactory
{

    /**
     * Create an API instance for a particular endpoint.
     *
     * @param ConnectionConfig $config
     *   A Searchmetrics configuration object.
     * @param string $endpointClass
     *   The name of the endpoint you want an instance of the API connector for. I.e. if an implementation of this
     *   interface is an AdminApiFactory, you may want to pass Status to get a Status endpoint connector.
     *
     * @return \Searchmetrics\Api\ApiEndpoint
     *   A fully authenticated API endpoint class.
     */
    public static function create(ConnectionConfig $config, $endpointClass);
}
