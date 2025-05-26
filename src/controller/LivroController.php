<?php

use Dompdf\Dompdf;

class LivroController{

    function searchAll(){
        $livros = (new Livro)->searchAll();

        foreach ($livros as &$livro) {
            if (isset($livro['Preco']) && is_numeric($livro['Preco'])) {
                $valorFormatado = number_format($livro['Preco'], 2, ',', '.');
                $livro['Preco'] = "R$ " . $valorFormatado;
            } else {
                $livro['Preco'] = 'R$ 0,00';
            }
        }

        return json_encode([
            "access" => true,
            "livros" => $livros
        ]);
    }

    function search($pararms){
        $livro = (new Livro)->search([
            'CodL' => $pararms['id']
        ]);

        if (empty($livro)) {
            return json_encode([
                "access" => false,
                "message" => "Livro não encontrado"
            ]);
        }

        $autores = (new LivroAutor)->searchAllWithAutor([
            'Livro_CodL' => $pararms['id']
        ]);
        $livro['autores'] = $autores;

        $assuntos = (new LivroAssunto)->search([
            'Livro_CodL' => $pararms['id']
        ]);
        $livro['assunto'] = $assuntos;

        if (isset($livro['Preco']) && is_numeric($livro['Preco'])) {
            $valorFormatado = number_format($livro['Preco'], 2, ',', '.');
            $livro['Preco'] = "R$ " . $valorFormatado;
        } else {
            $livro['Preco'] = 'R$ 0,00';
        }

        return json_encode([
            "access" => true,
            "livro" => $livro,
        ]);
    }

    function create($pararms){
        $anoAtual = (new DateTime())->format('Y');
        if ($pararms['publicacao'] < $anoAtual) {
            return json_encode([
                "access" => false,
                "message" => "Ano deve ser igual ou maior que " . $anoAtual
            ]);
        }

        if (strlen($pararms['publicacao']) > 4) {
            return json_encode([
                "access" => false,
                "message" => "Ano da publicacao com no máximo 4 digitos"
            ]);
        }

        if (strlen($pararms['titulo']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Titulo pode ter no maximo 40 caracteres"
            ]);
        }

        if (strlen($pararms['editora']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Editora pode ter no maximo 40 caracteres"
            ]);
        }

        $pararms['preco'] = preg_replace('/[^0-9,]/', '', $pararms['preco']);
        $pararms['preco'] = str_replace(',', '.', $pararms['preco']);
        
        $codL = (new Livro)->create([
            'Titulo' => $pararms['titulo'],
            'Editora' => $pararms['editora'],
            'Edicao' => $pararms['edicao'],
            'AnoPublicacao' => $pararms['publicacao'],
            'Preco' => number_format((float) $pararms['preco'], 2, '.', ''),
        ]);

        $linkAutor = 0;
        if(!empty($pararms['autores[]'])){
            $LivroAutor = new LivroAutor();
            $LivroAutor->codL = $codL;
            $LivroAutor->link($pararms['autores[]']);
        }

        $linkAssunto = 0;
        if(!empty($pararms['assunto'])){
            $LivroAssunto = new LivroAssunto();
            $LivroAssunto->codL = $codL;
            $LivroAssunto->link($pararms['assunto']);
        }

        if ($codL > 0){
            return json_encode([
                "access" => true,
                "message" => "Criado com sucesso"
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Erro no cadastro"
            ]);
        }
        
    }

    function update($pararms){
        $anoAtual = (new DateTime())->format('Y');
        if ($pararms['publicacao'] < $anoAtual) {
            return json_encode([
                "access" => false,
                "message" => "Ano deve ser igual ou maior que " . $anoAtual
            ]);
        }

        if (strlen($pararms['publicacao']) > 4) {
            return json_encode([
                "access" => false,
                "message" => "Titulo pode ter no maximo 40 caracteres"
            ]);
        }

        if (strlen($pararms['titulo']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Titulo pode ter no maximo 40 caracteres"
            ]);
        }

        if (strlen($pararms['editora']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Editora pode ter no maximo 40 caracteres"
            ]);
        }

        $pararms['preco'] = preg_replace('/[^0-9,]/', '', $pararms['preco']);
        $pararms['preco'] = str_replace(',', '.', $pararms['preco']);
        
        $update = (new Livro)->update([
                'Titulo' => $pararms['titulo'],
                'Editora' => $pararms['editora'],
                'Edicao' => $pararms['edicao'],
                'AnoPublicacao' => $pararms['publicacao'],
                'Preco' => $pararms['preco'],
            ],
            [
                'CodL' => $pararms['id'],
            ]
        );

        $linkAutor = 0;
        if(!empty($pararms['autores[]'])){
            $LivroAutor = new LivroAutor();
            $LivroAutor->codL = $pararms['id'];
            $linkAutor = $LivroAutor->link($pararms['autores[]']);
        }

        $linkAssunto = 0;
        if(!empty($pararms['assunto'])){
            $LivroAssunto = new LivroAssunto();
            $LivroAssunto->codL = $pararms['id'];
            $linkAssunto = $LivroAssunto->link($pararms['assunto']);
        }

        if ($update > 0 || $linkAutor > 0 || $linkAssunto > 0) {
            return json_encode([
                "access" => true,
                "message" => "Editado com sucesso"
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Nenhuma edição efetuada"
            ]);
        }
    }

    function delete($pararms){
        $livro = (new Livro)->delete([
            'CodL' => $pararms['id']
        ]);
        if ($livro){
            return json_encode([
                "access" => true,
                "message" => "Deletado com sucesso"
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Erro na exclusão"
            ]);
        }  
    }

    function report(){
        $dados = (new RelatorioLivros)->searchAll();

        $html = '<h1>Relatório de Livros por Autor</h1>';

        $autoresAgrupados = [];

        foreach ($dados as $linha) {
            $autoresAgrupados[$linha['NomeAu']][] = $linha;
        }

        foreach ($autoresAgrupados as $autor => $livros) {
            $html .= "<h2>Autor: " . $autor . "</h2>";
            foreach ($livros as $livro) {
                $html .= "<label><strong>" . $livro['Titulo'] . "</strong>, " . $livro['Assuntos'] . '</label><br>';
            }
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $arquivo = 'report_livros.pdf';
        $pasta =  $_SERVER['PROJECT_ROOT'] . '/' . $_ENV['DIRECTORY_STORAGE'] . $arquivo;
        file_put_contents($pasta, $dompdf->output());
        $url = $_ENV['BASE_URL'] . '/' . $_ENV['DIRECTORY_STORAGE'] . $arquivo;

        return json_encode([
            "access" => true,
            "url" => $url
        ]); 
    }
}