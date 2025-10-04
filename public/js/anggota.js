import { showNotif } from './helper.js';

let anggotaList = [];


async function fetchAnggota(q = '') {
    const url = '/api/anggota-all' + (q ? `?q=${encodeURIComponent(q)}` : '');
    try {
        let res = await fetch(url);
        if (!res.ok) throw new Error('Gagal mengambil data dari server');
        anggotaList = await res.json();
        renderAnggota();
    } catch (error) {
        console.error("Gagal mengambil data anggota:", error);
        showNotif('Gagal mengambil data anggota!', 'red');
    }
}

function renderAnggota() {
    const tbody = document.querySelector('#table-anggota tbody');
    tbody.innerHTML = '';
    if (anggotaList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center p-4">Data tidak ditemukan.</td></tr>';
        return;
    }
    anggotaList.forEach((a, idx) => {
        const escapedNama = String(a.nama_depan + ' ' + (a.nama_belakang || '')).replace(/'/g, "\\'");
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
                <td class="border px-2 py-1 text-center">
                    <button onclick="showEditModal(${a.id_anggota})" class="px-2 py-1 bg-yellow-500 rounded text-white text-sm">Update</button>
                    <button onclick="deleteAnggota(${a.id_anggota}, '${escapedNama}')" class="px-2 py-1 bg-red-600 rounded text-white text-sm">Delete</button>
                </td>
            </tr>`;
    });
}

function resetValidationStyles(form) {
    form.querySelectorAll("input, select").forEach(input => {
        input.classList.remove("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        let err = input.nextElementSibling;
        if (err && err.classList.contains("text-red-500")) {
            err.remove();
        }
    });
}

function validateAnggotaForm(form, mode = "create") {
    let isValid = true;
    function showError(inputElement, message) {
        isValid = false;
        inputElement.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        inputElement.insertAdjacentHTML("afterend", `<div class="text-red-500 text-xs mt-1">${message}</div>`);
    }

    // Validasi ID Anggota (Hanya di mode edit, karena di create ID dihilangkan)
    if (mode === 'edit') {
        const idAnggota = form.id_anggota.value.trim();
        if (!idAnggota) {
            showError(form.id_anggota, "ID Anggota tidak boleh kosong.");
        } else if (!/^\d+$/.test(idAnggota)) {
            showError(form.id_anggota, "ID Anggota harus berupa angka.");
        } else {
            const originalId = document.getElementById('edit-anggota-id').value;
            if (idAnggota !== originalId) {
                const isDuplicate = anggotaList.some(a => String(a.id_anggota) === idAnggota);
                if (isDuplicate) showError(form.id_anggota, "ID Anggota sudah digunakan.");
            }
        }
    }

    if (!form.nama_depan.value.trim()) showError(form.nama_depan, "Nama Depan tidak boleh kosong.");
    if (!form.jabatan.value) showError(form.jabatan, "Jabatan harus dipilih.");
    if (!form.status_pernikahan.value) showError(form.status_pernikahan, "Status Pernikahan harus dipilih.");
    const jumlahAnak = form.jumlah_anak.value.trim();
    if (jumlahAnak && (!/^\d+$/.test(jumlahAnak) || parseInt(jumlahAnak) < 0)) {
        showError(form.jumlah_anak, "Jumlah Anak harus berupa angka positif (0 atau lebih).");
    }

    return isValid;
}

window.showEditModal = function(id_anggota) {
    const form = document.getElementById('form-edit-anggota');
    resetValidationStyles(form); // Bersihkan error lama saat modal edit dibuka
    
    let a = anggotaList.find(x => String(x.id_anggota) === String(id_anggota));
    if (!a) return;

    form.querySelector('#edit-anggota-id').value = a.id_anggota;
    form.querySelector('#edit-id_anggota').value = a.id_anggota;
    form.querySelector('#edit-nama_depan').value = a.nama_depan;
    form.querySelector('#edit-nama_belakang').value = a.nama_belakang;
    form.querySelector('#edit-gelar_depan').value = a.gelar_depan;
    form.querySelector('#edit-gelar_belakang').value = a.gelar_belakang;
    form.querySelector('#edit-jabatan').value = a.jabatan;
    form.querySelector('#edit-status_pernikahan').value = a.status_pernikahan;
    form.querySelector('#edit-jumlah_anak').value = a.jumlah_anak;
    
    document.getElementById('modal-edit-anggota').classList.remove('hidden');
};

window.deleteAnggota = async function(id_anggota, nama) {
    if (!confirm(`Hapus anggota ${nama}?`)) return;
    let token = document.querySelector('input[name="_token"]').value;
    try {
        let res = await fetch(`/dashboard-admin/kelola-anggota/${id_anggota}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        });
        if (!res.ok) throw new Error('Gagal menghapus anggota');
        await fetchAnggota(); 
        showNotif(`Anggota ${nama} dihapus!`);
    } catch (error) {
        showNotif(error.message, 'red');
    }
};



