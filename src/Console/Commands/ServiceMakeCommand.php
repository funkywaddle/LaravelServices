<?php

namespace Funkywaddle\LaravelServices\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:service')]
class ServiceMakeCommand extends GeneratorCommand {
    use CreatesMatchingTest;

    protected $name = 'make:service';
    protected $type = 'Service';

    protected $description = 'Create a new Service and optional ServiceProvider';

    public function handle() {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        $this->makeDirectory($this->getPath($this->getNameInput()));

        if ($this->option('provider')) {
            $this->createProvider();
        }
    }

    protected function createProvider() {
        $this->call('make:serviceprovider',[
            'name'=> $this->getNameInput()
        ]);
    }

    protected function getStub() {
        return $this->resolveStubPath('/stubs/service.stub');
    }

    protected function resolveStubPath($stub) {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace.'\\Services';
    }

    protected function buildClass($name) {
        return parent::buildClass($name.'Service');
    }

    protected function getPath($name) {
        return parent::getPath($name.'Service');
    }

    protected function getOptions() {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['provider', null, InputOption::VALUE_NONE, 'Create the ServiceProvider'],
            ['test', null, InputOption::VALUE_NONE, 'Create the accompanying test for this Service']
        ];
    }
}
