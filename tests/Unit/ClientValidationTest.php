<?php

use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)->in(__FILE__);
uses(RefreshDatabase::class);

test('cliente requer nome, data_nascimento e cpf', function () {
    $data = [];

    $rules = [
        'nome' => 'required|string',
        'cpf' => 'required|string|unique:clients,cpf',
        'data_nascimento' => 'required|date',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->keys())->toContain('nome', 'cpf', 'data_nascimento');
});

test('cpf deve ser único entre os clientes', function () {
    Client::factory()->create(['cpf' => '111.111.111-11']);

    $data = [
        'nome' => 'João',
        'cpf' => '111.111.111-11',
        'data_nascimento' => '2000-01-01',
    ];

    $rules = [
        'nome' => 'required|string',
        'cpf' => 'required|string|unique:clients,cpf',
        'data_nascimento' => 'required|date',
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('cpf'))->toBeTrue();
});
