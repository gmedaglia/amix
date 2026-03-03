<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $clientPaginator = Client::query()->paginate();

        return ClientResource::collection($clientPaginator);
    }

    public function store(ClientRequest $request): ClientResource
    {
        $client = new Client;

        $client->fill($request->validated());
        $client->save();

        return new ClientResource($client);
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client);
    }

    public function update(ClientRequest $request, Client $client): ClientResource
    {
        $client->fill($request->validated());
        $client->save();

        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->noContent();
    }
}
