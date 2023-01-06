<?php

namespace Funkywaddle\LaravelServices\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:serviceprovider')]
class ServiceProviderMakeCommand extends GeneratorCommand {

    protected $name = 'make:serviceprovider';
    protected $type = 'ServiceProvider';

    protected $description = 'Create a new ServiceProvider';

    public function handle() {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        $this->makeDirectory($this->getPath($this->getNameInput()));
    }

    protected function getStub() {
        return $this->resolveStubPath('/stubs/serviceprovider.stub');
    }

    protected function resolveStubPath($stub) {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace.'\\ServiceProviders';
    }

    protected function buildClass($name) {
        $replace = [];

        $modelClass = $this->parseModel($this->getNameInput());
        $replace['{{ model }}'] = class_basename($modelClass);
        $replace['{{ service }}'] = class_basename($modelClass).'Service';

        $providerName = $name.'ServiceProvider';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($providerName)
        );
    }

    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    protected function getPath($name) {
        return parent::getPath($name.'ServiceProvider');
    }

    protected function getOptions() {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the serviceprovider already exists']
        ];
    }
}
