<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 16.04.17
 * Time: 21:36
 */

namespace Coffeeman\Application;

final class SimpleCommandBus implements CommandBusInterface
{
    private $handlers = [];

    public function registerHandler(CommandInterface $command, CommandHandlerInterface $handler): void
    {
        $this->handlers[get_class($command)] = $handler;
    }

    public function handle(CommandInterface $command): void
    {
        $this->handlers[get_class($command)]->handle($command);
    }
}