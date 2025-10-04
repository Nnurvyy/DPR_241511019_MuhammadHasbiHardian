let anggotaList = [];

function fetchAnggota(q = '') {
    fetch('/api/anggota-all' + (q ? '?q=' + encodeURIComponent(q) : ''))
        .then(res => res.json())
        .then(data => {
            anggotaList = data;
            renderAnggota();
        });
}

function renderAnggota() {
    let tbody = document.querySelector('#table-anggota tbody');
    tbody.innerHTML = '';
    if (anggotaList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center p-4">Tidak ada data.</td></tr>';
        return;
    }
    anggotaList.forEach((a, idx) => {
        tbody.innerHTML += `
            <tr>
                <td class="border px-2 py-1 text-center">${idx + 1}</td>
                <td class="border px-2 py-1 text-center">${a.id_anggota}</td>
                <td class="border px-2 py-1 text-center">${a.nama_depan}</td>
                <td class="border px-2 py-1 text-center">${a.nama_belakang || '-'}</td>
                <td class="border px-2 py-1 text-center">${a.gelar_depan || '-'}</td>
                <td class="border px-2 py-1 text-center">${a.gelar_belakang || '-'}</td>
                <td class="border px-2 py-1 text-center">${a.jabatan}</td>
                <td class="border px-2 py-1 text-center">${a.status_pernikahan}</td>
                <td class="border px-2 py-1 text-center">${a.jumlah_anak}</td>
            </tr>
        `;
    });
}


document.addEventListener('DOMContentLoaded', function() {
    fetchAnggota();

    // Search
    const searchInput = document.getElementById('search-anggota');
    const searchButton = document.getElementById('search-button-anggota');
    function performSearch() {
        fetchAnggota(searchInput.value);
    }
    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') performSearch();
    });

    // Modal detail close
    document.getElementById('close-modal-detail').onclick = () => document.getElementById('modal-detail').classList.add('hidden');
});