<?php

namespace spec\PMieleszkiewicz\Chevrotain\Exceptions;

use PMieleszkiewicz\Chevrotain\Exceptions\ContainerException;
use PhpSpec\ObjectBehavior;

class ContainerExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainerException::class);
    }

    function it_implements_psr_container_interface()
    {
        $this->shouldImplement('Psr\Container\ContainerExceptionInterface');
    }
    function it_implements_throwable()
    {
        $this->shouldImplement('Throwable');
    }
}
