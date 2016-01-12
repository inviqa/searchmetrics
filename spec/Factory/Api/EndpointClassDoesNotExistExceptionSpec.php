<?php

namespace spec\Searchmetrics\Factory\Api;

use PhpSpec\ObjectBehavior;
use RuntimeException;

class EndpointClassDoesNotExistExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Factory\Api\EndpointClassDoesNotExistException');
    }

    function it_should_extend_runtimeexception()
    {
        $this->shouldHaveType(RuntimeException::class);
    }
}
