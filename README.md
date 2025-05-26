Comandos para inicar o projeto
</br>
docker-compose up -d
</br>
docker exec -i gestorbiblio composer install
</br>
</br>
Criar o banco de dados gestorbiblio
</br>
Executar a importação do banco dentro do diretório database
</br>
docker exec -i db_localhost mysql -uroot -proot123 gestorbiblio < gestorbiblio.sql
</br>
</br>
Comandos rodar o teste
</br>
docker exec -i gestorbiblio ./vendor/bin/phpunit