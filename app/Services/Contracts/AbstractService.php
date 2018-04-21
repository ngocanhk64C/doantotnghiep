<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AbstractService
{
    public function store(array $attributes);
    public function update(Model $entity, array $attributes);
    public function delete(Model $entity);
}
