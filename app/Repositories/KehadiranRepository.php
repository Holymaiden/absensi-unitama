<?php

namespace App\Repositories;

use App\Models\Kehadiran;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\KehadiranContract;

class KehadiranRepository extends BaseRepository implements KehadiranContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Kehadiran $models)
    {
        $this->model = $models->whereNotNull('id');
    }
}
