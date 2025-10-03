<?php

declare(strict_types=1);

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeModuleModel extends Command
{
    protected $signature = 'make:module-model {module} {name}
                            {--m : Create a migration like the default make:model}
                            {--table= : Table name (defaults to plural snake of the model)}';

    protected $description = 'Create a new Eloquent model class inside a module (optionally with a migration)';

    public function handle(): int
    {
        $module    = (string) $this->argument('module');
        $name      = (string) $this->argument('name');
        $className = Str::studly($name);

        $modulePath = base_path("modules/{$module}");
        $path       = "{$modulePath}/Models";

        if (! File::exists($modulePath)) {
            File::makeDirectory($modulePath, 0755, true);
        }

        if (! File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $fileName = "{$className}.php";
        $filePath = "{$path}/{$fileName}";

        if (File::exists($filePath)) {
            $this->error("Model {$className} already exists in module {$module}!");
            return self::FAILURE;
        }

        $namespace = "Modules\\{$module}\\Models";

        $stub = $this->getStub();
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{class}}', $className, $stub);

        File::put($filePath, $stub);
        $this->info("Model {$className} created successfully in module {$module}");

        if ($this->option('m')) {
            $table = (string) ($this->option('table') ?: Str::snake(Str::pluralStudly($className)));
            $migrationName = "create_{$table}_table";

            Artisan::call('make:migration', ['name' => $migrationName, '--create' => $table]);
            $this->output->write(Artisan::output());
        }

        return self::SUCCESS;
    }

    protected function getStub(): string
    {
        return File::get(__DIR__ . '/Stubs/model.stub');
    }
}
