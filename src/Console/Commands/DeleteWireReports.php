<?php

namespace Rishadblack\WireReports\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class DeleteWireReports extends Command
{
    protected $signature = 'delete:wire-reports {name : The name of the report component}';

    protected $description = 'Delete a Livewire report component and its views';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $nameParts = explode('.', $name);

        if (count($nameParts) === 1) {
            $className = Str::studly($nameParts[0]);
            $folderName = '';
            $viewFolderName = '';
        } else {
            $className = Str::studly(array_pop($nameParts));
            $folderName = implode('/', array_map('ucfirst', $nameParts));
            $viewFolderName = implode('/', array_map('Str::kebab', $nameParts));
        }

        $this->deleteComponent($className, $folderName);
        $this->deleteViewFiles($viewFolderName, $className);
        $this->info('Livewire report component and views deleted successfully.');
    }

    protected function deleteComponent($className, $folderName)
    {
        $path = base_path("app/Livewire/Reports/{$folderName}/{$className}.php");

        if ($this->filesystem->exists($path)) {
            $this->filesystem->delete($path);
            $this->info("Deleted component class: {$path}");

            // Optionally, remove the directory if it's empty
            $this->removeEmptyDirectories(base_path("app/Livewire/Reports/{$folderName}"));
        } else {
            $this->error("Component class not found: {$path}");
        }
    }

    protected function deleteViewFiles($viewFolderName, $className)
    {
        $viewPath = resource_path("views/livewire/reports/{$viewFolderName}/");
        $viewFilePath = $viewPath . Str::kebab($className) . '.blade.php';

        if ($this->filesystem->exists($viewFilePath)) {
            $this->filesystem->delete($viewFilePath);
            $this->info("Deleted view file: {$viewFilePath}");

            // Optionally, remove the directory if it's empty
            $this->removeEmptyDirectories($viewPath);
        } else {
            $this->error("View file not found: {$viewFilePath}");
        }
    }

    protected function removeEmptyDirectories($path)
    {
        if ($this->filesystem->isDirectory($path) && empty($this->filesystem->files($path)) && empty($this->filesystem->directories($path))) {
            $this->filesystem->deleteDirectory($path);
            $this->info("Deleted empty directory: {$path}");

            // Recursively remove parent directories if they are empty
            $parentPath = dirname($path);
            if ($parentPath !== base_path('app/Livewire/Reports') && $parentPath !== resource_path('views/livewire/reports')) {
                $this->removeEmptyDirectories($parentPath);
            }
        }
    }
}
