<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Website\HomeController;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::paginate(50));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'useremail' => 'nullable|email',
            'userimage' => 'nullable|string',
            'phonenumber' => 'nullable|string',
        ]);

        $customer = Customer::create($data);
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return response()->json($customer, 201);
    }

    public function show($id)
    {
        return response()->json(Customer::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $data = $request->validate([
            'username' => 'sometimes|string|max:255',
            'useremail' => 'nullable|email',
            'userimage' => 'nullable|string',
            'phonenumber' => 'nullable|string',
        ]);
        $customer->update($data);
        return response()->json($customer);
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return response()->json(null, 204);
    }
}
