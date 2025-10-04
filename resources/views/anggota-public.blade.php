{{-- filepath: resources/views/anggota-public.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Daftar Anggota DPR</h3>
                    <div class="flex justify-end items-center mb-4">
                        <input id="search-anggota" type="text" placeholder="Cari Nama/Jabatan/ID..." class="border rounded px-2 py-1 dark:bg-gray-800 dark:text-white" />
                        <button id="search-button-anggota" class="px-4 py-2 bg-blue-600 text-white rounded ml-2">Cari</button>
                    </div>
                    <table id="table-anggota" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border px-2 py-1 text-center">No</th>
                                <th class="border px-2 py-1 text-center">ID Anggota</th>
                                <th class="border px-2 py-1 text-center">Nama Depan</th>
                                <th class="border px-2 py-1 text-center">Nama Belakang</th>
                                <th class="border px-2 py-1 text-center">Gelar Depan</th>
                                <th class="border px-2 py-1 text-center">Gelar Belakang</th>
                                <th class="border px-2 py-1 text-center">Jabatan</th>
                                <th class="border px-2 py-1 text-center">Status Pernikahan</th>
                                <th class="border px-2 py-1 text-center">Jumlah Anak</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/anggota-public.js') }}"></script>
    @endpush
</x-app-layout>