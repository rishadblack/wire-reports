<?php

namespace Rishadblack\WireReports\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeWireReports extends Command
{
    protected $signature = 'make:wire-reports {name : The name of the report component}';

    protected $description = 'Create a new Livewire report component with views';

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
            $folderName = implode('/', array_map('ucfirst', $nameParts)); // Class folder name
            $viewFolderName = implode('/', array_map('Str::kebab', $nameParts)); // View folder name in kebab case
        }

        $this->createComponent($className, $folderName, $viewFolderName);
        $this->createViewFile($viewFolderName, $className);
        $this->info('Livewire report component created successfully.');
    }

    protected function createComponent($className, $folderName, $viewFolderName)
    {
        $path = base_path("app/Livewire/Reports/{$folderName}");
        $fileName = "{$className}.php";

        // Create the directory if it doesn't exist
        if (! $this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path, 0755, true);
        }

        // Create the component class file
        $this->filesystem->put($path.'/'.$fileName, $this->buildClass($className, $folderName, $viewFolderName));
    }

    protected function buildClass($className, $folderName, $viewFolderName)
    {
        $stub = $this->getStub('report-component.stub');
        $viewName = Str::kebab($className);
        $viewLocation = "livewire/reports/{$viewFolderName}/{$viewName}";
        return str_replace(
            ['DummyNamespace', 'DummyClass', 'DummyViewLocation'],
            ['App\\Livewire\\Reports\\' . $folderName, $className, $viewLocation],
            $stub
        );
    }

    protected function createViewFile($viewFolderName, $className)
    {
        $viewPath = resource_path("views/livewire/reports/{$viewFolderName}/");
        $viewName = Str::kebab($className);

        if (! $this->filesystem->isDirectory($viewPath)) {
            $this->filesystem->makeDirectory($viewPath, 0755, true);
        }

        $stub = $this->getStub('report-component-view.stub');
        $this->filesystem->put($viewPath . $viewName . '.blade.php', $this->populateViewStub($stub, $className));
    }

    protected function populateViewStub($stub, $className)
    {
        return str_replace(
            ['DummyClass'],
            [Str::kebab($className)],
            $stub
        );
    }

    protected function getStub($stubName)
    {
        $stubPath = base_path("stubs/{$stubName}");

        if ($this->filesystem->exists($stubPath)) {
            return $this->filesystem->get($stubPath);
        }

        // Fallback to the package stub if the file does not exist
        return $this->filesystem->get(__DIR__."/../../../stubs/{$stubName}");
    }
}
