<?php

declare(strict_types=1);

namespace PMieleszkiewicz\Chevrotain\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
    protected $message = 'Binding not found';
}
