{{-- filepath: resources/views/kelola-mahasiswa.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mt-8 mb-2">Komponen Gaji</h3>
                    <div class="mb-4 flex items-center gap-2">
                        <button id="open-modal-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Add Komponen Gaji</button>
                    </div>

                    {{-- Modal Create Komponen Gaji --}}
                    <div id="modal-komponen-gaji" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Add Komponen Gaji</h3>
                            <form id="form-komponen-gaji" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="nama_komponen" :value="__('Nama Komponen')" />
                                    <x-text-input id="nama_komponen" name="nama_komponen" type="text"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="nama_komponen" />
                                </div>

                                <div>
                                    <x-input-label for="kategori" :value="__('Kategori')" />
                                    <x-text-input id="kategori" name="kategori" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="kategori" />
                                </div>

                                <div>
                                    <x-input-label for="jabatan" :value="__('Jabatan')" />
                                    <x-text-input id="jabatan" name="jabatan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="jabatan" />
                                </div>
                                <div>
                                    <x-input-label for="nominal" :value="__('Nominal')" />
                                    <x-text-input id="nominal" name="nominal" type="number"
                                        class="mt-1 block w-full"
                                        autocomplete="nominal" />
                                </div>
                                <div>
                                    <x-input-label for="satuan" :value="__('Satuan')" />
                                    <x-text-input id="satuan" name="satuan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="satuan" />
                                </div>

                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit Komponen Gaji --}}
                    <div id="modal-edit-komponen-gaji" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Edit Komponen Gaji</h3>
                            <form id="form-edit-komponen-gaji" class="space-y-4">
                                @csrf
                                <input type="hidden" id="edit-komponen_gaji_id" name="komponen_gaji_id">
                                <div>
                                    <x-input-label for="edit-id_komponen_gaji" :value="__('ID Komponen Gaji')" />
                                    <x-text-input id="edit-id_komponen_gaji" name="id_komponen_gaji" type="number"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="id_komponen_gaji" />
                                </div>
                                <div>
                                    <x-input-label for="edit-nama_komponen" :value="__('Nama Komponen')" />
                                    <x-text-input id="edit-nama_komponen" name="nama_komponen" type="text"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="nama_komponen" />
                                </div>

                                <div>
                                    <x-input-label for="edit-kategori" :value="__('Kategori')" />
                                    <x-text-input id="edit-kategori" name="kategori" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="kategori" />
                                </div>

                                <div>
                                    <x-input-label for="edit-jabatan" :value="__('Jabatan')" />
                                    <x-text-input id="edit-jabatan" name="jabatan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="jabatan" />
                                </div>
                                <div>
                                    <x-input-label for="edit-nominal" :value="__('Nominal')" />
                                    <x-text-input id="edit-nominal" name="nominal" type="number"
                                        class="mt-1 block w-full"
                                        autocomplete="nominal" />
                                </div>
                                <div>
                                    <x-input-label for="edit-satuan" :value="__('Satuan')" />
                                    <x-text-input id="edit-satuan" name="satuan" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="satuan" />
                                </div>
                                
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/komponen_gaji.js') }}"></script>
    @endpush
</x-app-layout>