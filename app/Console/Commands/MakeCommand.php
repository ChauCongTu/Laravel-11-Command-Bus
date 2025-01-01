<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:command-bus
                            {name : The name of the file to create (e.g., Category/CreateCategory)}
                            {--type=command : The template to use (command, handler)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new file from a predefined template';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $template = $this->option('type');

        // Split the name into parts
        $parts = explode('/', $name);

        // Define the namespace based on the parts except the last one (file name/class name)
        $namespace = $template == 'command' ? 'App\\Commands' : 'App\\Handlers';
        $namespace .= '\\' . implode('\\', array_slice($parts, 0, -1));
        $route = $template == 'command' ? '/Commands/' : '/Handlers/';
        // Define the template paths
        $templatePath = base_path("stubs/{$template}.stub");

        $outputPath = app_path($route . implode('/', $parts) . '.php');

        // Check if the template file exists
        if (!File::exists($templatePath)) {
            $this->error("Template '{$template}' not found.");
            return Command::FAILURE;
        }

        // Get the template content
        $content = File::get($templatePath);

        // Replace placeholders in the template
        $content = str_replace('{{namespace}}', $namespace, $content);
        $content = str_replace('{{class}}', end($parts), $content);

        // Ensure the output directory exists
        File::ensureDirectoryExists(dirname($outputPath));

        // Write the content to the output file
        File::put($outputPath, $content);

        $this->info("File '{$name}.php' has been created at '{$outputPath}'.");
        return Command::SUCCESS;
    }
}
