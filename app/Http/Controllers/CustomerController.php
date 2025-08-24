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
        $customers = Customer::orderBy('order')->get();
        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        $nextOrder = Customer::max('order') + 1;
        return view('pages.customers.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/customers'), $imageName);
        }

        $nextOrder = Customer::max('order') + 1;

        Customer::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'logo' => 'assets/images/customers/' . $imageName,
            'order' => $nextOrder,
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

        if ($request->hasFile('logo')) {
            if (File::exists(public_path($customer->logo))) {
                File::delete(public_path($customer->logo));
            }

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
        if (File::exists(public_path($customer->logo))) {
            File::delete(public_path($customer->logo));
        }

        $customer->delete();
        $this->reorderCustomers();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'customers.*' => 'exists:customers,id',
        ]);

        foreach ($request->customers as $index => $customerId) {
            Customer::where('id', $customerId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderCustomers()
    {
        $customers = Customer::orderBy('order')->get();

        foreach ($customers as $index => $customer) {
            $customer->update(['order' => $index + 1]);
        }
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');

        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        return response()->json(
            Customer::orderBy('order')->get([
                "name_$lang as name",
                'logo',
                'order'
            ])->map(function ($customer) {
                return [
                    'name' => $customer->name,
                    'logo_url' => $customer->logo ? asset($customer->logo) : null,
                    'order' => $customer->order,
                ];
            })
        );
    }
}
