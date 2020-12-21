<?php

declare(strict_types=1);

namespace PMieleszkiewicz\Chevrotain;

use ReflectionClass;
use ReflectionException;
use Psr\Container\ContainerInterface;
use PMieleszkiewicz\Chevrotain\Exceptions\ContainerException;
use PMieleszkiewicz\Chevrotain\Exceptions\NotFoundException;

class Container implements ContainerInterface
{
    private $bindings = [];

    /**
     * {@inheritDoc}
     */
    public function get($id): object
    {
        if (isset($this->bindings[$id])) {
            return $this->bindings[$id]($this);
        }

        try {
            $reflection = new ReflectionClass($id);
            $dependencies = $this->buildDependencies($reflection);

            return $reflection->newInstanceArgs($dependencies);
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function has($id): bool
    {
        try {
            $this->get($id);
        } catch (ContainerException $e) {
            return false;
        }
        return true;
    }

    public function set(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     * Build dependencies to autowire class
     *
     * @param ReflectionClass $reflection
     * @return array
     * @throws ContainerException|ReflectionException
     */
    private function buildDependencies(ReflectionClass $reflection): array
    {
        if (!$constructor = $reflection->getConstructor()) {
            return [];
        }
        $params = $constructor->getParameters();

        return array_map(function ($param) {
            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }

            if (!$type = $param->getType()) {
                throw new ContainerException('Constructor parameter has no type');
            }
            return $this->get($type->getName());
        }, $params);
    }
}
