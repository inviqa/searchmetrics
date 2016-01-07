<?php

namespace spec\Searchmetrics\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Searchmetrics\Api\ApiBase;
use Searchmetrics\Config\ConnectionConfig;
use Teapot\HttpException;
use Teapot\StatusCode;

class GuzzleApiSpec extends ObjectBehavior
{
    function let(ConnectionConfig $config, ClientInterface $client)
    {
        $this->beConstructedWith($config, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Api\GuzzleApi');
    }

    function it_implements_apibase()
    {
        $this->shouldImplement(ApiBase::class);
    }

    function it_creates_a_guzzle_request_for_post_requests(ClientInterface $client)
    {

        $mockResponse = new Response(StatusCode::OK);

        $client->request("post", "/foo.json", ["body" => []])->shouldBeCalled()->willReturn($mockResponse);
        $this->makePostRequest('foo', []);

    }

    function it_creates_a_guzzle_request_for_get_requests(ClientInterface $client)
    {
        $mockResponse = new Response(StatusCode::OK);

        $client->request("get", "/foo.json", ["query" => []])->shouldBeCalled()->willReturn($mockResponse);
        $this->makeGetRequest('foo', []);

    }

    function it_should_throw_an_exception_if_the_response_during_a_post_is_not_200(ClientInterface $client)
    {

        $mockResponse = new Response(StatusCode::BAD_GATEWAY);

        $client->request("post", "/foo.json", ["body" => []])->shouldBeCalled()->willReturn($mockResponse);
        $this->shouldThrow(HttpException::class)->during('makePostRequest', ['foo', []]);

    }

    function it_should_throw_an_exception_if_the_response_during_a_get_is_not_200(ClientInterface $client)
    {

        $mockResponse = new Response(StatusCode::FORBIDDEN);

        $client->request("get", "/foo.json", ["query" => []])->shouldBeCalled()->willReturn($mockResponse);
        $this->shouldThrow(HttpException::class)->during('makeGetRequest', ['foo', []]);

    }
}
