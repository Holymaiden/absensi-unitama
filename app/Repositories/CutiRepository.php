<?php

namespace App\Repositories;

use App\Models\Cuti;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CutiContract;

class CutiRepository extends BaseRepository implements CutiContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Cuti $models)
    {
        $this->model = $models->whereNotNull('id');
    }
}
