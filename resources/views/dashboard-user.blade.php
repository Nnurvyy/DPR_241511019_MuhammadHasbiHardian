{{-- filepath: resources/views/dashboard-user.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg shadow-lg p-8 mb-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard Publik Penggajian DPR</h2>
                <p class="text-lg">Lihat data anggota DPR dan penggajian secara transparan.<br>
                Gunakan menu di atas untuk akses data.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2" id="stat-anggota">-</div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Anggota DPR</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-green-600 mb-2" id="stat-penggajian">-</div>
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Data Penggajian</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-blue-700 dark:text-blue-300">Fitur Publik</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm">
                        <li>Lihat daftar anggota DPR (read only).</li>
                        <li>Lihat data penggajian anggota DPR (read only).</li>
                        <li>Gunakan fitur pencarian dan detail untuk transparansi.</li>
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2 text-green-700 dark:text-green-300">Info Singkat</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">Data penggajian dan anggota DPR dapat diakses publik tanpa bisa mengubah data.</p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        // Ambil statistik dari API
        async function fetchDashboardStats() {
            try {
                let [anggota, penggajian] = await Promise.all([
                    fetch('/api/anggota-all').then(r => r.json()),
                    fetch('/api/penggajian-all').then(r => r.json()),
                ]);
                document.getElementById('stat-anggota').textContent = anggota.length;
                document.getElementById('stat-penggajian').textContent = penggajian.length;
            } catch (e) {
                document.getElementById('stat-anggota').textContent = '-';
                document.getElementById('stat-penggajian').textContent = '-';
            }
        }
        fetchDashboardStats();
    </script>
    @endpush
</x-app-layout>