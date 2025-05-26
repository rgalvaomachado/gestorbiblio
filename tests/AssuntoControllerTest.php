<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/../env.php');

class AssuntoControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        $this->controller = new AssuntoController();
    }

    public function testCreateAssunto()
    {
        $response = $this->controller->create(['descricao' => 'Teste curto']);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Criado com sucesso', $data['message']);
    }

    public function testReadAssunto()
    {
        $this->controller->create(['descricao' => 'Leitura curta']);
        $allAssuntos = json_decode($this->controller->searchAll(), true)['assuntos'];
        $lastAssunto = end($allAssuntos);

        $response = $this->controller->search(['id' => $lastAssunto['CodAs']]);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Leitura curta', $data['assunto']['Descricao']);
    }

    public function testUpdateAssunto()
    {
        $this->controller->create(['descricao' => 'Atualiza']);
        $allAssuntos = json_decode($this->controller->searchAll(), true)['assuntos'];
        $lastAssunto = end($allAssuntos);

        $response = $this->controller->update(['id' => $lastAssunto['CodAs'], 'descricao' => 'Editado']);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Editado com sucesso', $data['message']);
    }

    public function testDeleteAssunto()
    {
        $this->controller->create(['descricao' => 'Deleta']);
        $allAssuntos = json_decode($this->controller->searchAll(), true)['assuntos'];
        $lastAssunto = end($allAssuntos);

        $response = $this->controller->delete(['id' => $lastAssunto['CodAs']]);
        $data = json_decode($response, true);

        $this->assertTrue($data['access']);
        $this->assertEquals('Deletado com sucesso', $data['message']);
    }
}
