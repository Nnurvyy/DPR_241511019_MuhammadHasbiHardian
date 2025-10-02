<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    {{-- ================= MY COURSES ================= --}}
                    <h3 class="text-xl font-semibold mt-8 mb-2">My Courses</h3>
                    <table class="w-full mb-2 border-collapse border border-gray-900 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="border px-2 py-1">Name</th>
                                <th class="border px-2 py-1">Credits</th>
                                <th class="border px-2 py-1">Enroll Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myCourses as $take)
                                <tr>
                                    <td class="border px-2 py-1">{{ $take->course->course_name ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-center">{{ $take->course->credits ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-center">{{ $take->enroll_date ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $myCourses->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>