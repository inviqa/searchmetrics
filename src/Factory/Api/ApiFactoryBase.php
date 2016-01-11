<?php namespace Searchmetrics\Factory\Api;

use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\GuzzleConnection;

/**
 * Class AdminApiFactory.
 *
 * @package Searchmetrics\Factory\Api
 */
abstract class ApiFactoryBase implements ApiFactory
{

    /**
     * @var string
     */
    protected static $baseEndpoint = '';

    /**
     * {inheritDoc}
     */
    public static function create(ConnectionConfig $config, $endpointClass)
    {

        $connection = new GuzzleConnection($config);

        $className = static::$baseEndpoint . $endpointClass;

        if (!class_exists($className)) {
            throw new EndpointClassDoesNotExistException($className . ' does not exist.');
        }

        return new $className($connection);
    }
}
