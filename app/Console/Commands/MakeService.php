<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     * 
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for generator.
     * 
     * @return string
     */
    protected function getStub()
    {
        return app_path().'/Console/Commands/Stubs/make-service.stub';
    }

    /**
     * Get the default namespace for the class.
     * 
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }
}
