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
    public $view = 'livewire.reports.test-report';

    public function builder(): Builder
    {
        return User::query();
    }
}
```

Edit the Blade view file to customize the report layout:

```php

<x-report.table>
    <x-slot:header>
        <!-- Header content -->
    </x-slot:header>
    <x-slot:subheader>
        <!-- Subheader content -->
    </x-slot:subheader>
    <x-slot:thead>
        <!-- Table headers -->
    </x-slot:thead>
    <x-slot:tbody>
        @foreach ($datas as $data)
            <tr>
                <td scope="row">{{ $data->id }}</td>
                <td><strong>{{ $data->name }}</strong></td>
                <td>{{ $data->email }}</td>
            </tr>
        @endforeach
    </x-slot:tbody>
</x-report.table>
```
## License

This package is licensed under the MIT License. See LICENSE for more details.

## Contributing

Contributions are welcome! Please refer to CONTRIBUTING.md for guidelines.

## Support

For issues or feature requests, please open an issue on the GitHub repository.
