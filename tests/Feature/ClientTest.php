<?php

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('consegue criar um cliente', function () {
    $dados = Client::factory()->make();

    $response = $this->postJson('/api/clientes', [
        'nome' => $dados->nome,
        'cpf' => $dados->cpf,
        'data_nascimento' => $dados->data_nascimento,
    ]);

    $response->assertCreated();
    $response->assertJsonFragment(['message' => 'Cliente cadastrado com sucesso!']);
});


test('consegue listar clientes', function () {
    $cliente = Client::factory()->create(['nome' => 'Maria']);

    $response = $this->getJson('/api/clientes');

    $response->assertOk();
    $response->assertJsonFragment(['nome' => 'Maria']);
});

test('consegue atualizar um cliente', function () {
    $cliente = Client::factory()->create([
        'nome' => 'Antigo',
    ]);

    $response = $this->putJson("/api/clientes/{$cliente->id}", [
        'nome' => 'Atualizado',
        'cpf' => $cliente->cpf,
        'data_nascimento' => $cliente->data_nascimento,
    ]);

    $response->assertOk();
    $response->assertJsonFragment(['nome' => 'Atualizado']);
});

test('consegue deletar um cliente', function () {
    $cliente = Client::factory()->create();

    $response = $this->deleteJson("/api/clientes/{$cliente->id}");

    $response->assertOk();
    $this->assertDatabaseMissing('clients', ['id' => $cliente->id]);
});

test('não permite cadastrar cliente com CPF duplicado', function () {
    $clienteExistente = Client::factory()->create();

    $response = $this->postJson('/api/clientes', [
        'nome' => 'Outro Nome',
        'cpf' => $clienteExistente->cpf,
        'data_nascimento' => '2000-01-01',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['cpf']);
});

test('não permite cadastrar cliente sem campos obrigatórios', function () {
    $response = $this->postJson('/api/clientes', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['nome', 'cpf', 'data_nascimento']);
});

