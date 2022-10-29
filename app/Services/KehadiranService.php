<?php

namespace App\Services;

use App\Repositories\Contracts\KehadiranContract as KehadiranRepo;
use App\Services\Contracts\KehadiranContract;
use App\Traits\Uploadable;

class KehadiranService implements KehadiranContract
{
    use Uploadable;

    protected $contractRepo;
    protected $surat_path = 'uploads/izin';

    public function __construct(KehadiranRepo $contractRepo)
    {
        $this->contractRepo = $contractRepo;
    }

    /**
     * Get Data
     */
    public function getAll()
    {
        return $this->contractRepo->index();
    }

    /**
     * Store Data
     */
    public function store($request)
    {
        $input = $request->all();
        return $this->contractRepo->store($input);
    }

    /**
     * Get Data By ID
     */
    public function show($id)
    {
        return $this->contractRepo->show($id);
    }

    /**
     * Update Data By ID
     */
    public function update($request, $id)
    {
        $input = $request->all();
        return $this->contractRepo->update($input, $id);
    }

    /**
     * Delete Data By ID
     */
    public function delete($id)
    {
        return $this->contractRepo->delete($id);
    }

    /**
     * Get Data with Pagination
     */
    public function paginate($perPage = 0, $columns = array('*'))
    {
        $perPage = $perPage ?: config('constants.PAGINATION');
        return $this->contractRepo->paginate($perPage, $columns);
    }

    public function izinSakit($request)
    {
        $input = $request->all();
        if ($request->hasFile('surat_sakit')) {
            $surat = $request->file('surat_sakit')->getClientOriginalName();
            $surat_name = pathinfo($surat, PATHINFO_FILENAME);
            $surat_name = $this->uploadFile2($request->file('surat_sakit'), $this->surat_path, '');
            $input['surat_sakit'] = $surat_name;
        }
        return $this->contractRepo->store($input);
    }

    public function izinSakitUpdate($request)
    {
        if ($request->hasFile('surat_sakit')) {
            $surat = $request->file('surat_sakit')->getClientOriginalName();
            $surat_name = pathinfo($surat, PATHINFO_FILENAME);
            $surat_name = $this->uploadFile2($request->file('surat_sakit'), $this->surat_path, '');
            return $surat_name;
        }
    }
}
