function apiGet(url, data = null){
    $.ajax({
        method: "GET",
        url: basePath + '/api' + url,
        headers: {
            "Content-Type": "application/json",
        },
        data: data,
        async: false,
        complete: function(response) {
            responseData = JSON.parse(response.responseText);
        }
    });

    return responseData;
}

function apiPost(url, data = null){
    $.ajax({
        method: "POST",
        url: '/api' + url,
        headers: {
            "Content-Type": "application/json",
        },
        data: JSON.stringify(data),
        async: false,
        complete: function(response) {
            responseData = JSON.parse(response.responseText);
        }
    });

    return responseData;
}

function apiPut(url, data = null){
    $.ajax({
        method: "PUT",
        url: '/api' + url,
        headers: {
            "Content-Type": "application/json",
        },
        data: JSON.stringify(data),
        async: false,
        complete: function(response) {
            responseData = JSON.parse(response.responseText);
        }
    });

    return responseData;
}

function apiDelete(url, data = null){
    $.ajax({
        method: "DELETE",
        url: '/api' + url,
        headers: {
            "Content-Type": "application/json",
        },
        data: JSON.stringify(data),
        async: false,
        complete: function(response) {
            responseData = JSON.parse(response.responseText);
        }
    });

    return responseData;
}