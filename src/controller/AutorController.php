<?php
class AutorController{
    function searchAll(){
        $autores = (new Autor)->searchAll();
        return json_encode([
            "access" => true,
            "autores" => $autores
        ]);
    }

    function search($pararms){
        $autor = (new Autor)->search([
            'CodAu' => $pararms['id']
        ]);

        if(!empty($autor)){
            return json_encode([
                "access" => true,
                "autor" => $autor,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Autor não encontrado"
            ]);
        }
    }

    function create($pararms){
        if (strlen($pararms['nome']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Nome pode ter no maximo 40 caracteres"
            ]);
        }

        $autor = (new Autor)->create([
            'Nome' => $pararms['nome'],
        ]);

        if ($autor > 0){
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
        if (strlen($pararms['nome']) > 40) {
            return json_encode([
                "access" => false,
                "message" => "Nome pode ter no maximo 40 caracteres"
            ]);
        }

        $autor = (new Autor)->update([
                'Nome' => $pararms['nome'],
            ],
            [
                'CodAu' => $pararms['id'],
            ]
        );
        if ($autor > 0) {
            return json_encode([
                "access" => true,
                "message" => "Editado com sucesso"
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Erro na edição"
            ]);
        }
    }

    function delete($pararms){
        $autor = (new Autor)->delete([
            'CodAu' => $pararms['id']
        ]);
        if ($autor){
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
}