

export function showNotif(msg, color = 'green') {
    let notif = document.createElement('div');
    notif.textContent = msg;
    let bgClass = 'bg-green-600';
    if (color === 'red') bgClass = 'bg-red-600';
    notif.className = `fixed top-5 right-5 z-[9999] px-4 py-2 rounded shadow text-white ${bgClass}`;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
}