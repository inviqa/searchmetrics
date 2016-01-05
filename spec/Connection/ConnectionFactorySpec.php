<?php

namespace spec\Searchmetrics\Connection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Connection\ConnectionFactory');
    }

    function it_returns_a_guzzle_connection()
    {


    }
}
