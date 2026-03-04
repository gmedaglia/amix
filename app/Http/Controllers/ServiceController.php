<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $servicePaginator = Service::query()->paginate();

        return ServiceResource::collection($servicePaginator);
    }

    public function store(ServiceRequest $request): ServiceResource
    {
        $service = new Service;
        $service->fill($request->validated());

        $dependableProductId = $request->safe()->integer('depends_on_product_id');

        if ($dependableProductId) {
            $product = Product::query()->find($dependableProductId);
            $service->dependable_product()->associate($product);
        }

        $service->save();

        return new ServiceResource($service);
    }

    public function show(Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }

    public function update(ServiceRequest $request, Service $service): ServiceResource
    {
        $service->fill($request->validated());

        $dependableProductId = $request->safe()->integer('depends_on_product_id');

        if ($dependableProductId) {
            $product = Product::query()->find($dependableProductId);
            $service->dependable_product()->associate($product);
        }
                
        $service->save();

        return new ServiceResource($service);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}
