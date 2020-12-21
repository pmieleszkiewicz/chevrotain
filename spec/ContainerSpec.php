<?php

namespace spec\PMieleszkiewicz\Chevrotain;

use PMieleszkiewicz\Chevrotain\Container;
use PhpSpec\ObjectBehavior;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_implements_psr_container_interface()
    {
        $this->shouldImplement('Psr\Container\ContainerInterface');
    }

    function it_does_not_have_unknown_classes()
    {
        $this->has('UnknownClass')->shouldReturn(false);
    }

    function it_returns_not_found_exception_if_class_cannot_be_found()
    {
        $this->shouldThrow('PMieleszkiewicz\Chevrotain\Exceptions\ContainerException')
            ->duringGet('UnknownClass');
    }

    function it_can_register_class_dependencies()
    {
        $factory = function (Container $container) {
            return new class {};
        };

        $this->shouldNotThrow()->duringSet('Foo\Bar', $factory);
    }

    function it_can_register_interface_dependencies()
    {
        $instance = new class implements DummyInterface {};
        $factory = function (Container $container) use ($instance) {
            return $instance;
        };

        $this->shouldNotThrow()->duringSet(DummyInterface::class, $factory);
        $this->get(DummyInterface::class)->shouldReturn($instance);
    }
}

interface DummyInterface {}
