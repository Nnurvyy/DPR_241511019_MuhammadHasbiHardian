<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ================= ALL COURSES ================= --}}
                    <h3 class="text-xl font-semibold mt-8 mb-2">All Courses</h3>
                    <table id="table-courses" class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border px-2 py-1 text-center">No</th>
                                <th class="border px-2 py-1 text-center">Course Name</th>
                                <th class="border px-2 py-1 text-center">Credits</th>
                                <th class="border px-2 py-1 text-center">Status</th>
                                <th class="border px-2 py-1 text-center">Enroll</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data diisi oleh JS --}}
                        </tbody>
                    </table>

                    <!-- Total SKS -->
                    <div id="total-credits" class="mt-2 font-semibold text-gray-700 dark:text-gray-300">
                        Total Credits Selected: 0
                    </div>

                    <button id="submit-enroll" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Submit Enroll</button>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/all-course.js') }}"></script>
    @endpush
</x-app-layout>