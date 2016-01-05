<?php

namespace spec\Searchmetrics\Config;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionConfigSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('APIKEY', 'APISECRET', 'APIURL');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Config\ConnectionConfig');
    }

    function it_holds_the_api_key()
    {

        $this->getApiKey()->shouldReturn('APIKEY');

    }

    function it_holds_the_api_secret_key()
    {

        $this->getApiSecret()->shouldReturn('APISECRET');

    }

    function it_holds_the_api_version()
    {

        $this->getApiVersion()->shouldReturn('v3');

    }

    function it_holds_the_api_url()
    {

        $this->getApiUrl()->shouldReturn('APIURL');

    }

    function it_sets_a_default_api_url_if_one_isnt_provided()
    {

        $this->beConstructedWith('KEY', 'SECRET');
        $this->getApiUrl()->shouldReturn('api.searchmetrics.com');

    }
}
