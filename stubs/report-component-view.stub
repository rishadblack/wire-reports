  <x-wire-reports::layout>
    <x-wire-reports::table>
        <x-slot:filter>
            <input wire:model.live="filters.name" class="form-select form-select-sm" placeholder="Name" />
            <input wire:model.live="filters.email" class="form-select form-select-sm" placeholder="Email" />
        </x-slot:filter>
        <x-slot:button>
            <button wire:click="export('pdf')" class="btn btn-primary">PDF</button>
            <button wire:click="export('csv')" class="btn btn-primary">CSV</button>
            <button wire:click="export('xlsx')" class="btn btn-primary">XLSX</button>
        </x-slot:button>
        <x-slot:logo>
            <tr>
                <td colspan="3" style="text-align: center; vertical-align: middle;">
                    <img src="{{ url('images/logo.png') }}" alt="logo" width="100px" height="100px" />
                </td>
            </tr>
        </x-slot:logo>
        <x-slot:header>
            <tr>
                <td colspan="3" style="text-align: center; font-weight: bold; font-size: 20px;">
                    <h1>User Report</h1>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;">
                    <p><b>All user reports</b></p>
                </td>
            </tr>
        </x-slot:header>
        <x-slot:subheader>
            <tr>
                <th>NB: All user are active.</th>
            </tr>
        </x-slot:subheader>
        <x-slot:thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
            </tr>
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
        <x-slot:footer>
            Copyright 2024
        </x-slot:footer>
    </x-wire-reports::table>
  </x-wire-reports::layout>
