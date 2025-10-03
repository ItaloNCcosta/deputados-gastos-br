<?php

declare(strict_types=1);

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleRequest extends Command
{
    protected $signature = 'make:module-request {module} {name}';
    protected $description = 'Create a request in a module';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $modulePath = base_path("modules/{$module}");
        $path = "{$modulePath}/Requests";

        if (!File::exists($modulePath)) {
            File::makeDirectory($modulePath, 0755, true);
        }

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $className = Str::studly($name);
        if (!Str::endsWith($className, 'Request')) {
            $className .= 'Request';
        }

        $fileName = "{$className}.php";
        $filePath = "{$path}/{$fileName}";

        if (File::exists($filePath)) {
            $this->error("Request {$className} already exists in module {$module}!");
            return;
        }

        $namespace = "Modules\\{$module}\\Requests";

        $stub = $this->getStub();
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{class}}', $className, $stub);

        File::put($filePath, $stub);

        $this->info("Request {$className} created successfully in module {$module}");
    }

    protected function getStub(): string
    {
        return File::get(__DIR__ . '/Stubs/request.stub');
    }
}
