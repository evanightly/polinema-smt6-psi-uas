export default function validateNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
