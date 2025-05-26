<?php
    class LivroAssunto extends Model{
        protected $table = 'Livro_Assunto';

        public $codL;

        function link($assunto){
            $link = 0;

            $search = $this->search([
                'Livro_CodL' => $this->codL,
                'Assunto_CodAs' => $assunto,
            ]);
            if (!$search) {
                $this->create([
                    'Livro_CodL' => $this->codL,
                    'Assunto_CodAs' => $assunto,
                ]);
                $link++;
            }

            $exists = $this->searchAll([
                'Livro_CodL' => $this->codL
            ]);

            foreach ($exists as $exist) {
                $found = false;
                
                if (
                    $exist['Livro_CodL'] == $this->codL &&
                    $exist['Assunto_CodAs'] == $assunto
                ) {
                    $found = true;
                    break;
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