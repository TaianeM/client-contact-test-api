<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Contatos",
 *     description="Cadastro e Listagem de contatos dos clientes"
 * )
 */
class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes/{id}/contatos",
     *     tags={"Contatos"},
     *     summary="Lista os contatos de um cliente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de contatos do cliente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="cliente_id", type="integer", example=1),
     *                 @OA\Property(property="tipo", type="string", example="email"),
     *                 @OA\Property(property="descricao", type="string", example="cliente@email.com"),
     *                 @OA\Property(property="created_at", type="string", example="13/07/2025 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="13/07/2025 10:10:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente não encontrado.")
     *         )
     *     )
     * )
     */
    public function index($id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        $contatos = $client->contacts->map(function ($contato) {
            return [
                'id' => $contato->id,
                'cliente_id' => $contato->cliente_id,
                'tipo' => $contato->tipo,
                'descricao' => $contato->descricao,
                'created_at' => $contato->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $contato->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return response()->json($contatos, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/contatos",
     *     tags={"Contatos"},
     *     summary="Cadastra um novo contato para um cliente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cliente_id", "tipo", "descricao"},
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="tipo", type="string", example="telefone"),
     *             @OA\Property(property="descricao", type="string", example="(69) 99999-8888")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contato cadastrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contato do Cliente cadastrado com sucesso!"),
     *             @OA\Property(
     *                 property="contato",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="cliente_id", type="integer", example=1),
     *                 @OA\Property(property="tipo", type="string", example="telefone"),
     *                 @OA\Property(property="descricao", type="string", example="(69) 99999-8888"),
     *                 @OA\Property(property="created_at", type="string", example="13/07/2025 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="13/07/2025 10:00:00")
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreContactRequest $request)
    {
        $contato = Contact::create($request->validated());

        return response()->json([
            'message' => 'Contato do Cliente cadastrado com sucesso!',
            'contato' => [
                'id' => $contato->id,
                'cliente_id' => $contato->cliente_id,
                'tipo' => $contato->tipo,
                'descricao' => $contato->descricao,
                'created_at' => Carbon::parse($contato->created_at)->format('d/m/Y H:i:s'),
                'updated_at' => Carbon::parse($contato->updated_at)->format('d/m/Y H:i:s'),
            ]
        ], 201);
    }
}
