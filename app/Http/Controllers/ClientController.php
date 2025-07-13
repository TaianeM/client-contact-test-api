<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clientes = Client::all()->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
                'data_nascimento' => Carbon::parse($cliente->data_nascimento)->format('d/m/Y'),
                'cpf' => $cliente->cpf,
                'created_at' => Carbon::parse($cliente->created_at)->format('d/m/Y H:i:s'),
                'updated_at' => Carbon::parse($cliente->updated_at)->format('d/m/Y H:i:s'),
            ];
        });

        return response()->json($clientes, 200);
    }

    public function store(StoreClientRequest $request)
    {
        $cliente = Client::create($request->validated());

        return response()->json([
            'message' => 'Cliente cadastrado com sucesso!',
            'cliente' => [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
                'data_nascimento' => Carbon::parse($cliente->data_nascimento)->format('d/m/Y'),
                'cpf' => $cliente->cpf,
                'created_at' => Carbon::parse($cliente->created_at)->format('d/m/Y H:i:s'),
                'updated_at' => Carbon::parse($cliente->updated_at)->format('d/m/Y H:i:s'),
            ]
        ], 201);
    }
}
