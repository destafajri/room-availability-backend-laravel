<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\Traits\ServiceProviderInjector;
use Illuminate\Support\Str;

class RepositoryMakeCommand extends GeneratorCommand
{
    use ServiceProviderInjector;

    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new Repository class';

    public function handle()
    {
        $codeToAdd = "\n\t\t\$this->app->bind(\n" .
            "\t\t\t\\App\\Repositories\\" . str_replace('/', '\\', $this->argument('name')) . "::class,\n" .
            "\t\t\t\\App\\Repositories\\Impl\\" . str_replace('/', '\\', $this->argument('name')) . "Impl::class\n" .
            "\t\t);\n";

        $appServiceProviderFile = app_path('Providers/AppServiceProvider.php');

        $this->injectCodeToRegisterMethod($appServiceProviderFile, $codeToAdd);

        Artisan::call('make:repositoryinterface', [
            'name' => $this->argument('name')
        ]);
        return parent::handle();
    }

    protected function getStub()
    {
        return __DIR__ . '/Stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\\Repositories\\Impl';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Impl'.'.php';
    }
}