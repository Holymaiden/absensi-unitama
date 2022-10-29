<?php

namespace App\Services;

use App\Repositories\Contracts\UserContract as UserRepo;
use App\Services\Contracts\UserContract;
use Illuminate\Support\Facades\Hash;
use App\Traits\Uploadable;

class UserService implements UserContract
{
    use Uploadable;

    protected $contractRepo;
    protected $image_path = 'uploads/karyawan';

    public function __construct(UserRepo $contractRepo)
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
        $input['created_by'] = auth()->user()->id;
        $input['password'] = Hash::make($input['password']);
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $image_name = pathinfo($image, PATHINFO_FILENAME);
            $image_name = $this->uploadFile2($request->file('image'), $this->image_path, '');
            $input['image'] = $image_name;
        }
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
        $data = $this->contractRepo->show($id);
        if ($input['password'] == '') {
            $input['password'] = $data->password;
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        if (!empty($request->image) && $request->hasFile('image')) {
            $this->deleteFile2($data->image, $this->image_path);
            $image = $request->file('image')->getClientOriginalName();
            $image_name = pathinfo($image, PATHINFO_FILENAME);
            $image_name = $this->uploadFile2($request->file('image'), $this->image_path, '');
            $input['image'] = $image_name;
        } else {
            $input['image'] = $input['image_old'];
        }
        return $this->contractRepo->update($input, $id);
    }

    /**
     * Delete Data By ID
     */
    public function delete($id)
    {
        $data = $this->contractRepo->show($id);
        $this->deleteFile2($data->image, $this->image_path);
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
}
