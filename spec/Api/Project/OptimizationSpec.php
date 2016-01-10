<?php namespace spec\Searchmetrics\Api\Project;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Searchmetrics\Connection\GuzzleConnection;

class OptimizationSpec extends ObjectBehavior
{

    function let(GuzzleConnection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Api\Project\Optimization');
    }

    function it_should_extend_apiendpoint()
    {
        $this->shouldHaveType('Searchmetrics\Api\Apiendpoint');
    }

    function if_should_be_able_to_hit_the_project_optimization_post_value_content_request_endpoint(GuzzleConnection $connection)
    {

        $expectedArgs = [
            'keyword' => 'foo',
            'project_id' => 1,
            'se_id' => 2,
            'additional_keywords' => 'bar,baz,qux',
            'name' => 'title',
            'text' => '<h1 class="title">My title</h1>',
        ];

        $connection->makePostRequest('ProjectOptimizationGetListContentStatus', $expectedArgs)
            ->shouldBeCalled()
            ->willReturn([]);

        $this->getListProjects('foo', 1, 2, 'bar,baz,qux', 'title', '<h1 class="title">My title</h1>')->shouldBeArray();

    }

    function if_should_be_able_to_hit_the_project_optimization_get_list_content_status_endpoint(GuzzleConnection $connection)
    {

        $expectedArgs = [
            'crawl_id' => 1,
            'project_id' => 2,
        ];

        $connection->makeGetRequest('ProjectOptimizationGetListContentStatus', $expectedArgs)
            ->shouldBeCalled()
            ->willReturn([]);

        $this->getListProjects(1, 2)->shouldBeArray();

    }

    function if_should_be_able_to_hit_the_project_optimization_get_list_content_detail_endpoint(GuzzleConnection $connection)
    {

        $expectedArgs = [
            'crawl_id' => '1',
            'project_id' => '2',
            'limit' => '10',
            'sort' => '-must-have',
            'type' => 'proof',
            'show' => 'keywords',
        ];

        $connection->makeGetRequest('ProjectOptimizationGetListContentDetail', $expectedArgs)
            ->shouldBeCalled()
            ->willReturn([]);

        $this->getListProjects(1, 2, 10, '-must-have', 'proof', 'keywords')->shouldBeArray();

    }
}
