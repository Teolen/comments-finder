
function search(event) {
    let searchInput = document.getElementById("searchInput");
    if(searchInput.value.length < 3) {
        searchInput.style = "border:2px solid red";
    } else {
        findRequest(searchInput.value);
        searchInput.style = "";
    }
    return false;
}

function findRequest(findable = null) {

    let request = new XMLHttpRequest();
    request.onload = function() {
        if(request.status === 200) {
            let resp = request.response;
            document.getElementById("answer").innerHTML = resp;
        } else {
            console.log('Ошибка запроса к БД');
        }
    }
    request.open('GET', 'find.php?findable='+findable);
    request.send('?findable='+findable);
    return request;
}