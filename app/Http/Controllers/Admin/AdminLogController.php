<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\BnbUser;
use Illuminate\Http\Request;

class AdminLogController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = AdminLog::query()->with('adminUser');

        if ($request->filled('admin_user_id')) {
            $query->where('admin_user_id', $request->admin_user_id);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->input('method'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'date');
        if ($sort === 'user') {
            $query->orderBy('admin_user_id')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $logs = $query->paginate(20)->withQueryString();

        $adminUsers = BnbUser::where('role', 'bnbadmin')
            ->orderBy('username')
            ->get(['id', 'username', 'useremail']);

        return view('adminpages.admin-logs.index', compact('logs', 'adminUsers'));
    }

    public function show(AdminLog $admin_log)
    {
        $admin_log->load('adminUser');
        return view('adminpages.admin-logs.show', compact('admin_log'));
    }
}
