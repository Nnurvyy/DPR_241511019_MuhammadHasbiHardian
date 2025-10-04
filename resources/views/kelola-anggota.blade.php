<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-xl font-semibold mb-4">Kelola Anggota</h3>

                    <div class="flex justify-between items-center mb-4">
                        {{-- Bagian Kiri: Tombol Tambah --}}
                        <div>
                            <button id="open-modal-btn" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Anggota</button>
                        </div>
                        
                        {{-- Bagian Kanan: Pencarian --}}
                        <div class="flex items-center gap-2">
                            <input id="search-anggota" type="text" placeholder="Cari Nama/Jabatan/ID..." class="border rounded px-2 py-1 dark:bg-gray-800 dark:text-white" />
                            <button id="search-button-anggota" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                        </div>
                    </div>

                    {{-- MODAL UNTUK TAMBAH ANGGOTA BARU --}}
                    <div id="modal-anggota" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full max-h-[90vh] overflow-y-auto">
                            <h3 class="text-lg font-bold mb-4">Tambah Anggota Baru</h3>
                            <form id="form-anggota" class="space-y-4" novalidate>
                                @csrf
                                <div>
                                    <label for="nama_depan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Depan</label>
                                    <input type="text" id="nama_depan" name="nama_depan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="nama_belakang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Belakang</label>
                                    <input type="text" id="nama_belakang" name="nama_belakang" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="gelar_depan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gelar Depan (Opsional)</label>
                                    <input type="text" id="gelar_depan" name="gelar_depan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="gelar_belakang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gelar Belakang (Opsional)</label>
                                    <input type="text" id="gelar_belakang" name="gelar_belakang" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                                    <select id="jabatan" name="jabatan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                        <option value="Anggota">Anggota</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status_pernikahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pernikahan</label>
                                    <select id="status_pernikahan" name="status_pernikahan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jumlah_anak" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anak</label>
                                    <input type="number" id="jumlah_anak" name="jumlah_anak" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white" value="0" min="0">
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    {{-- MODAL UNTUK EDIT ANGGOTA --}}
                    <div id="modal-edit-anggota" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-lg w-full max-h-[90vh] overflow-y-auto">
                            <h3 class="text-lg font-bold mb-4">Edit Data Anggota</h3>
                            <form id="form-edit-anggota" class="space-y-4" novalidate>
                                @csrf
                                <input type="hidden" id="edit-anggota-id">
                                <div>
                                    <label for="edit-id_anggota" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID Anggota</label>
                                    <input type="text" id="edit-id_anggota" name="id_anggota" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-nama_depan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Depan</label>
                                    <input type="text" id="edit-nama_depan" name="nama_depan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-nama_belakang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Belakang</label>
                                    <input type="text" id="edit-nama_belakang" name="nama_belakang" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-gelar_depan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gelar Depan (Opsional)</label>
                                    <input type="text" id="edit-gelar_depan" name="gelar_depan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-gelar_belakang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gelar Belakang (Opsional)</label>
                                    <input type="text" id="edit-gelar_belakang" name="gelar_belakang" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="edit-jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                                    <select id="edit-jabatan" name="jabatan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                        <option value="Anggota">Anggota</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-status_pernikahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pernikahan</label>
                                    <select id="edit-status_pernikahan" name="status_pernikahan" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-jumlah_anak" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anak</label>
                                    <input type="number" id="edit-jumlah_anak" name="jumlah_anak" class="mt-1 block w-full border rounded dark:bg-gray-700 dark:text-white" min="0">
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabel Anggota --}}
                    <table id="table-anggota" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border border-gray-400 px-2 py-1 text-center">No</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">ID Anggota</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Nama Depan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Nama Belakang</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Gelar Depan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Gelar Belakang</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Jabatan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Status Pernikahan</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Jumlah Anak</th>
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
        <script type="module" src="{{ asset('js/anggota.js') }}"></script>
    @endpush
</x-app-layout>