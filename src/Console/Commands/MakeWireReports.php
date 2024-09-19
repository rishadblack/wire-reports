<?php

namespace Rishadblack\WireReports\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use function Laravel\Prompts\text;

/**
 * Class MakeWireReports
 */
class MakeWireReports extends Command implements PromptsForMissingInput
{
    protected ComponentParser $parser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:wire-reports
        {name : The name of the report component}
        {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Livewire report component with views.';

    /**
     * Generate the report component
     */
    public function handle(): void
    {
        $this->parser = new ComponentParser(
            config('livewire.class_namespace'),
            config('livewire.view_path'),
            'Reports.'.$this->argument('name')
        );

        $name = $this->parser->className();

        if (File::exists($this->parser->classPath())) {
            if (!$this->option('force')) {
                $this->line("<fg=red;options=bold>Class already exists:</> {$this->parser->relativeClassPath()}");

                return;
            }
        }

        $this->createClass();
        $this->createViews();

        $this->info('Livewire report component created successfully: '.$name);
    }

    protected function createClass(): void
    {
        $this->ensureDirectoryExists($this->parser->classPath());
        File::put($this->parser->classPath(), $this->classContents());
    }

    protected function createViews(): void
    {
        $this->ensureDirectoryExists($this->parser->viewPath());

        $viewStub = $this->getStub('report-component-view.stub');
        File::put($this->parser->viewPath(), $this->populateViewStub($viewStub, $this->parser->viewName()));
    }

    protected function ensureDirectoryExists($path): void
    {
        if (! File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0777, true, true);
        }
    }

    public function classContents(): string
    {
        $stub = $this->getStub('report-component.stub');
        return str_replace(
            ['DummyNamespace', 'DummyClass', 'DummyViewLocation'],
            [$this->parser->classNamespace(), $this->parser->className(), $this->parser->viewName()],
            $stub
        );
    }

    protected function populateViewStub($stub, $viewName): string
    {
        return str_replace(
            ['DummyViewName'],
            [$viewName],
            $stub
        );
    }

    protected function getStub($stubName): string
    {
        $stubPath = base_path("stubs/{$stubName}");

        if (File::exists($stubPath)) {
            return File::get($stubPath);
        }

        // Fallback to the package stub if the file does not exist
        return File::get(__DIR__."/../../../stubs/{$stubName}");
    }

    protected function promptForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        if ($this->didReceiveOptions($input)) {
            return;
        }

        if (trim($this->argument('name')) === '') {
            $name = text('What is the name of the report component?', 'TestReport');

            if ($name) {
                $input->setArgument('name', $name);
            }
        }
    }
}
