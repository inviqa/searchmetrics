<?php

namespace spec\Searchmetrics\Config;

use PhpSpec\ObjectBehavior;

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

    function it_should_get_the_full_api_url()
    {
        $this->beConstructedWith('KEY', 'SECRET');
        $this->getFullApiUrl()->shouldReturn('http://api.searchmetrics.com/v3');
    }

    function it_should_get_the_full_url_if_an_alternative_url_is_provided()
    {
        $this->beConstructedWith('KEY', 'SECRET', 'api.example.com');
        $this->getFullApiUrl()->shouldReturn('http://api.example.com/v3');
    }

    function it_should_not_add_the_http_prefix_if_it_already_exists()
    {
        $this->beConstructedWith('KEY', 'SECRET', 'http://api.example.com');
        $this->getFullApiUrl()->shouldReturn('http://api.example.com/v3');
    }

    function it_should_return_the_full_url_to_an_endpoint()
    {
        $this->beConstructedWith('KEY', 'SECRET', 'http://api.example.com');
        $this->getApiEndpointUrl('endpoint')->shouldReturn('http://api.example.com/v3/endpoint.json');
    }
}