// EVENT LISTENERS (Dijalankan setelah semua elemen HTML siap) ---
document.addEventListener('DOMContentLoaded', function() {
    const modalCreate = document.getElementById('modal-anggota');
    const modalEdit = document.getElementById('modal-edit-anggota');
    const searchInput = document.getElementById('search-anggota');
    const searchButton = document.getElementById('search-button-anggota');

    // Logika Pencarian 
    if (searchInput && searchButton) {
        function performSearch() { fetchAnggota(searchInput.value); }
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') performSearch(); });
    }

    // Event untuk Modal 
    document.getElementById('open-modal-btn').addEventListener('click', () => {
        const form = document.getElementById('form-anggota');
        form.reset();
        // Panggil fungsi untuk membersihkan error
        resetValidationStyles(form); 
        modalCreate.classList.remove('hidden');
    });
    document.getElementById('close-modal-btn').addEventListener('click', () => modalCreate.classList.add('hidden'));
    document.getElementById('close-edit-modal-btn').addEventListener('click', () => modalEdit.classList.add('hidden'));

    // Event untuk form Tambah 
    document.getElementById('form-anggota').addEventListener('submit', async function(e) {
        e.preventDefault();
        // Bersihkan error lama, lalu jalankan validasi baru
        resetValidationStyles(this);
        if (!validateAnggotaForm(this, "create")) return;
        
        const formData = new FormData(this);
        const saveBtn = this.querySelector('button[type="submit"]');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
        
        try {
            const res = await fetch('/dashboard-admin/kelola-anggota', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': formData.get('_token'), 'Accept': 'application/json' },
                body: formData
            });
            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Gagal menambah anggota');
            }
            await fetchAnggota();
            this.reset();
            modalCreate.classList.add('hidden');
            showNotif('Anggota berhasil ditambahkan!');
        } catch (error) {
            showNotif(error.message, 'red');
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save';
        }
    });

    // Event untuk form Edit 
    document.getElementById('form-edit-anggota').addEventListener('submit', async function(e) {
        e.preventDefault();
        // Bersihkan error lama, lalu jalankan validasi baru
        resetValidationStyles(this);
        if (!validateAnggotaForm(this, "edit")) return;
        
        const old_id = document.getElementById('edit-anggota-id').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        const token = document.querySelector('input[name="_token"]').value;
        const updateBtn = this.querySelector('button[type="submit"]');
        updateBtn.disabled = true;
        updateBtn.textContent = 'Updating...';

        try {
            const res = await fetch(`/dashboard-admin/kelola-anggota/${old_id}`, {
                method: 'POST', // Method POST untuk form-data dengan _method PUT
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            });
            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Update gagal');
            }
            await fetchAnggota();
            modalEdit.classList.add('hidden');
            showNotif('Data anggota diperbarui!');
        } catch(error) {
            showNotif(error.message, 'red');
        } finally {
            updateBtn.disabled = false;
            updateBtn.textContent = 'Update';
        }
    });

    // Memuat data awal saat halaman dibuka
    fetchAnggota();
});