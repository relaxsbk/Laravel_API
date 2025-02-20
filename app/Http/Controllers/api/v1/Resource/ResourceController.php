<?php

namespace App\Http\Controllers\api\v1\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\StoreResourceRequest;
use App\Http\Requests\Resource\UpdateResourceRequest;
use App\Http\Resources\Resource\MiniResourceResource;
use App\Http\Resources\Resource\ResourceResource;
use App\Models\Resource;
use App\Repositories\Resources\ResourceRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ResourceController extends Controller implements HasMiddleware
{

    public function index(ResourceRepository $resourceRepository)
    {
        $resources = $resourceRepository->getResources();

        return MiniResourceResource::collection($resources);
    }


    public function store(ResourceRepository $resourceRepository, StoreResourceRequest $request)
    {
        $resource = $resourceRepository->createResource($request->validated());

        return $this->show($resource);
    }


    public function show(Resource $resource)
    {
        return new ResourceResource($resource);
    }


    public function update(UpdateResourceRequest $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public static function middleware()
    {
        return [
            new Middleware(['auth:sanctum'], except:['index','show'])
        ];
    }
}
