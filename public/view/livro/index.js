$(document).ready(function () {
    $('#criar').submit(function (e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiPost('/livro', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if (apiResponse.access) {
            alert.style.color = "green";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/livro");
        } else {
            alert.style.color = "red";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }

    });

    $('#editar').submit(function (e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiPut('/livro', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if (apiResponse.access) {
            alert.style.color = "green";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/livro");
        } else {
            alert.style.color = "red";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }
    });

    $('#deletar').submit(function (e) {
        e.preventDefault();

        const formData = getFormData(this);

        apiResponse = apiDelete('/livro', formData)

        const alert = document.getElementById("messageAlert");

        alert.innerHTML = apiResponse.message;

        if (apiResponse.access) {
            alert.style.color = "green";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.location.assign("/livro");
        } else {
            alert.style.color = "red";
            setTimeout(function () {
                alert.innerHTML = "";
            }, 3000);
            window.scrollTo(0, 0);
        }
    });

    $('#report').on('click', function (e) {
        e.preventDefault();
        const params = getUrlParameters();
        apiResponse = apiGet('/livro/report', params)
        if (apiResponse.access) {
            window.open(apiResponse.url, '_blank');
        }
    });

    $('[name="preco"]').on('input', function() {
        let value = $(this).val();

        value = value.replace(/\D/g, '');

        if (value.length === 0) {
        $(this).val('');
        return;
        }

        if (value.length === 1) {
        value = '0' + value;
        }

        const length = value.length;
        const reais = value.substring(0, length - 2);
        const centavos = value.substring(length - 2);

        let reaisFormatado = parseInt(reais).toLocaleString('pt-BR');

        $(this).val(`R$ ${reaisFormatado},${centavos}`);
    });
});

function loadAll() {
    apiResponse = apiGet('/livros')
    if (apiResponse.access) {
        $("#lista").html('');
        if (Array.isArray(apiResponse.livros) && apiResponse.livros.length > 0) {
            apiResponse.livros.map(({ CodL, Titulo, Editora, Edicao, AnoPublicacao, Preco, AutorNome, AssuntoDescricao }) => {
                $('#lista').append(`
                    <tr>
                        <td class="text-left">
                            ${CodL}
                        </td>
                        <td class="text-left">
                            ${Titulo}
                        </td>
                        <td class="text-left">
                            ${Editora}
                        </td>
                        <td class="text-left">
                            ${Edicao}
                        </td>
                        <td class="text-left">
                            ${AnoPublicacao}
                        </td>
                        <td class="text-left">
                            ${Preco}
                        </td>
                        <td>
                            <a href="/livro/editar?id=${CodL}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                        <td>
                            <a href="/livro/deletar?id=${CodL}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                `);
            });
        }
    }
}

function load() {
    const params = getUrlParameters();
    apiResponse = apiGet('/livro', params)
    if (apiResponse.access && apiResponse.livro) {
        let livro = apiResponse.livro;
        $('[name="id"]').val(livro.CodL);
        $('[name="titulo"]').val(livro.Titulo);
        $('[name="editora"]').val(livro.Editora);
        $('[name="edicao"]').val(livro.Edicao);
        $('[name="publicacao"]').val(livro.AnoPublicacao);
        $('[name="preco"]').val(livro.Preco);
        $('[name="codAs"]').val(livro.assunto.Assunto_CodAs);
        livro.autores.map(({ Autor_CodAu, Nome }) => {
            $('#listAutores').append(`
            <tr>
                    <td>
                        ${Nome}
                    </td>
                    <td>
                        <a><i onclick="delAutor(this)" class="fa fa-trash" aria-hidden="true"></i></a>
                        
                    </td>
                    <input type="hidden" name="autores[]" value="${Autor_CodAu}">
                </tr>
            `)
        });
    } else {
        const alert = document.getElementById("messageAlert");
        alert.innerHTML = apiResponse.message;
        alert.style.color = "red";
        $("#editar").html('');
        $("#deletar").html('');
    }
}

function loadAutor() {
    const params = getUrlParameters();
    apiResponse = apiGet('/autores', params)
    $("#autor").html('');
    let codAutor = $('[name="codAu"]').val();
    $("#autor").append(`
        <option value="">Selecione um autor</option>
    `);
    if (Array.isArray(apiResponse.autores) && apiResponse.autores.length > 0) {
        apiResponse.autores.map(({ CodAu, Nome }) => {
            $("#autor").append(`
                <option value="${CodAu}" ${CodAu == codAutor ? 'selected' : ''}>
                    ${Nome}
                </option >
            `);
        });
    }
}

function loadAssunto() {
    const params = getUrlParameters();
    apiResponse = apiGet('/assuntos', params)
    $('[name="assunto"]').append(`
        <option value="">Selecione um assunto</option>
    `);
    let codAssunto = $('#codAs').val();
    if (Array.isArray(apiResponse.assuntos) && apiResponse.assuntos.length > 0) {
        apiResponse.assuntos.map(({ CodAs, Descricao }) => {
            $('[name="assunto"]').append(`
                <option value="${CodAs}" ${CodAs == codAssunto ? 'selected' : ''}>
                    ${Descricao}
                </option >
            `);
        });
    }
}

function addAutor(element) {
    let autor = $(element).parent().parent().parent();

    const autorSelect = autor.find("#autor");
    CodAu = autorSelect.val();
    NomeAu = autorSelect.find("option:selected").text();

    if (!CodAu) {
        alert('Selecione um autor');
    } else {
        $('#listAutores').append(`
           <tr>
                <td>
                    ${NomeAu}
                </td>
                <td>
                    <a><i onclick="delAutor(this)" class="fa fa-trash" aria-hidden="true"></i></a>
                    
                </td>
                <input type="hidden" name="autores[]" value="${CodAu}">
            </tr>
        `);
        loadAutor();
    }
}

function delAutor(element) {
    let autor = $(element).parent().parent().parent();
    $(autor).remove()
}