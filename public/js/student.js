let students = [];

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

// Modal logic
const modal = document.getElementById('modal-student');
document.getElementById('open-modal-btn').onclick = () => modal.classList.remove('hidden');
document.getElementById('close-modal-btn').onclick = () => modal.classList.add('hidden');

// Fetch all students saat halaman load
async function fetchStudents() {
    let res = await fetch('/api/students-all');
    students = await res.json();
    renderStudents();
}

// Render table mahasiswa
function renderStudents() {
    let tbody = document.querySelector('#table-students tbody');
    tbody.innerHTML = '';
    students.forEach((student, idx) => {
        tbody.innerHTML += `
        <tr>
            <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${student.user.username}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${student.user.full_name}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${student.user.email}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${student.entry_year}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">
                <button onclick="showEditModal(${student.student_id})" class="px-2 py-1 bg-yellow-500 rounded text-white">Update</button>
                <button onclick="deleteStudent(${student.student_id}, '${student.user.username.replace(/'/g, "\\'")}')" class="px-2 py-1 bg-red-600 rounded text-white">Delete</button>
            </td>
        </tr>
        `;
    });
}

function validateStudentForm(form, mode = "create") {
    let valid = true;

    // Reset error
    form.querySelectorAll("input").forEach(input => {
        input.classList.remove("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        let err = input.nextElementSibling;
        if (err && err.classList.contains("text-red-500")) err.remove();
    });

    // --- Username ---
    let username = form.username?.value.trim() || "";
    if (username.length < 3 || username.length > 15) {
        valid = false;
        form.username.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.username.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Username harus 3-15 karakter</div>`);
    } else {
        // Cek unik (kecuali diri sendiri kalau update)
        let currentId = form["student_id"]?.value || null;
        let isDuplicate = students.some(s =>
            s.user.username.toLowerCase() === username.toLowerCase() &&
            s.student_id != currentId
        );
        if (isDuplicate) {
            valid = false;
            form.username.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
            form.username.insertAdjacentHTML("afterend",
                `<div class="text-red-500 text-xs mt-1">Username sudah dipakai</div>`);
        }
    }

    // --- Full Name ---
    let fullName = form.full_name?.value.trim() || "";
    if (fullName.length < 3 || fullName.length > 100) {
        valid = false;
        form.full_name.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.full_name.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Full name harus 3-100 karakter</div>`);
    }

    // --- Email ---
    let email = form.email?.value.trim() || "";
    let emailRegex = /^[^@]+@[^@]+\.[^@]+$/;
    if (!emailRegex.test(email) || email.length > 255) {
        valid = false;
        form.email.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.email.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Email tidak valid / terlalu panjang</div>`);
    } else {
        let currentId = form["student_id"]?.value || null;
        let isDuplicate = students.some(s =>
            s.user.email.toLowerCase() === email.toLowerCase() &&
            s.student_id != currentId
        );
        if (isDuplicate) {
            valid = false;
            form.email.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
            form.email.insertAdjacentHTML("afterend",
                `<div class="text-red-500 text-xs mt-1">Email sudah dipakai</div>`);
        }
    }

    // --- Password ---
    let password = form.password?.value || "";
    if (mode === "create") {
        if (password.length < 6) {
            valid = false;
            form.password.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
            form.password.insertAdjacentHTML("afterend",
                `<div class="text-red-500 text-xs mt-1">Password minimal 6 karakter</div>`);
        }
    } else if (mode === "edit") {
        if (password.length > 0 && password.length < 6) {
            valid = false;
            form.password.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
            form.password.insertAdjacentHTML("afterend",
                `<div class="text-red-500 text-xs mt-1">Password minimal 6 karakter (jika diisi)</div>`);
        }
    }

    // --- Entry Year ---
    let entryYear = form.entry_year?.value.trim() || "";
    if (!/^\d{4}$/.test(entryYear)) {
        valid = false;
        form.entry_year.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.entry_year.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Entry year harus 4 digit</div>`);
    }

    return valid;
}


// Tambah mahasiswa (AJAX)
document.getElementById('form-student').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateStudentForm(this, "create")) return;
    let formData = new FormData(this);

    let saveBtn = this.querySelector('button[type="submit"]');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    let response = await fetch('/dashboard-admin/kelola-mahasiswa', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    });

    saveBtn.disabled = false;
    saveBtn.textContent = 'Save';

    if (response.ok) {
        let student = await response.json();
        students.push(student);
        renderStudents();
        this.reset();
        modal.classList.add('hidden');
        showNotif('Student added successfully!', 'green');
    } else {
        let errorText = await response.text();
        alert('Gagal menambah mahasiswa:\n' + errorText);
        showNotif('Failed to add student!', 'red');
        console.error(errorText);
    }
});

// Hapus mahasiswa (AJAX)
window.deleteStudent = async function(studentId, username) {
    if (!confirm(`Yakin ingin menghapus ${username} dari mahasiswa?`)) return;
    let token = document.querySelector('input[name="_token"]').value;
    let res = await fetch(`/dashboard-admin/kelola-mahasiswa/${studentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    });
    if (res.ok) {
        students = students.filter(s => s.student_id !== studentId);
        renderStudents();
        showNotif(`Mahasiswa ${fullName} berhasil dihapus!`, 'green');
    } else {
        showNotif(`Gagal menghapus ${fullName}!`, 'red');
    }
}

// Modal Edit logic
const modalEdit = document.getElementById('modal-edit-student');
document.getElementById('close-edit-modal-btn').onclick = () => modalEdit.classList.add('hidden');

window.showEditModal = function(studentId) {
    const student = students.find(s => s.student_id === studentId);
    if (!student) return;
    document.getElementById('edit-student-id').value = student.student_id;
    document.getElementById('edit-username').value = student.user.username;
    document.getElementById('edit-full_name').value = student.user.full_name;
    document.getElementById('edit-email').value = student.user.email;
    document.getElementById('edit-entry_year').value = student.entry_year;
    document.getElementById('edit-password').value = '';
    modalEdit.classList.remove('hidden');
};

// Update mahasiswa (AJAX)
document.getElementById('form-edit-student').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateStudentForm(this, "edit")) return;
    let studentId = document.getElementById('edit-student-id').value;
    let formData = new FormData(this);

    formData.append('_method', 'PUT');

    let token = document.querySelector('input[name="_token"]').value;
    let updateBtn = this.querySelector('button[type="submit"]');
    updateBtn.disabled = true;
    let oldText = updateBtn.textContent;
    updateBtn.textContent = 'Updating...';

    let response = await fetch(`/dashboard-admin/kelola-mahasiswa/${studentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    });

    updateBtn.disabled = false;
    updateBtn.textContent = oldText;

    if (response.ok) {
        let updated = await response.json();
        let idx = students.findIndex(s => s.student_id == studentId);
        if (idx !== -1) students[idx] = updated;
        renderStudents();
        modalEdit.classList.add('hidden');
        showNotif('Student updated successfully!', 'green');
    } else {
        let error = await response.text();
        alert('Gagal update mahasiswa:\n' + error);
        showNotif('Failed to update student!', 'red');
    }
});

// Inisialisasi
window.addEventListener('DOMContentLoaded', fetchStudents);