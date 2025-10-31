<div class="fi-ta w-full rounded-xl border border-gray-200 shadow-sm overflow-hidden bg-white">
    <table class="fi-ta-table w-full text-sm divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-center font-medium text-gray-600 uppercase tracking-wider w-2/4">
                    Indeks
                </th>
                <th class="px-5 py-3 text-center font-medium text-gray-600 uppercase tracking-wider w-1/6">
                    Nilai
                </th>
                <th class="px-5 py-3 text-center font-medium text-gray-600 uppercase tracking-wider w-1/6">
                    Kategori
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($data as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-center text-gray-800">
                        {{ $row['indeks'] }}
                    </td>
                    <td class="px-5 py-3 text-center text-gray-700">
                        {{ $row['nilai'] }}
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $colorClass = match ($row['kategori']) {
                                'Tinggi' => 'fi-badge-success',
                                'Sedang' => 'fi-badge-warning',
                                'Rendah' => 'fi-badge-danger',
                                default => 'fi-badge-secondary',
                            };
                        @endphp
                        <span class="fi-badge {{ $colorClass }}">
                            {{ $row['kategori'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
