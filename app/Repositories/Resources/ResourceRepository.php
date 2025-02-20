<?php

namespace App\Repositories\Resources;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepository
{
    public function getResources(): Collection
    {
        return Resource::query()
            ->select('id', 'name', 'type','description')
            ->available()
            ->get();
    }

    public function createResource(array $data)
    {
        return Resource::query()->create($data);
    }
}
