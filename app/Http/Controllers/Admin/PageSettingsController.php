<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageSetting\StorePageSettingsRequest;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingsController extends Controller
{
    public function index()
    {

    }

    public function store(StorePageSettingsRequest $request)
    {
        $pages = $request->all()['pages'];
        foreach ($pages as  $key=>$value) {
            PageSetting::setValue($key,$value);
        }

        return $this->apiResponse(null);
    }
}
