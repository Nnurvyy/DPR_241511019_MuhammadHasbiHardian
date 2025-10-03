{{-- filepath: resources/views/kelola-mahasiswa.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mt-8 mb-2">Anggota</h3>
                    <div class="mb-4 flex items-center gap-2">
                        <button id="open-modal-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Add Anggota</button>
                    </div>

                    {{-- Modal Create Anggota --}}
                    <div id="modal-anggota" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Add Anggota</h3>
                            <form id="form-anggota" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="nama_depan" :value="__('Nama Depan')" />
                                    <x-text-input id="nama_depan" name="nama_depan" type="text"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="nama_depan" />
                                </div>

                                <div>
                                    <x-input-label for="nama_belakang" :value="__('Nama Belakang')" />
                                    <x-text-input id="nama_belakang" name="nama_belakang" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="nama_belakang" />
                                </div>

                                <div>
                                    <x-input-label for="gelar_depan" :value="__('Gelar Depan')" />
                                    <x-text-input id="gelar_depan" name="gelar_depan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="gelar_depan" />
                                </div>
                                <div>
                                    <x-input-label for="gelar_belakang" :value="__('Gelar Belakang')" />
                                    <x-text-input id="gelar_belakang" name="gelar_belakang" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="gelar_belakang" />
                                </div>
                                <div>
                                    <x-input-label for="jabatan" :value="__('Jabatan')" />
                                    <x-text-input id="jabatan" name="jabatan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="jabatan" />
                                </div>
                                <div>
                                    <x-input-label for="status_pernikahan" :value="__('Status Pernikahan')" />
                                    <x-text-input id="status_pernikahan" name="status_pernikahan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="status_pernikahan" />
                                </div>
                                <div>
                                    <x-input-label for="jumlah_anak" :value="__('Jumlah Anak')" />
                                    <x-text-input id="jumlah_anak" name="jumlah_anak" type="number"
                                        class="mt-1 block w-full"
                                        autocomplete="jumlah_anak" />
                                </div>

                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit Anggota --}}
                    <div id="modal-edit-anggota" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Edit Anggota</h3>
                            <form id="form-edit-anggota" class="space-y-4">
                                @csrf
                                <input type="hidden" id="edit-anggota-id" name="anggota_id">
                                <div>
                                    <x-input-label for="edit-id_anggota" :value="__('ID Anggota')" />
                                    <x-text-input id="edit-id_anggota" name="id_anggota" type="number"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="id_anggota" />
                                </div>
                                <div>
                                    <x-input-label for="edit-nama_depan" :value="__('Nama Depan')" />
                                    <x-text-input id="edit-nama_depan" name="nama_depan" type="text"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="nama_depan" />
                                </div>

                                <div>
                                    <x-input-label for="edit-nama_belakang" :value="__('Nama Belakang')" />
                                    <x-text-input id="edit-nama_belakang" name="nama_belakang" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="nama_belakang" />
                                </div>

                                <div>
                                    <x-input-label for="edit-gelar_depan" :value="__('Gelar Depan')" />
                                    <x-text-input id="edit-gelar_depan" name="gelar_depan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="gelar_depan" />
                                </div>
                                <div>
                                    <x-input-label for="edit-gelar_belakang" :value="__('Gelar Belakang')" />
                                    <x-text-input id="edit-gelar_belakang" name="gelar_belakang" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="gelar_belakang" />
                                </div>
                                <div>
                                    <x-input-label for="edit-jabatan" :value="__('Jabatan')" />
                                    <x-text-input id="edit-jabatan" name="jabatan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="jabatan" />
                                </div>
                                <div>
                                    <x-input-label for="edit-status_pernikahan" :value="__('Status Pernikahan')" />
                                    <x-text-input id="edit-status_pernikahan" name="status_pernikahan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="status_pernikahan" />
                                </div>
                                <div>
                                    <x-input-label for="edit-jumlah_anak" :value="__('Jumlah Anak')" />
                                    <x-text-input id="edit-jumlah_anak" name="jumlah_anak" type="number"
                                        class="mt-1 block w-full"
                                        autocomplete="jumlah_anak" />
                                </div>
                                
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

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
        <script src="{{ asset('js/anggota.js') }}"></script>
    @endpush
</x-app-layout>