import Swal from 'sweetalert2';

export function showAlert(title, message, type = 'info', showConfirmButton = true, timer = 2000) {
    Swal.fire({
        title: title,
        text: message,
        icon: type,
        toast: true,
        position: 'top-end',
        showConfirmButton,
        timer,
        timerProgressBar: true,
    });
}
