# WireReports

**WireReports** is a Laravel package designed to facilitate the creation of dynamic Livewire report components. It includes features for exporting reports to PDF and Excel formats and offers an easy way to generate and manage report components with custom views and data builders.

## Features

- Create Livewire report components with a single command
- Export reports to PDF using SnappyPdf or mPDF
- Export reports to Excel using Maatwebsite\Excel
- Customizable views for reports
- Supports hierarchical folder structure for components and views

## Installation

To install the package, you can use Composer:

```bash
composer require rishadblack/wire-reports
```

## Publishing Stubs

To publish the package stubs for customization, run:

```bash

php artisan vendor:publish --provider="Rishadblack\WireReports\WireReportsServiceProvider" --tag="wire-reports-stubs"
```

## Usage

### Creating a Report Component

You can create a new Livewire report component using the Artisan command:

```bash

php artisan make:wire-reports {name}
```

The {name} argument should be the name of the component. You can include subfolders by using dot notation (e.g., Demo.Test).
Example

To create a report component named TestReport in the Demo folder:

```bash

php artisan make:wire-reports Demo.Test
```

This will create:

    A Livewire component file at app/Livewire/Reports/Demo/TestReport.php
    A Blade view file at resources/views/livewire/reports/demo/test-report.blade.php

### Deleting a Report Component

You can delete an existing Livewire report component using the Artisan command:

```bash

php artisan delete:wire-reports {name}
```

The {name} argument should be the name of the component to delete. It will remove both the component class and the associated view file.
Example

To delete the TestReport component from the Demo folder:

```bash

php artisan delete:wire-reports Demo.Test
```

This will remove:

    The Livewire component file at app/Livewire/Reports/Demo/TestReport.php
    The Blade view file at resources/views/livewire/reports/demo/test-report.blade.php

### Customizing the Report Component

Edit the generated component file to define your report's data builder and view:

```php

<?php

namespace App\Livewire\Reports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rishadblack\WireReports\ReportComponent;

class TestReport extends ReportComponent
{
     public function configure(): void
    {
        $this->setFileName('purchase-report');
    }

    public function builder(): Builder
    {
        return Country::query();
    }

    public function columns(): array
    {
        return [
            Column::make('Serial', 'id')->sortable()->hide(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Phonecode', 'phonecode')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::make('Search Name', 'name')->filter(function (Builder $query, string $value) {
                $query->where('name', 'like', "%{$value}%");
            })->placeholder('Search Country Name'),
            Filter::make('Search Supplier', 'phonecode')->searchComponent('contact::search.customers')->filter(function (Builder $query, string $value) {
                $query->where('phonecode', 'like', "%{$value}%");
            })->placeholder('Search Country Name'),
        ];
    }
}
```

Edit the Blade view file to customize the report layout:

```php

<div>
    <x-wire-reports::table>
        <x-slot:header>
            <x-wire-reports::table.tr>
                <x-wire-reports::table.td colspan="3" style="text-align: center; font-weight: bold;">
                    <h3>Report</h3>
                </x-wire-reports::table.td>
            </x-wire-reports::table.tr>
        </x-slot:header>
        <x-slot:thead>
            <x-wire-reports::table.tr>
                @foreach ($columns as $column)
                    <x-wire-reports::table.th :name="$column['name']" :$column>
                        {{ $column['title'] }}
                    </x-wire-reports::table.th>
                @endforeach
            </x-wire-reports::table.tr>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach ($datas as $data)
                <x-wire-reports::table.tr>
                    @foreach ($columns as $column)
                        <x-wire-reports::table.td :name="$column['name']" :$column>
                            {{ $data->{$column['name']} }}
                        </x-wire-reports::table.td>
                    @endforeach
                </x-wire-reports::table.tr>
            @endforeach
        </x-slot:tbody>
        <x-slot:tfoot>
            <x-wire-reports::table.tr>
                <x-wire-reports::table.td colspan="2">
                    Total Amount
                </x-wire-reports::table.td>
                <x-wire-reports::table.td>
                    {{ $datas->sum('id') }}
                </x-wire-reports::table.td>
            </x-wire-reports::table.tr>
        </x-slot:tfoot>
    </x-wire-reports::table>
</div>

```

## License

This package is licensed under the MIT License. See LICENSE for more details.

## Contributing

Contributions are welcome! Please refer to CONTRIBUTING.md for guidelines.

## Support

For issues or feature requests, please open an issue on the GitHub repository.
