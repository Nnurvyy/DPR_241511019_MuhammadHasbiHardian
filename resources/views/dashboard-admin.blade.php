<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg shadow-lg p-8 mb-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Admin Akademik!</h2>
                <p class="text-lg">Kelola data mahasiswa dan mata kuliah dengan mudah dan efisien.<br>
                Gunakan menu navigasi di atas untuk mengakses fitur manajemen data.</p>
            </div>
            
            {{-- STATISTIC BOXES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2"> 10 </div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Mahasiswa</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh mahasiswa aktif di sistem</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-green-600 mb-2"> 9 </div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Courses</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh mata kuliah yang tersedia</div>
                </div>
            </div>

            {{-- KONTEN TAMBAHAN --}}
            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-blue-700 dark:text-blue-300">Tips Pengelolaan Data</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm">
                        <li>Pastikan data mahasiswa selalu terupdate.</li>
                        <li>Tambah atau edit mata kuliah sesuai kebutuhan kurikulum.</li>
                        <li>Gunakan fitur pencarian untuk menemukan data dengan cepat.</li>
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-green-700 dark:text-green-300">Statistik Singkat</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">Mahasiswa terbanyak mengambil mata kuliah pada semester ganjil.</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Pantau perkembangan data secara berkala untuk hasil terbaik.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>