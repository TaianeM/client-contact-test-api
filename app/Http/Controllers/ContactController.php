<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ContactController extends Controller
{
      public function index(): JsonResponse
    {
        $contatos = Contact::all()->map(function ($contato) {
            return [
                'id' => $contato->id,
                'cliente_id' => $contato->cliente_id,
                'tipo' => $contato->tipo,
                'descricao' => $contato->descricao,
                'created_at' => Carbon::parse($contato->created_at)->format('d/m/Y H:i:s'),
                'updated_at' => Carbon::parse($contato->updated_at)->format('d/m/Y H:i:s'),
            ];
        });

        return response()->json($contatos, 200);
    }

    public function store(StoreContactRequest $request)
    {
        $contato= Contact::create($request->validated());

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
