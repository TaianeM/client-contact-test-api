<?php

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('consegue criar um contato', function () {
    $cliente = Client::factory()->create();

    $response = $this->postJson('/api/contatos', [
        'cliente_id' => $cliente->id,
        'tipo' => 'email',
        'descricao' => 'cliente@email.com',
    ]);

    $response->assertCreated();
    $response->assertJsonFragment(['message' => 'Contato do Cliente cadastrado com sucesso!']);
});

test('consegue listar contatos de um cliente', function () {
    $cliente = Client::factory()->create();
    Contact::factory()->create([
        'cliente_id' => $cliente->id,
        'tipo' => 'telefone',
        'descricao' => '(69) 99999-8888',
    ]);

    $response = $this->getJson("/api/clientes/{$cliente->id}/contatos");

    $response->assertOk();
    $response->assertJsonFragment(['descricao' => '(69) 99999-8888']);
});

test('consegue atualizar um contato', function () {
    $cliente = Client::factory()->create();
    $contato = Contact::factory()->create([
        'cliente_id' => $cliente->id,
        'tipo' => 'telefone',
        'descricao' => 'antigo@email.com',
    ]);

    $response = $this->putJson("/api/contatos/{$contato->id}", [
        'cliente_id' => $cliente->id,
        'tipo' => 'email',
        'descricao' => 'novo@email.com',
    ]);

    $response->assertOk();
    $response->assertJsonFragment(['descricao' => 'novo@email.com']);
});

test('consegue deletar um contato', function () {
    $cliente = Client::factory()->create();
    $contato = Contact::factory()->create(['cliente_id' => $cliente->id]);

    $response = $this->deleteJson("/api/contatos/{$contato->id}");

    $response->assertOk();
    $this->assertDatabaseMissing('contacts', ['id' => $contato->id]);
});

test('não permite criar contato com tipo inválido', function () {
    $cliente = \App\Models\Client::factory()->create();

    $response = $this->postJson('/api/contatos', [
        'cliente_id' => $cliente->id,
        'tipo' => 'fax', // inválido
        'descricao' => '123456',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['tipo']);
});

test('não permite criar contato com cliente inexistente', function () {
    $response = $this->postJson('/api/contatos', [
        'cliente_id' => 9999, // cliente não existe
        'tipo' => 'email',
        'descricao' => 'email@invalido.com',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['cliente_id']);
});

test('não permite criar contato sem campos obrigatórios', function () {
    $response = $this->postJson('/api/contatos', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['cliente_id', 'tipo', 'descricao']);
});
