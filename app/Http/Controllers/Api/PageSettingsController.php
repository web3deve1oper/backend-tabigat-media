<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingsController extends Controller
{
    public function index(Request $request)
    {
        $page = PageSetting::getValue($request->key);

        return $this->apiResponse($page);
    }
}
