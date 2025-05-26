<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/autoload.php';
require_once(__DIR__ . '/../env.php');

class AutorControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        $this->controller = new AutorController();
    }

    public function testCreateAutor()
    {
        $response = $this->controller->create(['nome' => 'Autor Teste']);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Criado com sucesso', $data['message']);
    }

    public function testReadAutor()
    {
        $this->controller->create(['nome' => 'Autor para leitura']);
        $allAutores = json_decode($this->controller->searchAll(), true)['autores'];
        $lastAutor = end($allAutores);

        $response = $this->controller->search(['id' => $lastAutor['CodAu']]);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Autor para leitura', $data['autor']['Nome']);
    }

    public function testUpdateAutor()
    {
        $this->controller->create(['nome' => 'Autor a ser editado']);
        $allAutores = json_decode($this->controller->searchAll(), true)['autores'];
        $lastAutor = end($allAutores);

        $response = $this->controller->update(['id' => $lastAutor['CodAu'], 'nome' => 'Autor editado']);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Editado com sucesso', $data['message']);
    }

    public function testDeleteAutor()
    {
        $this->controller->create(['nome' => 'Autor a ser deletado']);
        $allAutores = json_decode($this->controller->searchAll(), true)['autores'];
        $lastAutor = end($allAutores);

        $response = $this->controller->delete(['id' => $lastAutor['CodAu']]);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Deletado com sucesso', $data['message']);
    }
}
