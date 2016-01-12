<?php

namespace spec\Searchmetrics\Factory\Api;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Searchmetrics\Api\Admin\Status;
use Searchmetrics\Config\ConnectionConfig;
use Searchmetrics\Connection\Connection;
use Searchmetrics\Factory\Api\ApiFactory;
use Searchmetrics\Factory\Api\EndpointClassDoesNotExistException;

class AdminApiFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Factory\Api\AdminApiFactory');
    }

    function it_should_implement_the_apifactory_interface()
    {
        $this->shouldImplement(ApiFactory::class);
    }

    function it_should_return_an_admin_status_endpoint_class_when_status_is_provided(Connection $connection, ClientInterface $client)
    {
        $config = new ConnectionConfig('apiKey', 'apiConfig');
        $this::create($config, 'Status')->shouldReturnAnInstanceOf(Status::class);
    }

    function it_should_throw_an_endpointclassdoesnotexist_exception_if_class_does_not_exist()
    {
        $exception = new EndpointClassDoesNotExistException('Searchmetrics\\Api\\Admin\\GreenGoblin does not exist.');
        $config = new ConnectionConfig('apiKey', 'apiConfig');

        $this->beConstructedThrough('create', [$config, 'GreenGoblin']);
        $this->shouldThrow($exception)->duringInstantiation();
    }
}
