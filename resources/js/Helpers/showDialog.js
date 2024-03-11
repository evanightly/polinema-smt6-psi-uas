import Swal from 'sweetalert2';

const DEFAULT_CONFIRM_OPTIONS = {
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
};

const DEFAULT_SUCCESS_OPTIONS = {
    title: 'Success',
    text: 'Operation completed successfully',
    icon: 'success',
};

const DEFAULT_ERROR_OPTIONS = {
    title: 'Error',
    text: 'An error occurred',
    icon: 'error',
};

const DEFAULT_DECLINED_OPTIONS = {
    title: 'Declined',
    text: 'Operation declined',
    icon: 'info',
};

export async function showDialog(options, defaultOptions) {
    return await Swal.fire({ ...defaultOptions, ...options });
}

export const showConfirmDialog = (options = {}) => showDialog(options, DEFAULT_CONFIRM_OPTIONS);
export const showSuccessDialog = (options = {}) => showDialog(options, DEFAULT_SUCCESS_OPTIONS);
export const showErrorDialog = (options = {}) => showDialog(options, DEFAULT_ERROR_OPTIONS);
export const showDeclinedDialog = (options = {}) => showDialog(options, DEFAULT_DECLINED_OPTIONS);
