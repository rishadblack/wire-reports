<x-report.table>
    <x-slot:header>
        <tr>
            <td colspan="3" style="text-align: center; vertical-align: middle;">
                {{-- <img src="{{ url('images/logo.png') }}" alt="logo" width="100px" height="100px" /> --}}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-weight: bold; font-size: 20px;">
                <h1>প্রতিবেদন</h1>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">
                <p><b>বাংলাদেশ এবং বিশ্বের সর্বশেষ খবর [page]</b></p>
            </td>
        </tr>
    </x-slot:header>
    <x-slot:subheader>
        <tr>
            <th>Sub Header</th>
        </tr>
    </x-slot:subheader>
    <x-slot:thead>
        <tr>
            <th>ক্রমিক নং</th>
            <th>নাম</th>
            <th>ইমেইল</th>
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
</x-report.table>
