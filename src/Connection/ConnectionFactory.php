<?php namespace Searchmetrics\Connection;

/**
 * Class ConnectionFactory.
 *
 * Provides a fully authenticated API connection class.
 *
 * @package Searchmetrics\Connection
 */
interface ConnectionFactory
{

    /**
     * Get the connection instance to the established Searchmetrics session.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *   A PSR-7 compatible class instance that represents the connection to Searchmetrics.
     */
    public function getClient();
}
