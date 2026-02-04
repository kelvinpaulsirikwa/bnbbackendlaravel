<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\ChecksAdminPermission;

abstract class AdminBaseController extends Controller
{
    use ChecksAdminPermission;

    public function __construct()
    {
        $this->authorizeAdminRoute();
    }
}
