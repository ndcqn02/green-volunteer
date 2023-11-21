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
    public function getAllforms($page = 1, $pageSize = null, $status = null)
    {
        $query = form::query();
        $pageSize = $pageSize ?? $query->count();
        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->paginate($pageSize, ['*'], 'page', $page);

    }

    public function getformById($formId)
    {
        $form = form::find($formId);
        if($form){
            return $form;
        }
        return false;
    }

    public function createForm($data)
    {
        $result = form::create($data ->all());
        return $result;
    }

    public function updateForm($data)
    {
        $form = form::findOrFail($data['id']);

        if ($form) {
            $result = $form->update($data -> all());
            return $result;
        }
        return false;
    }

    public function softDeleteForm($formId)
    {
        $form = form::find($formId);

        if ($form) {
            $result = form::destroy($formId);
            return $result;
        }
        return false;
    }

}
