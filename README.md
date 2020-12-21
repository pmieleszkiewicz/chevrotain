# Chevrotain
It's just a simple implementation of [PSR-11](https://www.php-fig.org/psr/psr-11/) compatibile dependency injection container with autowiring.

## Installation
```bash
composer require pmieleszkiewicz/chevrotain
```

## Usage
```php
// LoggerInterface.php
interface LoggerInterface
{
    public function log(string $message);
}

// EchoLogger.php
class EchoLogger implements LoggerInterface
{
    public function log(string $message)
    {
        echo $message;
    }
}

// UserService.php
class UserService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(string $message)
    {
        $this->logger->log(sprintf("[%s] %s", date('Y-m-d H:i:s'), $message));
    }
}
```

```php
<?php

declare(strict_types=1);

use App\Services\UserService;
use App\Loggers\EchoLogger;
use App\Loggers\LoggerInterface;
use PMieleszkiewicz\Chevrotain\Container;
use PMieleszkiewicz\Chevrotain\Exceptions\ContainerException;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$container->set(LoggerInterface::class, function (Container $container) {
    return $container->get(EchoLogger::class);
});
try {
    $service = $container->get(UserService::class);
    $service->log('It works!');
} catch (ContainerException $e) {
    // handle exception
}


// Output
[2020-12-21 01:00:04] It works!
```
Container uses autowiring, so there is no need to nest dependencies in `Container::set()` method - it can handle it using PHP reflection API.


## Testing
``` bash
composer test
```
