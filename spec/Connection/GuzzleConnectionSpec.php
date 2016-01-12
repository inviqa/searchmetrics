<?php

namespace spec\Searchmetrics\Connection;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\Connection;

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

    function it_should_implement_a_base_connection_interface()
    {
        $this->shouldImplement(Connection::class);
    }

    function it_returns_a_guzzle_client_instance()
    {
        $this->getClient()->shouldReturnAnInstanceOf(ClientInterface::class);
    }
}
