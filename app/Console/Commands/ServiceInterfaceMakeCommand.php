<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ServiceInterfaceMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:serviceinterface {name}';

    protected $description = 'Create a new Service Interface class';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/serviceinterface.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\\Http\\Services';
    }
}