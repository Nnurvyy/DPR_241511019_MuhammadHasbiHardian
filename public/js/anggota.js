let anggotaList = [];

// Notifikasi sederhana
function showNotif(msg, color = 'green') {
    console.log('showNotif called:', msg, color); 
    let notif = document.createElement('div');
    notif.textContent = msg;
    notif.style.zIndex = "9999";
    console.log('showNotif called:', msg, color);
    let bgClass = 'bg-green-600';
    if (color === 'red') bgClass = 'bg-red-600';
    if (color === 'yellow') bgClass = 'bg-yellow-500';
    notif.className = `fixed top-5 right-5 z-50 px-4 py-2 rounded shadow text-white ${bgClass}`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
}

// Modal create
const modalCreate = document.getElementById('modal-anggota');
document.getElementById('open-modal-btn').onclick = () => modalCreate.classList.remove('hidden');
document.getElementById('close-modal-btn').onclick = () => modalCreate.classList.add('hidden');

// Fetch data anggota
async function fetchAnggota() {
    let res = await fetch('/api/anggota-all'); // API baru
    anggotaList = await res.json();
    renderAnggota();
}

// Render tabel anggota
function renderAnggota() {
    let tbody = document.querySelector('#table-anggota tbody');
    tbody.innerHTML = '';
    anggotaList.forEach((a, idx) => {
        tbody.innerHTML += `
        <tr>
            <td class="border px-2 py-1 text-center">${idx + 1}</td>
            <td class="border px-2 py-1 text-center">${a.id_anggota}</td>
            <td class="border px-2 py-1 text-center">${a.nama_depan}</td>
            <td class="border px-2 py-1 text-center">${a.nama_belakang}</td>
            <td class="border px-2 py-1 text-center">${a.gelar_depan ?? '-'}</td>
            <td class="border px-2 py-1 text-center">${a.gelar_belakang ?? '-'}</td>
            <td class="border px-2 py-1 text-center">${a.jabatan}</td>
            <td class="border px-2 py-1 text-center">${a.status_pernikahan}</td>
            <td class="border px-2 py-1 text-center">${a.jumlah_anak}</td>
            <td class="border px-2 py-1 text-center">
                <button onclick="showEditModal(${a.id_anggota})" class="px-2 py-1 bg-yellow-500 rounded text-white">Update</button>
                <button onclick="deleteAnggota(${a.id_anggota}, '${a.nama_depan} ${a.nama_belakang}')" class="px-2 py-1 bg-red-600 rounded text-white">Delete</button>
            </td>
        </tr>`;
    });
}

// Tambah anggota
document.getElementById('form-anggota').addEventListener('submit', async function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    let saveBtn = this.querySelector('button[type="submit"]');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    let res = await fetch('/dashboard-admin/kelola-anggota', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    });

    saveBtn.disabled = false;
    saveBtn.textContent = 'Save';

    if (res.ok) {
        let data = await res.json();
        anggotaList.push(data);
        renderAnggota();
        this.reset();
        modalCreate.classList.add('hidden');
        showNotif('Anggota berhasil ditambahkan!');
    } else {
        let errorText = await res.text();
        alert('Gagal menambah mahasiswa:\n' + errorText);
        console.error(errorText);
        showNotif('Gagal menambah anggota!', 'red');
    }
});


// Init
window.addEventListener('DOMContentLoaded', fetchAnggota);
