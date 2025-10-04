
let anggotaList = [];
let komponenGajiList = [];
let penggajianList = [];


function formatRupiah(number) {
    // Memberikan nilai default 0 jika angka tidak valid
    const num = number || 0;
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, // Menghilangkan angka desimal ,00
        maximumFractionDigits: 0
    }).format(num);
}

// Fungsi Notifikasi
function showNotif(msg, color = 'green') {
    let notif = document.createElement('div');
    notif.textContent = msg;
    let bgClass = 'bg-green-600';
    if (color === 'red') bgClass = 'bg-red-600';
    notif.className = `fixed top-5 right-5 z-[9999] px-4 py-2 rounded shadow text-white ${bgClass}`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
}


// Fetch data dari API
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

// Render tabel utama
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
                    <button onclick="showEditModal('${p.id_anggota}')"  class="px-2 py-1 bg-yellow-500 rounded text-white">Edit</button>
                </td>
            </tr>
        `;
    });
}

function resetPenggajianValidationStyles(form) {
    form.querySelectorAll("select").forEach(input => {
        input.classList.remove("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        let err = input.nextElementSibling;
        if (err && err.classList.contains("text-red-500")) err.remove();
    });
}

function validatePenggajianForm(form) {
    let isValid = true;
    resetPenggajianValidationStyles(form);
    function showError(inputElement, message) {
        isValid = false;
        inputElement.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        const errorDiv = `<div class="text-red-500 text-xs mt-1">${message}</div>`;
        inputElement.parentElement.insertAdjacentHTML('beforeend', errorDiv);
    }

    if (!form.id_anggota.value) {
        showError(form.id_anggota, "Anggota harus dipilih.");
    }
    if (!form.id_komponen_gaji.value) {
        showError(form.id_komponen_gaji, "Komponen Gaji harus dipilih.");
    }
    return isValid;
}

// Tambah komponen gaji (form di modal)
function showAddKomponenForm(id_anggota, anggotaData, existingKomponenIds) {
    let select = `<select id="add-komponen-select" class="border rounded px-2 py-1 dark:text-black">`;
    let hasOptions = false;

    komponenGajiList.forEach(k => {
        const isJabatanMatch = (k.jabatan === 'Semua' || k.jabatan === anggotaData.jabatan);
        const isNotExisting = !existingKomponenIds.includes(String(k.id_komponen_gaji));
        let isAllowed = true;
        if (k.nama_komponen === 'Tunjangan Istri/Suami' && anggotaData.status_pernikahan !== 'Kawin') isAllowed = false;
        if (k.nama_komponen === 'Tunjangan Anak' && anggotaData.jumlah_anak < 1) isAllowed = false;

        if (isJabatanMatch && isNotExisting && isAllowed) {
            select += `<option value="${k.id_komponen_gaji}">${k.nama_komponen} (Rp ${k.nominal.toLocaleString('id-ID')})</option>`;
            hasOptions = true;
        }
    });
    select += `</select>`;

    if (hasOptions) {
        document.getElementById('add-komponen-form').innerHTML = `
            <div class="flex items-center gap-2 mt-2">
                ${select}
                <button id="submit-add-komponen" class="px-2 py-1 bg-blue-600 text-white rounded">Tambah</button>
            </div>
        `;
        document.getElementById('submit-add-komponen').onclick = async function() {
            let id_komponen_gaji = document.getElementById('add-komponen-select').value;
            try {
                let formData = new FormData();
                formData.append('id_anggota', id_anggota);
                formData.append('id_komponen_gaji', id_komponen_gaji);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                let res = await fetch('/dashboard-admin/kelola-penggajian', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': formData.get('_token'), 'Accept': 'application/json' },
                    body: formData
                });
                if (!res.ok) throw new Error('Gagal menambah komponen');
                showNotif('Komponen gaji berhasil ditambahkan!');
                showEditModal(id_anggota);
                fetchPenggajian();
            } catch (error) {
                showNotif(error.message, 'red');
            }
        };
    } else {
        document.getElementById('add-komponen-form').innerHTML = `<div class="text-gray-500 mt-2">Tidak ada komponen gaji yang bisa ditambahkan.</div>`;
    }
    document.getElementById('add-komponen-form').classList.remove('hidden');
}



// Tampilkan modal edit penggajian untuk anggota tertentu
window.showEditModal = async function(id_anggota) {
    try {
        let res = await fetch(`/api/penggajian/${id_anggota}`);
        if (!res.ok) throw new Error('Gagal memuat detail untuk diedit');
        
        let data = await res.json();

        document.getElementById('edit-header').innerHTML = `
            <p><strong>ID Anggota:</strong> ${data.anggota.id_anggota}</p>
            <p><strong>Nama Lengkap:</strong> ${data.anggota.gelar_depan || ''} ${data.anggota.nama_depan} ${data.anggota.nama_belakang || ''} ${data.anggota.gelar_belakang || ''}</p>
            <p><strong>Jabatan:</strong> ${data.anggota.jabatan}</p>
        `;

        let komponenHtml = data.komponen.map(k => {
            const escapedNama = String(k.nama_komponen).replace(/'/g, "\\'");

            return `
                <li class="flex items-center justify-between border-b py-1 dark:border-gray-600">
                    <span>${k.nama_komponen}: ${formatRupiah(k.nominal)}</span>
                    <span>
                        <button onclick="deleteKomponenGaji('${id_anggota}', '${k.id_komponen_gaji}', '${escapedNama}')" class="px-2 py-1 bg-red-600 rounded text-white text-xs">Hapus</button>
                    </span>
                </li>
            `;
        }).join('');
        
        document.getElementById('edit-komponen-list').innerHTML = `<ul>${komponenHtml || '<li class="text-gray-500">Belum ada komponen.</li>'}</ul>`;
        
        document.getElementById('edit-take-home-pay').innerHTML = `<strong>Take Home Pay:</strong> ${formatRupiah(data.take_home_pay)}`;
        document.getElementById('add-komponen-form').classList.add('hidden');
        document.getElementById('modal-edit').classList.remove('hidden');

        document.getElementById('add-komponen-btn').onclick = () => {
            const anggotaData = data.anggota; // Kirim seluruh objek anggota
            const existingKomponenIds = data.komponen.map(k => String(k.id_komponen_gaji));
            
            showAddKomponenForm(id_anggota, anggotaData, existingKomponenIds);
        };
        
    } catch (error) {
        showNotif(error.message, 'red');
    }
};

window.editKomponenGaji = function(id_anggota, id_komponen_gaji) {
    const komponen = komponenGajiList.find(k => String(k.id_komponen_gaji) === String(id_komponen_gaji));
    if (!komponen) return;
    const nominalBaru = prompt(`Edit nominal untuk ${komponen.nama_komponen}:`, komponen.nominal);
    if (nominalBaru === null) return; // Cancel

    fetch(`/api/penggajian/${id_anggota}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            id_komponen_gaji: id_komponen_gaji,
            nominal: nominalBaru
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showNotif('Nominal komponen gaji berhasil diupdate!');
            showEditModal(id_anggota);
            fetchPenggajian();
        } else {
            showNotif('Gagal update komponen gaji!', 'red');
        }
    })
    .catch(() => showNotif('Gagal update komponen gaji!', 'red'));
};




// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Tombol dan event modal
    const modalPenggajian = document.getElementById('modal-penggajian');
    const openModalBtn = document.getElementById('open-modal-penggajian');
    const closeModalBtn = document.getElementById('close-modal-penggajian');
    const formPenggajian = document.getElementById('form-penggajian');
    
    openModalBtn.addEventListener('click', () => modalPenggajian.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => modalPenggajian.classList.add('hidden'));

    const modalDetail = document.getElementById('modal-detail');
    const closeModalDetailBtn = document.getElementById('close-modal-detail');
    closeModalDetailBtn.addEventListener('click', () => modalDetail.classList.add('hidden'));


    const searchInput = document.getElementById('search-penggajian');
    const searchButton = document.getElementById('search-button');

    // Fungsi untuk menjalankan pencarian
    function performSearch() {
        const query = searchInput.value;
        fetchPenggajian(query);
    }

    // 1. Jalankan pencarian saat tombol "Cari" diklik
    searchButton.addEventListener('click', performSearch);

    // 2. Jalankan pencarian saat menekan "Enter" di kolom input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // AKHIR BAGIAN PENCARIAN


    // Event listener untuk filter komponen gaji di modal 
    document.getElementById('id_anggota').addEventListener('change', async function() {
        if (!this.value) {
            document.getElementById('id_komponen_gaji').innerHTML = '';
            return;
        }
        
        const res = await fetch(`/api/penggajian/${this.value}`);
        const detailAnggota = await res.json();
        const existingKomponenIds = detailAnggota.komponen.map(k => String(k.id_komponen_gaji));
        
        let anggota = anggotaList.find(a => String(a.id_anggota) === String(this.value));
        let selectKomponen = document.getElementById('id_komponen_gaji');
        selectKomponen.innerHTML = '';

        komponenGajiList.forEach(k => {
            if (k.jabatan === 'Semua' || k.jabatan === anggota.jabatan) {
                if (!existingKomponenIds.includes(String(k.id_komponen_gaji))) {
                    let opt = document.createElement('option');
                    opt.value = k.id_komponen_gaji;
                    opt.textContent = `${k.nama_komponen} (Rp ${k.nominal.toLocaleString('id-ID')})`;
                    selectKomponen.appendChild(opt);
                }
            }
        });
    });

    // Event listener untuk submit form tambah 
    formPenggajian.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!validatePenggajianForm(this)) return;
        let formData = new FormData(this);
        const csrfToken = formData.get('_token');

        if (!formData.get('id_anggota') || !formData.get('id_komponen_gaji')) {
            showNotif('Pilih anggota dan komponen gaji!', 'red');
            return;
        }
        
        try {
            let res = await fetch('/dashboard-admin/kelola-penggajian', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData
            });

            if (res.status === 422) {
                let errorData = await res.json();
                throw new Error(errorData.message);
            }
            if (!res.ok) {
                throw new Error('Terjadi kesalahan saat menyimpan data.');
            }
            
            showNotif('Komponen gaji berhasil ditambahkan!');
            formPenggajian.reset();
            modalPenggajian.classList.add('hidden');
            fetchPenggajian(); 

        } catch (error) {
            showNotif(error.message, 'red');
        }
    });

    // Inisialisasi data saat halaman dimuat
    fetchAnggota();
    fetchKomponenGaji();
    fetchPenggajian();
});