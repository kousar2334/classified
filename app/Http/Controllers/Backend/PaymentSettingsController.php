<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        return view('backend.modules.payment-settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'sslcommerz_store_id'       => 'nullable|string|max:200',
            'sslcommerz_store_password' => 'nullable|string|max:200',
            'sslcommerz_currency'       => 'nullable|string|max:10',
            'bank_name'                 => 'nullable|string|max:200',
            'bank_account_name'         => 'nullable|string|max:200',
            'bank_account_number'       => 'nullable|string|max:100',
            'bank_routing_number'       => 'nullable|string|max:100',
            'bank_branch'               => 'nullable|string|max:200',
            'bank_instructions'         => 'nullable|string|max:1000',
        ]);

        $keys = [
            'ssl_enabled',
            'sslcommerz_store_id',
            'sslcommerz_store_password',
            'sslcommerz_sandbox',
            'sslcommerz_currency',
            'bank_transfer_enabled',
            'bank_name',
            'bank_account_name',
            'bank_account_number',
            'bank_routing_number',
            'bank_branch',
            'bank_instructions',
        ];

        foreach ($keys as $key) {
            $value = $request->input($key);
            // Checkboxes: if not present in request, treat as 0
            if (in_array($key, ['ssl_enabled', 'sslcommerz_sandbox', 'bank_transfer_enabled'])) {
                $value = $request->has($key) ? 1 : 0;
            }
            set_setting($key, $value ?? '');
        }

        toastNotification('success', 'Payment settings updated successfully', 'Success');
        return redirect()->back();
    }
}
