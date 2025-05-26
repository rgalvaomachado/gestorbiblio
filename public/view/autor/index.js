$(document).ready(function() {
    $('#criar').submit(function(e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiPost('/autor', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/autor");
        }else{
            alert.style.color = "red";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }
    });

    $('#editar').submit(function(e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiPut('/autor', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/autor");
        }else{
            alert.style.color = "red";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }
    });

    $('#deletar').submit(function(e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiDelete('/autor', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/autor");
        }else{
            alert.style.color = "red";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }
    });
});

function loadAll(){
    apiResponse = apiGet('/autores')
    if(apiResponse.access){
        $("#lista").html('');
        if (Array.isArray(apiResponse.autores) && apiResponse.autores.length > 0) {
            apiResponse.autores.map(({CodAu, Nome}) => {
                $('#lista').append(`
                    <tr>
                        <td class="text-left">
                            ${CodAu}
                        </td>
                        <td class="text-left">
                            ${Nome}
                        </td>
                        <td>
                            <a href="/autor/editar?id=${CodAu}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                        <td>
                            <a href="/autor/deletar?id=${CodAu}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                `);
            });
        }
    }
}

function load(){
    const params = getUrlParameters();
    apiResponse = apiGet('/autor', params)
    if(apiResponse.access){
        let autor = apiResponse.autor;
        $('[name="id"]').val(autor.CodAu);
        $('[name="nome"]').val(autor.Nome);
    } else {
        const alert = document.getElementById("messageAlert");
        alert.innerHTML = apiResponse.message;
        alert.style.color = "red";
        $("#editar").html('');
        $("#deletar").html('');
    }
}