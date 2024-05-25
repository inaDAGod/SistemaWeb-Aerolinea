// vuelo.js
function getVuelo(cvuelo, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_vuelo.php?cvuelo=" + cvuelo, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const vuelo = JSON.parse(xhr.responseText);
            callback(vuelo);
        }
    };
    xhr.send();
}

// vuelo.js
function getVuelo(cvuelo, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_vuelo.php?cvuelo=" + cvuelo, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const vuelo = JSON.parse(xhr.responseText);
            callback(vuelo);
        }
    };
    xhr.send();
}
