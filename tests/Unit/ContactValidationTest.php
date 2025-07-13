<?php

use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)->in(__FILE__);
uses(RefreshDatabase::class);

test('contato requer cliente_id, tipo e descricao', function () {
    $data = [];

    $rules = [
        'cliente_id' => 'required|exists:clients,id',
        'tipo' => 'required|in:telefone,email',
        'descricao' => 'required|string',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->keys())->toContain('cliente_id', 'tipo', 'descricao');
});

test('contato só aceita tipo email ou telefone', function () {
    $cliente = Client::factory()->create();

    $data = [
        'cliente_id' => $cliente->id,
        'tipo' => 'whatsapp',
        'descricao' => '11999999999',
    ];

    $rules = [
        'cliente_id' => 'required|exists:clients,id',
        'tipo' => 'required|in:telefone,email',
        'descricao' => 'required|string',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('tipo'))->toBeTrue();
});

test('cliente_id deve existir no banco', function () {
    $data = [
        'cliente_id' => 9999,
        'tipo' => 'email',
        'descricao' => 'teste@exemplo.com',
    ];

    $rules = [
        'cliente_id' => 'required|exists:clients,id',
        'tipo' => 'required|in:telefone,email',
        'descricao' => 'required|string',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('cliente_id'))->toBeTrue();
});
