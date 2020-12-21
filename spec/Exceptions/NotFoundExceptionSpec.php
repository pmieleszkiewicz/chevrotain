<?php

namespace spec\PMieleszkiewicz\Chevrotain\Exceptions;

use PMieleszkiewicz\Chevrotain\Exceptions\NotFoundException;
use PhpSpec\ObjectBehavior;

class NotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NotFoundException::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Psr\Container\NotFoundExceptionInterface');
    }

    function it_implements_throwable()
    {
        $this->shouldImplement('Throwable');
    }
}
