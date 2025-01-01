<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class NewFeatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:feature {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $actions = [
            'GetList', 'Create', 'Get', 'Update', 'Delete',
        ];
        $model = $this->argument('model');

        Artisan::call('make:controller', ['name' => "{$model}Controller", '--api' => true]);
        Artisan::call('make:request', ['name' => "{$model}/Create{$model}Request"]);
        Artisan::call('make:request', ['name' => "{$model}/Filter{$model}Request"]);
        Artisan::call('make:request', ['name' => "{$model}/Update{$model}Request"]);
        Artisan::call('make:resource', ['name' => "{$model}/{$model}Resource"]);
        Artisan::call('make:resource', ['name' => "{$model}/Single{$model}Resource"]);

        foreach ($actions as $action) {
            Artisan::call('make:command-bus', [
                'name' => "{$model}/{$action}{$model}Command",
                '--type' => 'command',
            ]);
            Artisan::call('make:command-bus', [
                'name' => "{$model}/{$action}{$model}Handler",
                '--type' => 'handler',
            ]);
        }
    }
}
