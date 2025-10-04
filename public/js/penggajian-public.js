let penggajianList = [];

function formatRupiah(number) {
    const num = number || 0;
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(num);
}

function showNotif(msg, color = 'green') {
    let notif = document.createElement('div');
    notif.textContent = msg;
    let bgClass = 'bg-green-600';
    if (color === 'red') bgClass = 'bg-red-600';
    notif.className = `fixed top-5 right-5 z-[9999] px-4 py-2 rounded shadow text-white ${bgClass}`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
}

async function fetchAnggota() {
    try {
        let res = await fetch('/api/anggota-all');
        anggotaList = await res.json();
        // Isi dropdown anggota
        let select = document.getElementById('id_anggota');
        select.innerHTML = '<option value="">-- Pilih Anggota --</option>';
        anggotaList.forEach(a => {
            select.innerHTML += `<option value="${a.id_anggota}">${a.nama_depan} ${a.nama_belakang ?? ''} (${a.jabatan})</option>`;
        });
    } catch (error) {
        console.error('Gagal fetch anggota:', error);
    }
}

async function fetchKomponenGaji() {
    try {
        let res = await fetch('/api/komponen-gaji-all');
        komponenGajiList = await res.json();
    } catch (error) {
        console.error('Gagal fetch komponen gaji:', error);
    }
}

async function fetchPenggajian(q = '') {
    try {
        let res = await fetch('/api/penggajian-all' + (q ? '?q=' + encodeURIComponent(q) : ''));
        penggajianList = await res.json();
        renderPenggajian();
    } catch (error) {
        console.error('Gagal fetch penggajian:', error);
    }
}

function renderPenggajian() {
    let tbody = document.querySelector('#table-penggajian tbody');
    tbody.innerHTML = '';
    if (penggajianList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center p-4">Tidak ada data.</td></tr>';
        return;
    }
    penggajianList.forEach(p => {
        tbody.innerHTML += `
            <tr>
                <td class="border px-2 py-1 text-center">${p.id_anggota}</td>
                <td class="border px-2 py-1 text-center">${p.gelar_depan ?? ''}</td>
                <td class="border px-2 py-1 text-center">${p.nama_depan ?? ''}</td>
                <td class="border px-2 py-1 text-center">${p.nama_belakang ?? ''}</td>
                <td class="border px-2 py-1 text-center">${p.gelar_belakang ?? ''}</td>
                <td class="border px-2 py-1 text-center">${p.jabatan}</td>
                <td class="border px-2 py-1 font-bold">${formatRupiah(p.take_home_pay)}</td>
                <td class="border px-2 py-1 text-center">
                <button onclick="showDetail('${p.id_anggota}')" class="px-2 py-1 bg-blue-600 rounded text-white text-sm">Detail</button>
                </td>
            </tr>
        `;
    });
}

async function showDetail(id_anggota) {
    try {
        let res = await fetch(`/api/penggajian/${id_anggota}`);
        if (!res.ok) {
            // Jika crash, tampilkan notifikasi, bukan alert
            throw new Error('Gagal memuat detail, server mengalami error.');
        }
        
        let data = await res.json();

        let detailContent = document.getElementById('detail-content');
        
        // Memastikan data.komponen ada sebelum di-map
        let komponenHtml = (data.komponen || []).map(k => `
            <li>${k.nama_komponen}: ${formatRupiah(k.nominal)}</li>
        `).join('');

        // Menambahkan `?? 0` untuk mencegah error jika data tidak ada
        detailContent.innerHTML = `
            <p><strong>ID Anggota:</strong> ${data.anggota.id_anggota}</p>
            <p><strong>Nama Lengkap:</strong> ${data.anggota.gelar_depan || ''} ${data.anggota.nama_depan} ${data.anggota.nama_belakang || ''} ${data.anggota.gelar_belakang || ''}</p>
            <p><strong>Jabatan:</strong> ${data.anggota.jabatan}</p>
            <hr class="my-2 dark:border-gray-600">
            <p><strong>Rincian Komponen Gaji:</strong></p>
            <ul class="list-disc list-inside pl-5">${komponenHtml}</ul>
            <hr class="my-2 dark:border-gray-600">
            <p class="font-bold"><strong>Take Home Pay:</strong> ${formatRupiah(data.take_home_pay)}</p>
        `;

        document.getElementById('modal-detail').classList.remove('hidden');
    } catch (error) {
        showNotif(error.message, 'red');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchPenggajian();

    // Search
    const searchInput = document.getElementById('search-penggajian');
    const searchButton = document.getElementById('search-button');
    function performSearch() {
        fetchPenggajian(searchInput.value);
    }
    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') performSearch();
    });

    // Modal detail close
    document.getElementById('close-modal-detail').onclick = () => document.getElementById('modal-detail').classList.add('hidden');
});