{{-- filepath: resources/views/dashboard-admin.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-600 to-green-500 rounded-lg shadow-lg p-8 mb-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Admin Penggajian DPR</h2>
                <p class="text-lg">Kelola data anggota, komponen gaji, dan penggajian dengan mudah.<br>
                Gunakan menu navigasi di atas untuk mengakses fitur manajemen data.</p>
            </div>
            
            {{-- STATISTIC BOXES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2" id="stat-anggota">-</div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Anggota DPR</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh anggota DPR yang terdaftar</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-green-600 mb-2" id="stat-komponen">-</div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Komponen Gaji</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh komponen gaji aktif</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2" id="stat-penggajian">-</div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Data Penggajian</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jumlah seluruh data penggajian anggota</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-blue-700 dark:text-blue-300">Tips Pengelolaan Data</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm">
                        <li>Pastikan data anggota selalu terupdate.</li>
                        <li>Tambah atau edit komponen gaji sesuai kebutuhan.</li>
                        <li>Gunakan fitur pencarian untuk menemukan data dengan cepat.</li>
                        <li>Periksa take home pay anggota secara berkala.</li>
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-green-700 dark:text-green-300">Info Singkat</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">Kelola data penggajian anggota DPR dengan fitur CRUD, pencarian, dan validasi otomatis.</p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm">
                        <li>Tambah anggota, komponen gaji, dan data penggajian dari menu navigasi.</li>
                        <li>Setiap perubahan data langsung tersimpan dan terupdate di tabel.</li>
                        <li>Take home pay otomatis menghitung tunjangan istri/suami dan anak sesuai aturan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        // Ambil statistik dari API
        async function fetchDashboardStats() {
            try {
                let [anggota, komponen, penggajian] = await Promise.all([
                    fetch('/api/anggota-all').then(r => r.json()),
                    fetch('/api/komponen-gaji-all').then(r => r.json()),
                    fetch('/api/penggajian-all').then(r => r.json()),
                ]);
                document.getElementById('stat-anggota').textContent = anggota.length;
                document.getElementById('stat-komponen').textContent = komponen.length;
                document.getElementById('stat-penggajian').textContent = penggajian.length;
            } catch (e) {
                document.getElementById('stat-anggota').textContent = '-';
                document.getElementById('stat-komponen').textContent = '-';
                document.getElementById('stat-penggajian').textContent = '-';
            }
        }
        fetchDashboardStats();
    </script>
    @endpush
</x-app-layout>