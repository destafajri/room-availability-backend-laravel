<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class RepositoryInterfaceMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:repositoryinterface {name}';

    protected $description = 'Create a new Repository Interface class';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/repositoryinterface.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\\Repositories';
    }
}