import Swal from 'sweetalert2';

export function showAlert(title, message, type = 'info') {
    Swal.fire({
        title: title,
        text: message,
        icon: type,
        toast: true,
        position: 'top-end',
    });
}
