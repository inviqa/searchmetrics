<?php

namespace spec\Searchmetrics\Connection;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\ConnectionFactory;

class GuzzleConnectionSpec extends ObjectBehavior
{
    function let(ConnectionConfig $config)
    {
        $this->beConstructedWith($config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Connection\GuzzleConnection');
    }

    function it_returns_a_guzzle_client_instance()
    {
        $this->getClient()->shouldReturnAnInstanceOf(GuzzleClientInterface::class);
    }

    function it_implements_connectionfactory()
    {
        $this->shouldImplement(ConnectionFactory::class);
    }
}
