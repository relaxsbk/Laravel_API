<?php

namespace App\Http\Controllers\api\v1\Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\ResourceResource;
use App\Models\Resource;
use App\Repositories\Resources\ResourceRepository;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    public function index(ResourceRepository $resourceRepository)
    {
        $resources = $resourceRepository->getResources();

        return ResourceResource::collection($resources);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
