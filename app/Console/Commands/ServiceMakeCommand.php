<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\Traits\ServiceProviderInjector;
use Illuminate\Support\Str;

class ServiceMakeCommand extends GeneratorCommand
{
    use ServiceProviderInjector;

    protected $signature = 'make:service {name}';
    protected $description = 'Create a new Service class';

    public function handle()
    {
        $codeToAdd = "\n\t\t\$this->app->bind(\n" .
            "\t\t\t\\App\\Http\\Services\\" . str_replace('/', '\\', $this->argument('name')) . "::class,\n" .
            "\t\t\t\\App\\Http\\Services\\Impl\\" . str_replace('/', '\\', $this->argument('name')) . "Impl::class\n" .
            "\t\t);\n";

        $appServiceProviderFile = app_path('Providers/AppServiceProvider.php');

        $this->injectCodeToRegisterMethod($appServiceProviderFile, $codeToAdd);

        Artisan::call('make:serviceinterface', [
            'name' => $this->argument('name')
        ]);
        return parent::handle();
    }

    protected function getStub()
    {
        return __DIR__ . '/Stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\\Http\\Services\\Impl';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Impl'.'.php';
    }
}