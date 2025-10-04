import { showNotif } from './helper.js';

let komponenGajiList = [];


async function fetchKomponenGaji(q = '') {
    const url = '/api/komponen-gaji-all' + (q ? `?q=${encodeURIComponent(q)}` : '');
    try {
        let res = await fetch(url);
        if (!res.ok) throw new Error('Gagal mengambil data dari server');
        komponenGajiList = await res.json();
        renderKomponenGaji();
    } catch (error) {
        console.error("Gagal mengambil data komponen gaji:", error);
        showNotif('Gagal mengambil data!', 'red');
    }
}

function renderKomponenGaji() {
    let tbody = document.querySelector('#table-komponen-gaji tbody');
    tbody.innerHTML = '';
    if (komponenGajiList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center p-4">Data tidak ditemukan.</td></tr>';
        return;
    }
    komponenGajiList.forEach((a, idx) => {
        const escapedNama = String(a.nama_komponen).replace(/'/g, "\\'");
        tbody.innerHTML += `
            <tr>
                <td class="border px-2 py-1 text-center">${idx + 1}</td>
                <td class="border px-2 py-1 text-center">${a.id_komponen_gaji}</td>
                <td class="border px-2 py-1 text-center">${a.nama_komponen}</td>
                <td class="border px-2 py-1 text-center">${a.kategori || '-'}</td>
                <td class="border px-2 py-1 text-center">${a.jabatan || '-'}</td>
                <td class="border px-2 py-1 text-center">Rp ${Number(a.nominal).toLocaleString('id-ID')}</td>
                <td class="border px-2 py-1 text-center">${a.satuan}</td>
                <td class="border px-2 py-1 text-center">
                    <button onclick="showEditModal(${a.id_komponen_gaji})" class="px-2 py-1 bg-yellow-500 rounded text-white text-sm">Update</button>
                    <button onclick="deleteKomponenGaji(${a.id_komponen_gaji}, '${escapedNama}')" class="px-2 py-1 bg-red-600 rounded text-white text-sm">Delete</button>
                </td>
            </tr>`;
    });
}

function resetValidationStyles(form) {
    form.querySelectorAll("input, select").forEach(input => {
        input.classList.remove("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        let err = input.nextElementSibling;
        if (err && err.classList.contains("text-red-500")) err.remove();
    });
}


function validateKomponenForm(form) {
    let isValid = true;
    function showError(inputElement, message) {
        isValid = false;
        inputElement.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        inputElement.insertAdjacentHTML("afterend", `<div class="text-red-500 text-xs mt-1">${message}</div>`);
    }

    // Validasi field
    if (!form.nama_komponen.value.trim()) showError(form.nama_komponen, "Nama Komponen tidak boleh kosong.");
    if (!form.kategori.value) showError(form.kategori, "Kategori harus dipilih.");
    if (!form.jabatan.value) showError(form.jabatan, "Jabatan harus dipilih.");
    if (!form.nominal.value.trim()) {
        showError(form.nominal, "Nominal tidak boleh kosong.");
    } else if (parseInt(form.nominal.value) < 0) {
        showError(form.nominal, "Nominal tidak boleh negatif.");
    }
    if (!form.satuan.value) showError(form.satuan, "Satuan harus dipilih.");

    return isValid;
}


window.showEditModal = function(id_komponen_gaji) {
    const form = document.getElementById('form-edit-komponen-gaji');
    resetValidationStyles(form);
    
    let a = komponenGajiList.find(x => String(x.id_komponen_gaji) === String(id_komponen_gaji));
    if (!a) return;

    form.querySelector('#edit-komponen_gaji_id').value = a.id_komponen_gaji;
    // form.querySelector('#edit-id_komponen_gaji').value = a.id_komponen_gaji; // ID Komponen tidak seharusnya bisa diedit
    form.querySelector('#edit-nama_komponen').value = a.nama_komponen;
    form.querySelector('#edit-kategori').value = a.kategori;
    form.querySelector('#edit-jabatan').value = a.jabatan;
    form.querySelector('#edit-nominal').value = a.nominal;
    form.querySelector('#edit-satuan').value = a.satuan;
    
    document.getElementById('modal-edit-komponen-gaji').classList.remove('hidden');
};



window.deleteKomponenGaji = async function(id_komponen_gaji, nama) {
    if (!confirm(`Hapus komponen gaji ${nama}?`)) return;
    const token = document.querySelector('input[name="_token"]').value;
    try {
        const res = await fetch(`/dashboard-admin/kelola-komponen-gaji/${id_komponen_gaji}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        });
        if (!res.ok) throw new Error('Gagal menghapus komponen');
        
        await fetchKomponenGaji();
        showNotif(`Komponen gaji ${nama} dihapus!`);
    } catch (error) {
        showNotif(error.message, 'red');
    }
};

// EVENT LISTENERS 

document.addEventListener('DOMContentLoaded', function() {
    const modalCreate = document.getElementById('modal-komponen-gaji');
    const modalEdit = document.getElementById('modal-edit-komponen-gaji');
    const searchInput = document.getElementById('search-komponen');
    const searchButton = document.getElementById('search-button-komponen');

    // Logika Pencarian
    if (searchInput && searchButton) {
        function performSearch() { fetchKomponenGaji(searchInput.value); }
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') performSearch(); });
    }

    // Event untuk Modal 
    document.getElementById('open-modal-btn').addEventListener('click', () => {
        const form = document.getElementById('form-komponen-gaji');
        form.reset();
        resetValidationStyles(form);
        modalCreate.classList.remove('hidden');
    });
    document.getElementById('close-modal-btn').addEventListener('click', () => modalCreate.classList.add('hidden'));
    document.getElementById('close-edit-modal-btn').addEventListener('click', () => modalEdit.classList.add('hidden'));

    // Event untuk form Tambah 
    document.getElementById('form-komponen-gaji').addEventListener('submit', async function(e) {
        e.preventDefault();
        resetValidationStyles(this);
        if (!validateKomponenForm(this)) return;
        
        const formData = new FormData(this);
        const saveBtn = this.querySelector('button[type="submit"]');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
        
        try {
            const res = await fetch('/dashboard-admin/kelola-komponen-gaji', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': formData.get('_token'), 'Accept': 'application/json' },
                body: formData
            });
            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Gagal menambah komponen');
            }
            await fetchKomponenGaji();
            this.reset();
            modalCreate.classList.add('hidden');
            showNotif('Komponen gaji berhasil ditambahkan!');
        } catch (error) {
            showNotif(error.message, 'red');
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save';
        }
    });

    // Event untuk form Edit 
    document.getElementById('form-edit-komponen-gaji').addEventListener('submit', async function(e) {
        e.preventDefault();
        resetValidationStyles(this);
        if (!validateKomponenForm(this)) return;
        
        const old_id = document.getElementById('edit-komponen_gaji_id').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        const token = document.querySelector('input[name="_token"]').value;
        const updateBtn = this.querySelector('button[type="submit"]');
        updateBtn.disabled = true;
        updateBtn.textContent = 'Updating...';

        try {
            const res = await fetch(`/dashboard-admin/kelola-komponen-gaji/${old_id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            });
            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Update gagal');
            }
            await fetchKomponenGaji();
            modalEdit.classList.add('hidden');
            showNotif('Data komponen gaji diperbarui!');
        } catch(error) {
            showNotif(error.message, 'red');
        } finally {
            updateBtn.disabled = false;
            updateBtn.textContent = 'Update';
        }
    });

    fetchKomponenGaji();
});