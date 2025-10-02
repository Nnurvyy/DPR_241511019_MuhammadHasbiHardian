{{-- filepath: resources/views/kelola-course.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mt-8 mb-2">Courses</h3>
                    <div class="mb-4 flex items-center gap-2">
                        <button id="open-modal-course-btn" class="px-4 py-2 bg-blue-600 text-white rounded">Add Course</button>
                    </div>

                    {{-- Modal Create Course --}}
                    <div id="modal-course" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Add Course</h3>
                            <form id="form-course" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="course_name" :value="__('Course Name')" />
                                    <x-text-input id="course_name" name="course_name" type="text"
                                        class="mt-1 block w-full"
                                        required autofocus autocomplete="course_name" />
                                </div>
                                <div>
                                    <x-input-label for="credits" :value="__('Credits')" />
                                    <x-text-input id="credits" name="credits" type="number"
                                        class="mt-1 block w-full"
                                        required autocomplete="credits" />
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                                    <button type="button" id="close-modal-course-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit Course --}}
                    <div id="modal-edit-course" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Edit Course</h3>
                            <form id="form-edit-course" class="space-y-4">
                                @csrf
                                <input type="hidden" id="edit-course-id" name="course_id">
                                <div>
                                    <x-input-label for="edit-course_name" :value="__('Course Name')" />
                                    <x-text-input id="edit-course_name" name="course_name" type="text"
                                        class="mt-1 block w-full"
                                        required autofocus autocomplete="course_name" />
                                </div>
                                <div>
                                    <x-input-label for="edit-credits" :value="__('Credits')" />
                                    <x-text-input id="edit-credits" name="credits" type="number"
                                        class="mt-1 block w-full"
                                        required autocomplete="credits" />
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Update</button>
                                    <button type="button" id="close-edit-course-modal-btn" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table id="table-courses" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border border-gray-400 px-2 py-1 text-center">No</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Name</th>
                                <th class="border border-gray-400 px-2 py-1 text-center">Credits</th>
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
        <script src="{{ asset('js/course.js') }}"></script>
    @endpush
</x-app-layout>