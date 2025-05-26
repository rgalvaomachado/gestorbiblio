$(document).ready(function() {
    $('#criar').submit(function(e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiPost('/assunto', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/assunto");
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

        apiResponse = apiPut('/assunto', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/assunto");
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

        apiResponse = apiDelete('/assunto', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if(apiResponse.access){
            alert.style.color = "green";
            setTimeout(function(){
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/assunto");
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
    apiResponse = apiGet('/assuntos')
    if(apiResponse.access){
        $("#lista").html('');
        if (Array.isArray(apiResponse.assuntos) && apiResponse.assuntos.length > 0) {
            apiResponse.assuntos.map(({CodAs, Descricao}) => {
                $('#lista').append(`
                    <tr>
                        <td class="text-left">
                            ${CodAs}
                        </td>
                        <td class="text-left">
                            ${Descricao}
                        </td>
                        <td>
                            <a href="/assunto/editar?id=${CodAs}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                        <td>
                            <a href="/assunto/deletar?id=${CodAs}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                `);
            });
        }
    }
}

function load(){
    const params = getUrlParameters();
    apiResponse = apiGet('/assunto', params)
    if(apiResponse.access){
        let assunto = apiResponse.assunto;
        $('[name="id"]').val(assunto.CodAs);
        $('[name="descricao"]').val(assunto.Descricao);
    } else {
        const alert = document.getElementById("messageAlert");
        alert.innerHTML = apiResponse.message;
        alert.style.color = "red";
        $("#editar").html('');
        $("#deletar").html('');
    }
}