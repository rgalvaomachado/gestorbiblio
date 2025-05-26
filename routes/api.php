<?php
    $api = [
        // [METODO, ENDPOINT, CONTROLLER, FUNCTION]

        ['GET','/livros','LivroController','searchAll'],
        ['GET','/livro','LivroController','search'],
        ['POST','/livro','LivroController','create'],
        ['PUT','/livro','LivroController','update'],
        ['DELETE','/livro','LivroController','delete'],
        ['GET','/livro/report','LivroController','report'],

        ['GET','/autores','AutorController','searchAll'],
        ['GET','/autor','AutorController','search'],
        ['POST','/autor','AutorController','create'],
        ['PUT','/autor','AutorController','update'],
        ['DELETE','/autor','AutorController','delete'],

        ['GET','/assuntos','AssuntoController','searchAll'],
        ['GET','/assunto','AssuntoController','search'],
        ['POST','/assunto','AssuntoController','create'],
        ['PUT','/assunto','AssuntoController','update'],
        ['DELETE','/assunto','AssuntoController','delete'],
    ];
