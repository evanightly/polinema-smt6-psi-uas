export default function debouncePromise(fn, delay) {
    let timeoutID;
    return function (...args) {
        if (timeoutID) {
            clearTimeout(timeoutID);
        }
        return new Promise(resolve => {
            timeoutID = setTimeout(() => resolve(fn(...args)), delay);
        });
    };
}
