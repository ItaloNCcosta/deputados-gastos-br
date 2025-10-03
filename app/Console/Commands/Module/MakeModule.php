<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module {module} {name} {--all} {--model} {--controller} {--request} {--service} {--enum} {--rule} {--policy}';
    protected $description = 'Create module files';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $commands = [];

        if ($this->option('all')) {
            $commands = [
                'make:module-model',
                'make:module-controller',
                'make:module-request',
                'make:module-service',
                'make:module-enum',
                'make:module-rule',
                'make:module-policy'
            ];
        } else {
            if ($this->option('model')) $commands[] = 'make:module-model';
            if ($this->option('controller')) $commands[] = 'make:module-controller';
            if ($this->option('request')) $commands[] = 'make:module-request';
            if ($this->option('service')) $commands[] = 'make:module-service';
            if ($this->option('enum')) $commands[] = 'make:module-enum';
            if ($this->option('rule')) $commands[] = 'make:module-rule';
            if ($this->option('policy')) $commands[] = 'make:module-policy';
        }

        if (empty($commands)) {
            $this->error('Please specify at least one type or use --all');
            $this->info('Available options: --model, --controller, --request, --service, --enum, --rule, --policy, --all');
            return;
        }

        $this->info("Creating module files for {$module}...");

        foreach ($commands as $command) {
            $this->call($command, [
                'module' => $module,
                'name' => $name
            ]);
        }

        $this->info("Module {$module} created successfully!");
    }
}
