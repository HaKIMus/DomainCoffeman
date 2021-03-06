<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 16.04.17
 * Time: 16:06
 */

namespace Coffeeman\Application;

interface CommandBusInterface
{
    public function registerHandler(string $command, CommandHandlerInterface $handler): void;
    public function handle($command): void;
}
