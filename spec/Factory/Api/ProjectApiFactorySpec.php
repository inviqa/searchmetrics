<?php

namespace spec\Searchmetrics\Factory\Api;

use PhpSpec\ObjectBehavior;
use Searchmetrics\Api\Project\Optimization;
use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\Connection;
use Searchmetrics\Factory\Api\ApiFactory;
use Searchmetrics\Factory\Api\EndpointClassDoesNotExistException;

class ProjectApiFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Factory\Api\ProjectApiFactory');
    }

    function it_should_implement_the_apifactory_interface()
    {
        $this->shouldImplement(ApiFactory::class);
    }

    function it_should_return_a_project_optimisation_endpoint_class_when_status_is_provided(Connection $connection)
    {
        $config = new ConnectionConfig('apiKey', 'apiConfig');
        $this::create($config, 'Optimization')->shouldReturnAnInstanceOf(Optimization::class);
    }

    function it_should_throw_an_endpointclassdoesnotexist_exception_if_class_does_not_exist()
    {
        $exception = new EndpointClassDoesNotExistException('Searchmetrics\\Api\\Project\\Kingpin does not exist.');
        $config = new ConnectionConfig('apiKey', 'apiConfig');

        $this->beConstructedThrough('create', [$config, 'Kingpin']);
        $this->shouldThrow($exception)->duringInstantiation();
    }
}
