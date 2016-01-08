<?php

namespace spec\Searchmetrics\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\Mock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\ConnectionFactory;
use Teapot\HttpException;
use Teapot\StatusCode;
use GuzzleHttp\Ring\Client\MockHandler;

class GuzzleConnectionSpec extends ObjectBehavior
{
    function let(ConnectionConfig $config, ClientInterface $client)
    {
        $this->beConstructedWith($config, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Connection\GuzzleConnection');
    }

    function it_returns_a_guzzle_client_instance()
    {
        $this->getClient()->shouldReturnAnInstanceOf(ClientInterface::class);
    }
}
