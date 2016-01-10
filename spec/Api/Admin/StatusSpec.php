<?php

namespace spec\Searchmetrics\Api\Admin;

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

        $expectedArgs = [
            'limit' => 50,
            'offset' => 5
        ];

        $connection->makeGetRequest('AdminStatusGetListProjects', $expectedArgs)
            ->shouldBeCalled()
            ->willReturn([]);

        $this->getListProjects(50, 5)->shouldBeArray();

    }

    function it_should_be_able_to_hit_search_engines_endpoint(Connection $connection)
    {

        $expectedArgs = [
            'project_id' => 50,
        ];

        $connection->makeGetRequest('AdminStatusGetListProjectSearchEngines', $expectedArgs)
            ->shouldBeCalled()
            ->willReturn([]);


        $this->getListProjectSearchEngines(50)->shouldBeArray();

    }
}
