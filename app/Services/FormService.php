<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\form;
use Illuminate\Database\Eloquent\SoftDeletes;
use LDAP\Result;

class FormService
{
    public function getAllforms($page = 1, $pageSize = 10, $status = null)
    {
        $query = form::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->paginate($pageSize, ['*'], 'page', $page);

    }

    public function getformById($formId)
    {
        $Id = form::find($formId);
        if($Id){
            return $Id;
        }
        return false;
    }

    public function createform($data)
    {
        return form::create($data);
    }

    public function updateform($formId, $data)
    {
        $form = form::find($formId);

        if ($form) {
            return $form->update($data);;
        }
        return false;
    }

    public function softDeleteform($formId)
    {
        $form = form::find($formId);

        if ($form) {
            $result = form::destroy($formId);
            return $result;
        }
        return false;
    }

}
