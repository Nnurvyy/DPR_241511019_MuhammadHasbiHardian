{{-- filepath: resources/views/dashboard-user.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg shadow-lg p-8 mb-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Student Akademik!</h2>
                <p class="text-lg">Lihat dan daftar mata kuliah yang tersedia.<br>
                Gunakan menu navigasi di atas untuk mengakses fitur mahasiswa.</p>
            </div>
            
            {{-- STATISTIC BOXES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2"> 1 </div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Mata Kuliah</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh mata kuliah yang tersedia</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-green-600 mb-2"> 0 </div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Mata Kuliah Diambil</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah mata kuliah yang sudah kamu enroll</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-blue-700 dark:text-blue-300">Tips Akademik</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm">
                        <li>Pastikan kamu mengambil mata kuliah sesuai rencana studi.</li>
                        <li>Gunakan fitur pencarian untuk menemukan mata kuliah yang kamu minati.</li>
                        <li>Cek jadwal dan jumlah SKS sebelum enroll.</li>
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-green-700 dark:text-green-300">Info Singkat</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">Kamu dapat melihat daftar mata kuliah yang sudah diambil di menu "My Courses".</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Selalu pantau pengumuman terbaru dari admin.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>