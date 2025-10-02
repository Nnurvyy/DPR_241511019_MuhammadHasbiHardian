let courses = [];
let enrolledCourseIds = []; // course_id yang sudah di-enroll user

// Fetch all courses & enrolled status
async function fetchCourses() {
    let res = await fetch('/api/all-courses-user');
    let data = await res.json();
    courses = data.courses;
    enrolledCourseIds = data.enrolled; // array of course_id
    renderCourses();
}

function renderCourses() {
    let tbody = document.querySelector('#table-courses tbody');
    tbody.innerHTML = '';
    courses.forEach((course, idx) => {
        let enrolled = enrolledCourseIds.includes(course.course_id);
        tbody.innerHTML += `
        <tr>
            <td class="border px-2 py-1 text-center">${idx + 1}</td>
            <td class="border px-2 py-1 text-center">${course.course_name}</td>
            <td class="border px-2 py-1 text-center">${course.credits}</td>
            <td class="border px-2 py-1 text-center">${enrolled ? 'Enrolled' : 'Available'}</td>
            <td class="border px-2 py-1 text-center">
                ${enrolled 
                    ? '' 
                    : `<input type="checkbox" class="enroll-checkbox" 
                            value="${course.course_id}" 
                            data-credits="${course.credits}">`}
            </td>
        </tr>
        `;
    });

    document.querySelectorAll('.enroll-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotalCredits);
    });

    // Reset total credits tiap kali render ulang
    updateTotalCredits();
}

// Submit enroll
document.getElementById('submit-enroll').onclick = async function() {
    let checked = Array.from(document.querySelectorAll('.enroll-checkbox:checked'))
        .map(cb => cb.value);

    if (checked.length === 0) {
        showNotif('Pilih minimal 1 course untuk enroll!', 'yellow');
        return;
    }

    let token = document.querySelector('input[name="_token"]')?.value;
    let res = await fetch('/mahasiswa/enroll-courses', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ course_ids: checked })
    });
    if (res.ok) {
        let result = await res.json();
        enrolledCourseIds = result.enrolled; // update enrolled dari response
        renderCourses();
        showNotif('Berhasil enroll course!', 'green');
    } else {
        let err = await res.text();
        console.error('Error response:', err);
        showNotif('Gagal enroll course!', 'red');
    }
}

function updateTotalCredits() {
    let checked = Array.from(document.querySelectorAll('.enroll-checkbox:checked'));
    let totalCredits = checked.reduce((sum, cb) => sum + parseInt(cb.dataset.credits), 0);
    document.getElementById('total-credits').textContent = `Total SKS dipilih: ${totalCredits}`;
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