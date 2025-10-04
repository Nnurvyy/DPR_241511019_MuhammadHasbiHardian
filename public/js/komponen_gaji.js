let komponenGajiList = [];

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
const modalCreate = document.getElementById('modal-komponen-gaji');
document.getElementById('open-modal-btn').onclick = () => modalCreate.classList.remove('hidden');
document.getElementById('close-modal-btn').onclick = () => modalCreate.classList.add('hidden');

// Fetch data komponen gaji
async function fetchKomponenGaji() {
    let res = await fetch('/api/komponen-gaji-all'); // API baru
    komponenGajiList = await res.json();
    renderKomponenGaji();
}

// Render tabel komponen gaji
function renderKomponenGaji() {
    let tbody = document.querySelector('#table-komponen-gaji tbody');
    tbody.innerHTML = '';
    komponenGajiList.forEach((a, idx) => {
        tbody.innerHTML += `
        <tr>
            <td class="border px-2 py-1 text-center">${idx + 1}</td>
            <td class="border px-2 py-1 text-center">${a.id_komponen_gaji}</td>
            <td class="border px-2 py-1 text-center">${a.nama_komponen}</td>
            <td class="border px-2 py-1 text-center">${a.kategori ?? '-'}</td>
            <td class="border px-2 py-1 text-center">${a.jabatan ?? '-'}</td>
            <td class="border px-2 py-1 text-center">${a.nominal}</td>
            <td class="border px-2 py-1 text-center">${a.satuan}</td>
            <td class="border px-2 py-1 text-center">
                <button onclick="showEditModal(${a.id_komponen_gaji})" class="px-2 py-1 bg-yellow-500 rounded text-white">Update</button>
                <button onclick="deleteKomponenGaji(${a.id_komponen_gaji}, '${a.nama_komponen}')" class="px-2 py-1 bg-red-600 rounded text-white">Delete</button>
            </td>
        </tr>`;
    });
}

// Tambah komponen gaji
document.getElementById('form-komponen-gaji').addEventListener('submit', async function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    let saveBtn = this.querySelector('button[type="submit"]');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    let res = await fetch('/dashboard-admin/kelola-komponen-gaji', {
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
        komponenGajiList.push(data);
        renderKomponenGaji();
        this.reset();
        modalCreate.classList.add('hidden');
        showNotif('Komponen gaji berhasil ditambahkan!');
    } else {
        let errorText = await res.text();
        alert('Gagal menambah komponen gaji:\n' + errorText);
        console.error(errorText);
        showNotif('Gagal menambah komponen gaji!', 'red');
    }
});

// Modal edit
const modalEdit = document.getElementById('modal-edit-komponen-gaji');
document.getElementById('close-edit-modal-btn').onclick = () => modalEdit.classList.add('hidden');

window.showEditModal = function(id_komponen_gaji) {
    let a = komponenGajiList.find(x => String(x.id_komponen_gaji) === String(id_komponen_gaji));
    if (!a) return;

    document.getElementById('edit-komponen_gaji_id').value = a.id_komponen_gaji;

    // isi input yang bisa diedit
    document.getElementById('edit-id_komponen_gaji').value = a.id_komponen_gaji;
    document.getElementById('edit-nama_komponen').value = a.nama_komponen;
    document.getElementById('edit-kategori').value = a.kategori;
    document.getElementById('edit-jabatan').value = a.jabatan;
    document.getElementById('edit-nominal').value = a.nominal;
    document.getElementById('edit-satuan').value = a.satuan;
    modalEdit.classList.remove('hidden');
};

// Update komponen gaji
document.getElementById('form-edit-komponen-gaji').addEventListener('submit', async function(e) {
    e.preventDefault();
    let old_id = document.getElementById('edit-komponen_gaji_id').value; // ID lama
    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    let token = document.querySelector('input[name="_token"]').value;
    let updateBtn = this.querySelector('button[type="submit"]');
    updateBtn.disabled = true;
    let oldText = updateBtn.textContent;
    updateBtn.textContent = 'Updating...';

    let res = await fetch(`/dashboard-admin/kelola-komponen-gaji/${old_id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: formData
    });

    updateBtn.disabled = false;
    updateBtn.textContent = oldText;

    if (res.ok) {
        let updated = await res.json();
        let idx = komponenGajiList.findIndex(x => String(x.id_komponen_gaji) === String(old_id));
        if (idx !== -1) komponenGajiList[idx] = updated;
        renderKomponenGaji();
        modalEdit.classList.add('hidden');
        showNotif('Data komponen gaji diperbarui!');
    } else {
        let errorText = await res.text();
        alert('Gagal menambah komponen gaji:\n' + errorText);
        console.error(errorText);
        showNotif('Gagal menambah komponen gaji!', 'red');
    }
});

// Hapus komponen gaji
window.deleteKomponenGaji = async function(id_komponen_gaji, nama) {
    if (!confirm(`Hapus komponen gaji ${nama}?`)) return;
    let token = document.querySelector('input[name="_token"]').value;
    let res = await fetch(`/dashboard-admin/kelola-komponen-gaji/${id_komponen_gaji}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    });
    if (res.ok) {
        komponenGajiList = komponenGajiList.filter(a => String(a.id_komponen_gaji) !== String(id_komponen_gaji));
        renderKomponenGaji();
        showNotif(`Komponen gaji ${nama} dihapus!`);
    } else {
        showNotif(`Gagal hapus komponen gaji ${nama}!`, 'red');
    }
};

// Init
window.addEventListener('DOMContentLoaded', fetchKomponenGaji);
