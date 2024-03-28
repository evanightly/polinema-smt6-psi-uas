export default function formDataLogger(data) {
    for (var pair of data.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
}
