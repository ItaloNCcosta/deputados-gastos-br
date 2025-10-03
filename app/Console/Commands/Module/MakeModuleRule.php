<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleRule extends Command
{
    protected $signature = 'make:module-rule {module} {name}';
    protected $description = 'Create a rule in a module';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $modulePath = base_path("modules/{$module}");
        $path = "{$modulePath}/Rules";

        if (!File::exists($modulePath)) {
            File::makeDirectory($modulePath, 0755, true);
        }

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $className = Str::studly($name);
        if (!Str::endsWith($className, 'Rule')) {
            $className .= 'Rule';
        }

        $fileName = "{$className}.php";
        $filePath = "{$path}/{$fileName}";

        if (File::exists($filePath)) {
            $this->error("Rule {$className} already exists in module {$module}!");
            return;
        }

        $namespace = "Modules\\{$module}\\Rules";

        $stub = $this->getStub();
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{class}}', $className, $stub);

        File::put($filePath, $stub);

        $this->info("Rule {$className} created successfully in module {$module}");
    }

    protected function getStub(): string
    {
        return File::get(__DIR__ . '/Stubs/rule.stub');
    }
}
