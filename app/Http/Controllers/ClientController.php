<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

/**
 * @OA\Info(
 *     title="API de Clientes",
 *     version="1.0.0",
 *     description="Documentação da API de gerenciamento de clientes utilizando Swagger"
 * )
 *
 * @OA\Tag(
 *     name="Clientes",
 *     description="Cadastro e listagem dos clientes"
 * )
 */
class ClientController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/clients",
     *     tags={"Clientes"},
     *     summary="Cadastra um novo cliente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "data_nascimento", "cpf"},
     *             @OA\Property(property="nome", type="string", example="Taiane Melo"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", example="01/09/2002, 01092002 ou 2002-09-01"),
     *             @OA\Property(property="cpf", type="string", example="1234567800"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente cadastrado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cliente cadastrado com sucesso!"),
     *             @OA\Property(
     *                 property="cliente",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="nome", type="string", example="Taiane Melo"),
     *                 @OA\Property(property="data_nascimento", type="string", example="01/09/2002"),
     *                 @OA\Property(property="cpf", type="string", example="12345678900"),
     *                 @OA\Property(property="created_at", type="string", example="13/07/2025 09:45:00"),
     *                 @OA\Property(property="updated_at", type="string", example="13/07/2025 09:45:00")
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/clients",
     *     tags={"Clientes"},
     *     summary="Lista todos os clientes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Taiane Melo"),
     *                 @OA\Property(property="data_nascimento", type="string", example="01/09/2002"),
     *                 @OA\Property(property="cpf", type="string", example="123.456.789-00"),
     *                 @OA\Property(property="created_at", type="string", example="01/07/2025 12:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="01/07/2025 12:30:00")
     *             )
     *         )
     *     )
     * )
     */
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
        /**
     * @OA\Put(
     *     path="/api/clientes/{id}",
     *     tags={"Clientes"},
     *     summary="Atualiza um cliente existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser atualizado",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Novo Nome"),
     *             @OA\Property(property="cpf", type="string", example="123.456.789-00"),
     *             @OA\Property(property="data_nascimento", type="string", example="01/01/2000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     */
    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        $cliente->update($request->validated());

        return response()->json([
            'message' => 'Cliente atualizado com sucesso!',
            'cliente' => [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
                'data_nascimento' => Carbon::parse($cliente->data_nascimento)->format('d/m/Y'),
                'cpf' => $cliente->cpf,
                'updated_at' => Carbon::parse($cliente->updated_at)->format('d/m/Y H:i:s'),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/clientes/{id}",
     *     tags={"Clientes"},
     *     summary="Remove um cliente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser removido",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente removido com sucesso.']);
    }
}
