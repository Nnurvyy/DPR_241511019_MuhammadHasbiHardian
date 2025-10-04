{{-- filepath: resources/views/penggajian-public.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Data Penggajian Anggota DPR</h3>
                    <div class="flex justify-end items-center mb-4">
                        <input id="search-penggajian" type="text" placeholder="Cari Nama/Jabatan/ID..." class="border rounded px-2 py-1 dark:bg-gray-800 dark:text-white" />
                        <button id="search-button" class="px-4 py-2 bg-blue-600 text-white rounded ml-2">Cari</button>
                    </div>

                    {{-- Modal detail penggajian --}}
                    <div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full">
                            <h3 class="text-lg font-bold mb-4">Detail Penggajian</h3>
                            <div id="detail-content" class="space-y-3">
                                {{-- Konten detail diisi oleh JavaScript --}}
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" id="close-modal-detail" class="px-3 py-1 bg-gray-400 text-white rounded">Tutup</button>
                            </div>
                        </div>
                    </div>

                    <table id="table-penggajian" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border px-2 py-1 text-center">ID Anggota</th>
                                <th class="border px-2 py-1 text-center">Gelar Depan</th>
                                <th class="border px-2 py-1 text-center">Nama Depan</th>
                                <th class="border px-2 py-1 text-center">Nama Belakang</th>
                                <th class="border px-2 py-1 text-center">Gelar Belakang</th>
                                <th class="border px-2 py-1 text-center">Jabatan</th>
                                <th class="border px-2 py-1 text-center">Take Home Pay</th>
                                <th class="border px-2 py-1 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Diisi JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/penggajian-public.js') }}"></script>
    @endpush
</x-app-layout>