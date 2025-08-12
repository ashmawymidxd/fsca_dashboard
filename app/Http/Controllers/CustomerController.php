<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/customers'), $imageName);
        }

        Customer::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'logo' => 'assets/images/customers/' . $imageName,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('pages.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
        ];

        // Handle image update
        if ($request->hasFile('logo')) {
            // Delete old image
            if (File::exists(public_path($customer->logo))) {
                File::delete(public_path($customer->logo));
            }

            // Upload new image
            $image = $request->file('logo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/customers'), $imageName);
            $data['logo'] = 'assets/images/customers/' . $imageName;
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        // Delete image
        if (File::exists(public_path($customer->logo))) {
            File::delete(public_path($customer->logo));
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');

        // Validate language parameter
        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        return response()->json(
            Customer::get([
                "name_$lang as name",
                'logo'
            ])->map(function ($customer) {
                return [
                    'name' => $customer->name,
                    'logo_url' => $customer->logo ? asset($customer->logo) : null
                ];
            })
        );
    }
}
