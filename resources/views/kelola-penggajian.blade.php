{{-- filepath: resources/views/kelola-penggajian.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-xl font-semibold mb-4">Kelola Penggajian</h3>

                        {{-- Baris baru untuk tombol dan pencarian, di bawah judul --}}
                        <div class="flex justify-between items-center mb-4">
                            
                            {{-- Bagian Kiri: Hanya tombol "Tambah Penggajian" --}}
                            <div>
                                <button id="open-modal-penggajian" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Penggajian</button>
                            </div>
                            
                            {{-- Bagian Kanan: Form Pencarian --}}
                            <div class="flex items-center gap-2">
                                <input id="search-penggajian" type="text" placeholder="Cari Nama/Jabatan/ID..." class="border rounded px-2 py-1 dark:bg-gray-800 dark:text-white" />
                                <button id="search-button" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                            </div>

                        </div>

                    {{-- Modal create penggajian --}}
                    <div id="modal-penggajian" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Tambah Data Penggajian</h3>
                            <form id="form-penggajian" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="id_anggota" :value="__('Pilih Anggota')" />
                                    <select id="id_anggota" name="id_anggota" class="mt-1 block w-full border rounded dark:text-black"></select>
                                </div>
                                <div>
                                    <x-input-label for="id_komponen_gaji" :value="__('Pilih Komponen Gaji')" />
                                    <select id="id_komponen_gaji" name="id_komponen_gaji" class="mt-1 block w-full border rounded dark:text-black"></select>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-penggajian" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
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

                    {{-- Modal edit penggajian --}}
                    <div id="modal-edit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full">
                            <h3 class="text-lg font-bold mb-4">Edit Penggajian</h3>
                            <div id="edit-header" class="mb-2"></div>
                            <div id="edit-komponen-list" class="mb-2"></div>
                            <div id="edit-take-home-pay" class="mb-2 font-bold"></div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" id="close-modal-edit" class="px-3 py-1 bg-gray-400 text-white rounded">Tutup</button>
                                <button type="button" id="add-komponen-btn" class="px-3 py-1 bg-green-600 text-white rounded">Tambah Komponen Gaji</button>
                            </div>
                            <div id="add-komponen-form" class="mt-3 hidden"></div>
                        </div>
                    </div>

                    {{-- Tabel penggajian --}}
                    <table id="table-penggajian" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border px-2 py-1">ID Anggota</th>
                                <th class="border px-2 py-1">Gelar Depan</th>
                                <th class="border px-2 py-1">Nama Depan</th>
                                <th class="border px-2 py-1">Nama Belakang</th>
                                <th class="border px-2 py-1">Gelar Belakang</th>
                                <th class="border px-2 py-1">Jabatan</th>
                                <th class="border px-2 py-1">Take Home Pay</th>
                                <th class="border px-2 py-1">Action</th>
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
        <script src="{{ asset('js/penggajian.js') }}"></script>
    @endpush
</x-app-layout>