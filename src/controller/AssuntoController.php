<?php
class AssuntoController{
    function searchAll(){
        $assuntos = (new Assunto)->searchAll();
        return json_encode([
            "access" => true,
            "assuntos" => $assuntos
        ]);
    }

    function search($pararms){
        $assunto = (new Assunto)->search([
            'CodAs' => $pararms['id']
        ]);

        if(!empty($assunto)){
            return json_encode([
                "access" => true,
                "assunto" => $assunto,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Assunto não encontrado"
            ]);
        }
    }

    function create($pararms){
        if (strlen($pararms['descricao']) > 20) {
            return json_encode([
                "access" => false,
                "message" => "Descrição pode ter no maximo 20 caracteres"
            ]);
        }

        $assunto = (new Assunto)->create([
            'Descricao' => $pararms['descricao']
        ]);

        if ($assunto > 0){
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
        if (strlen($pararms['descricao']) > 20) {
            return json_encode([
                "access" => false,
                "message" => "Descrição pode ter no maximo 20 caracteres"
            ]);
        }
        
        $assunto = (new Assunto)->update([
                'Descricao' => $pararms['descricao'],
            ],
            [
                'CodAs' => $pararms['id'],
            ]
        );
        if ($assunto > 0) {
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
        $assunto = (new Assunto)->delete([
            'CodAs' => $pararms['id']
        ]);
        if ($assunto){
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