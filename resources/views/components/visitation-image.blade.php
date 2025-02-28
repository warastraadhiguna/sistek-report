@if ($visitation)
    <div class="bg-gray-100 p-4 rounded-md mb-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Visitation</h2>
        
        <div class="bg-white p-4 rounded-lg shadow">
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="font-medium text-gray-700 w-1/4 py-2">Taxpayer</td>
                        <td class="text-gray-900 py-2">:</td>
                        <td class="text-gray-900 py-2">{{ $visitation->taxpayer->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-700 w-1/4 py-2">Technician</td>
                        <td class="text-gray-900 py-2">:</td>
                        <td class="text-gray-900 py-2">{{ $visitation->technician->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium text-gray-700 w-1/4 py-2">Detail</td>
                        <td class="text-gray-900 py-2">:</td>
                        <td class="text-gray-900 py-2">{{ $visitation->detail ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
