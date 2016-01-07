<?php

namespace spec\Searchmetrics\Api\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatusApiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Api\Admin\StatusApi');
    }
}
