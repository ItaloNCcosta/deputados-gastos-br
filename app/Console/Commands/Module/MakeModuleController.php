<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-controller {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller in a module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $modulePath = base_path("modules/{$module}");
        $path = "{$modulePath}/Controllers";

        if (!File::exists($modulePath)) {
            File::makeDirectory($modulePath, 0755, true);
        }

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $className = Str::studly($name);
        if (!Str::endsWith($className, 'Controller')) {
            $className .= 'Controller';
        }

        $fileName = "{$className}.php";
        $filePath = "{$path}/{$fileName}";

        if (File::exists($filePath)) {
            $this->error("Controller {$className} already exists in module {$module}!");
            return;
        }

        $namespace = "Modules\\{$module}\\Controllers";

        $stub = $this->getStub();
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{class}}', $className, $stub);

        File::put($filePath, $stub);

        $this->info("Controller {$className} created successfully in module {$module}");
    }

    protected function getStub(): string
    {
        return File::get(__DIR__ . '/Stubs/controller.stub');
    }
}
