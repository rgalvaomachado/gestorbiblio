<?php
    class LivroAutor extends Model{
        protected $table = 'Livro_Autor';

        public $codL;

        function searchAllWithAutor($conditions = [])
        {
            $query = "
                SELECT {$this->table}.*, Autor.Nome
                FROM {$this->table}
                LEFT JOIN Autor on {$this->table}.Autor_CodAu = Autor.CodAu
            ";

            if (!empty($conditions)) {
                $where = implode(' AND ', array_map(fn($column) => "{$column} = :{$column}", array_keys($conditions)));
                $query .= " WHERE {$where}";
            }

            $sql = $this->connection->prepare($query);

            $sql->execute($conditions);

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        function link($autores){
            $link = 0;

            foreach ($autores as $autor) {
                $search = $this->search([
                    'Livro_CodL' => $this->codL,
                    'Autor_CodAu' => $autor,
                ]);
                if (!$search) {
                    $this->create([
                        'Livro_CodL' => $this->codL,
                        'Autor_CodAu' => $autor,
                    ]);
                    $link++;
                }
            }

            $exists = $this->searchAll([
                'Livro_CodL' => $this->codL
            ]);

            foreach ($exists as $exist) {
                $found = false;

                foreach ($autores as $autor) {
                    if (
                        $exist['Livro_CodL'] == $this->codL &&
                        $exist['Autor_CodAu'] == $autor
                    ) {
                        $found = true;
                        break;
                    }
                }
        
                if (!$found) {
                    $this->delete($exist);
                    $link++;
                }
            }

            return $link;
        }
    }
?>