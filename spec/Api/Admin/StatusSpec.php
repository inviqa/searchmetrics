<?php

namespace spec\Searchmetrics\Api\Admin;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Searchmetrics\Connection\Connection;
use Searchmetrics\Connection\GuzzleConnection;

class StatusSpec extends ObjectBehavior
{

    function let(GuzzleConnection $connection)
    {
        $this->beConstructedWith($connection);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Api\Admin\Status');
    }

    function it_should_extend_apiendpoint()
    {
        $this->shouldHaveType('Searchmetrics\Api\Apiendpoint');
    }

    function it_should_be_able_to_hit_the_project_endpoint(Connection $connection)
    {

        $response = new Response(200);

        $connection->makeGetRequest('AdminStatusGetListProjects', Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->getListProjects()->shouldBeArray();

    }

    function it_should_be_able_to_hit_search_engines_endpoint(Connection $connection)
    {

        $response = new Response(200);

        $connection->makeGetRequest('AdminStatusGetListProjectSearchEngines', Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);


        $this->getListProjectSearchEngines(Argument::any())->shouldBeArray();

    }
}
