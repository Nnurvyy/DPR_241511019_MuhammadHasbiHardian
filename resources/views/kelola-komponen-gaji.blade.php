{{-- filepath: resources/views/kelola-mahasiswa.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Kelola Komponen Gaji</h3>
                    <div class="flex justify-between items-center mb-4">
                        {{-- Bagian Kiri --}}
                        <div class="flex items-center gap-4">
                            <button id="open-modal-btn" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Komponen</button>
                        </div>
                        
                        {{-- Bagian Kanan (Pencarian) --}}
                        <div class="flex items-center gap-2">
                            <input id="search-komponen" type="text" placeholder="Cari komponen gaji..." class="border rounded px-2 py-1 dark:bg-gray-800 dark:text-white" />
                            <button id="search-button-komponen" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                        </div>
                    </div>

                    {{-- MODAL UNTUK TAMBAH KOMPONEN GAJI --}}
                    <div id="modal-komponen-gaji" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full max-h-[90vh] overflow-y-auto">
                            <h3 class="text-lg font-bold mb-4">Tambah Komponen Gaji Baru</h3>
                            <form id="form-komponen-gaji" class="space-y-4" novalidate>
                                @csrf
                                <div>
                                    <label for="nama_komponen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Komponen</label>
                                    <input type="text" name="nama_komponen" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                    <select name="kategori" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Gaji Pokok">Gaji Pokok</option>
                                        <option value="Tunjangan Melekat">Tunjangan Melekat</option>
                                        <option value="Tunjangan Lain">Tunjangan Lain</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berlaku untuk Jabatan</label>
                                    <select name="jabatan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Semua">Semua</option>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                        <option value="Anggota">Anggota</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="nominal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nominal</label>
                                    <input type="number" name="nominal" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white" min="0">
                                </div>
                                <div>
                                    <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                                    <select name="satuan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="Bulan">Bulan</option>
                                        <option value="Hari">Hari</option>
                                        <option value="Periode">Periode</option>
                                    </select>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL UNTUK EDIT KOMPONEN GAJI --}}
                    <div id="modal-edit-komponen-gaji" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full max-h-[90vh] overflow-y-auto">
                            <h3 class="text-lg font-bold mb-4">Edit Komponen Gaji</h3>
                            <form id="form-edit-komponen-gaji" class="space-y-4" novalidate>
                                @csrf
                                <input type="hidden" id="edit-komponen_gaji_id">
                                <div>
                                    <label for="edit-nama_komponen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Komponen</label>
                                    <input type="text" id="edit-nama_komponen" name="nama_komponen" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                    <select id="edit-kategori" name="kategori" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Gaji Pokok">Gaji Pokok</option>
                                        <option value="Tunjangan Melekat">Tunjangan Melekat</option>
                                        <option value="Tunjangan Lain">Tunjangan Lain</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berlaku untuk Jabatan</label>
                                    <select id="edit-jabatan" name="jabatan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Semua">Semua</option>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                        <option value="Anggota">Anggota</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-nominal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nominal</label>
                                    <input type="number" id="edit-nominal" name="nominal" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white" min="0">
                                </div>
                                <div>
                                    <label for="edit-satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                                    <select id="edit-satuan" name="satuan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="Bulan">Bulan</option>
                                        <option value="Hari">Hari</option>
                                        <option value="Periode">Periode</option>
                                    </select>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table id="table-komponen-gaji" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border border-gray-400 px-2 py-1 text-center">No</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">ID Komponen Gaji</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Nama Komponen</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Kategori</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Jabatan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Nominal</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Satuan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Action</th>
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
        <script type="module" src="{{ asset('js/komponen_gaji.js') }}"></script>
    @endpush
</x-app-layout>