let courses = [];

// Modal logic
const modalCourse = document.getElementById('modal-course');
document.getElementById('open-modal-course-btn').onclick = () => modalCourse.classList.remove('hidden');
document.getElementById('close-modal-course-btn').onclick = () => modalCourse.classList.add('hidden');

const modalEditCourse = document.getElementById('modal-edit-course');
document.getElementById('close-edit-course-modal-btn').onclick = () => modalEditCourse.classList.add('hidden');

// Fetch all courses saat halaman load
async function fetchCourses() {
    let res = await fetch('/api/courses-all');
    courses = await res.json();
    renderCourses();
}

// Render table courses
function renderCourses() {
    let tbody = document.querySelector('#table-courses tbody');
    tbody.innerHTML = '';
    courses.forEach((course, idx) => {
        tbody.innerHTML += `
        <tr>
            <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${course.course_name}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">${course.credits}</td>
            <td class="border border-gray-400 px-2 py-1 text-center">
                <button onclick="showEditCourseModal(${course.course_id})" class="px-2 py-1 bg-yellow-500 rounded text-white">Update</button>
                <button onclick="deleteCourse(${course.course_id}, '${course.course_name.replace(/'/g, "\\'")}')" class="px-2 py-1 bg-red-600 rounded text-white">Delete</button>
            </td>
        </tr>
        `;
    });
}

function validateCourseForm(form, mode = "create") {
    let valid = true;

    // Reset error
    form.querySelectorAll("input").forEach(input => {
        input.classList.remove("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        let err = input.nextElementSibling;
        if (err && err.classList.contains("text-red-500")) err.remove();
    });

    // --- Course Name ---
    let courseName = form.course_name?.value.trim() || "";
    if (courseName.length < 3 || courseName.length > 255) {
        valid = false;
        form.course_name.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.course_name.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Course name harus 3–255 karakter</div>`);
    } else {
        // cek unik (kecuali diri sendiri kalau update)
        let currentId = form["course_id"]?.value || null;
        let isDuplicate = courses.some(c =>
            c.course_name.toLowerCase() === courseName.toLowerCase() &&
            c.course_id != currentId
        );
        if (isDuplicate) {
            valid = false;
            form.course_name.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
            form.course_name.insertAdjacentHTML("afterend",
                `<div class="text-red-500 text-xs mt-1">Course name sudah ada</div>`);
        }
    }

    // --- Credits ---
    let credits = form.credits?.value.trim() || "";
    if (!/^\d+$/.test(credits) || credits < 1 || credits > 10) {
        valid = false;
        form.credits.classList.add("!border-red-500", "focus:!border-red-500", "focus:!ring-red-500");
        form.credits.insertAdjacentHTML("afterend",
            `<div class="text-red-500 text-xs mt-1">Credits harus angka 1–10</div>`);
    }

    return valid;
}


// Tambah course (AJAX)
document.getElementById('form-course').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateCourseForm(this, "create")) return;
    let formData = new FormData(this);

    let response = await fetch('/dashboard-admin/kelola-course', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    });

    if (response.ok) {
        let course = await response.json();
        courses.push(course);
        renderCourses();
        this.reset();
        modalCourse.classList.add('hidden');
        showNotif('Course added successfully!', 'green');
    } else {
        let errorText = await response.text();
        alert('Gagal menambah course:\n' + errorText);
        showNotif('Failed to add course!', 'red');
    }
});

// Modal Edit logic
window.showEditCourseModal = function(courseId) {
    const course = courses.find(c => c.course_id === courseId);
    if (!course) return;
    document.getElementById('edit-course-id').value = course.course_id;
    document.getElementById('edit-course_name').value = course.course_name;
    document.getElementById('edit-credits').value = course.credits;
    modalEditCourse.classList.remove('hidden');
};

// Update course (AJAX)
document.getElementById('form-edit-course').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateCourseForm(this, "edit")) return;
    let courseId = document.getElementById('edit-course-id').value;
    let formData = new FormData(this);
    formData.append('_method', 'PUT');
    let token = document.querySelector('input[name="_token"]').value;

    let updateBtn = this.querySelector('button[type="submit"]');
    updateBtn.disabled = true;
    let oldText = updateBtn.textContent;
    updateBtn.textContent = 'Updating...';

    let response = await fetch(`/dashboard-admin/kelola-course/${courseId}`, {
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
        let idx = courses.findIndex(c => c.course_id == courseId);
        if (idx !== -1) courses[idx] = updated;
        renderCourses();
        modalEditCourse.classList.add('hidden');
        showNotif('Course updated successfully!', 'green');
    } else {
        let error = await response.text();
        alert('Gagal update course:\n' + error);
        showNotif('Failed to update course!', 'red');
    }
});

// Delete course (AJAX)
window.deleteCourse = async function(courseId, courseName) {
    if (!confirm(`Yakin ingin menghapus ${courseName} dari course?`)) return;
    let token = document.querySelector('input[name="_token"]').value;
    let res = await fetch(`/dashboard-admin/kelola-course/${courseId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    });
    if (res.ok) {
        courses = courses.filter(c => c.course_id !== courseId);
        renderCourses();
        showNotif(`Course ${courseName} berhasil dihapus!`, 'green');
    } else {
        showNotif(`Gagal menghapus ${courseName}!`, 'red');
    }
}

// Notif helper
function showNotif(msg, color = 'green') {
    let notif = document.createElement('div');
    notif.textContent = msg;
    let bgClass = 'bg-green-600';
    if (color === 'red') bgClass = 'bg-red-600';
    if (color === 'yellow') bgClass = 'bg-yellow-500';
    notif.className = `fixed top-5 right-5 z-50 px-4 py-2 rounded shadow text-white ${bgClass}`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
}

// Inisialisasi
window.addEventListener('DOMContentLoaded', fetchCourses);