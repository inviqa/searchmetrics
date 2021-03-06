<?php namespace Searchmetrics\Api;

use Searchmetrics\Connection\Connection;

/**
 * Class ApiEndpoint.
 *
 * @package Api
 */
abstract class ApiEndpoint
{

    /**
     * @var \Searchmetrics\Connection\Connection
     */
    protected $connection;

    /**
     * ApiEndpoint constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
