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



// Init
window.addEventListener('DOMContentLoaded', fetchKomponenGaji);
