<?php

namespace Provider;

use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;

class LoggerServiceProvider extends ServiceProvider
{
    private const CONFIG_NAME = 'rabbitmq-logger';

    public function register(): void
    {
        $this->app->bind(RabbitMQService::class, static function() {
            $config = config(self::CONFIG_NAME);

            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password'],
                $config['vhost'],
            );

            return new RabbitMQService($connection);
        });
    }
}
