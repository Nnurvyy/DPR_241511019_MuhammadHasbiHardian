{{-- filepath: resources/views/kelola-mahasiswa.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mt-8 mb-2">Students</h3>
                    <div class="mb-4 flex items-center gap-2">
                        <button id="open-modal-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Add Student</button>
                    </div>

                    {{-- Modal Create Student --}}
                    <div id="modal-student" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Add Student</h3>
                            <form id="form-student" class="space-y-4">
                                @csrf

                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" name="username" type="text"
                                        class="mt-1 block w-full"
                                        autofocus autocomplete="username" />
                                </div>

                                <div>
                                    <x-input-label for="full_name" :value="__('Full Name')" />
                                    <x-text-input id="full_name" name="full_name" type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="name" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="mt-1 block w-full"
                                        autocomplete="email" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-password-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                </div>

                                <div>
                                    <x-input-label for="entry_year" :value="__('Entry Year')" />
                                    <x-text-input id="entry_year" name="entry_year" type="number"
                                        class="mt-1 block w-full"
                                        />
                                </div>

                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit Student --}}
                    <div id="modal-edit-student" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Edit Student</h3>
                            <form id="form-edit-student" class="space-y-4">
                                @csrf
                                <input type="hidden" id="edit-student-id" name="student_id">
                                <div>
                                    <x-input-label for="edit-username" :value="__('Username')" />
                                    <x-text-input id="edit-username" name="username" type="text"
                                        class="mt-1 block w-full text-center"
                                        autofocus autocomplete="username" />
                                </div>
                                <div>
                                    <x-input-label for="edit-full_name" :value="__('Full Name')" />
                                    <x-text-input id="edit-full_name" name="full_name" type="text"
                                        class="mt-1 block w-full text-center"
                                        autocomplete="name" />
                                </div>
                                <div>
                                    <x-input-label for="edit-email" :value="__('Email')" />
                                    <x-text-input id="edit-email" name="email" type="email"
                                        class="mt-1 block w-full text-center"
                                        autocomplete="email" />
                                </div>
                                <div>
                                    <x-input-label for="edit-entry_year" :value="__('Entry Year')" />
                                    <x-text-input id="edit-entry_year" name="entry_year" type="number"
                                        class="mt-1 block w-full text-center"
                                        />
                                </div>
                                <div>
                                    <x-input-label for="edit-password" :value="__('Password (Kosongkan jika tidak diubah)')" />
                                    <x-password-input id="edit-password" class="block mt-1 w-full text-center" type="password" name="password" autocomplete="new-password" />
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table id="table-students" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border border-gray-400 px-2 py-1 text-center">No</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Username</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Full Name</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Email</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Entry Year</th>
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
        <script src="{{ asset('js/student.js') }}"></script>
    @endpush
</x-app-layout>