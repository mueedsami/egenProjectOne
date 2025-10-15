<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Step 1: Initiate Payment Session
     */
    public function pay(Request $request)
    {
        $post_data = [];
        $post_data['store_id'] = env('SSLCZ_STORE_ID');
        $post_data['store_passwd'] = env('SSLCZ_STORE_PASSWD');
        $post_data['total_amount'] = $request->amount ?? 100;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid('deshio_'); // unique transaction id

        // Customer info (you can replace with checkout data)
        $post_data['cus_name'] = auth()->user()->name ?? 'Test Customer';
        $post_data['cus_email'] = auth()->user()->email ?? 'customer@example.com';
        $post_data['cus_add1'] = 'Dhaka';
        $post_data['cus_city'] = 'Dhaka';
        $post_data['cus_postcode'] = '1207';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = '01700000000';

        // Shipment Info
        $post_data['ship_name'] = "Deshio";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_postcode'] = "1207";
        $post_data['ship_country'] = "Bangladesh";

        // Redirect URLs
        $post_data['success_url'] = url('/payment/success');
        $post_data['fail_url'] = url('/payment/fail');
        $post_data['cancel_url'] = url('/payment/cancel');

        // API URL (Session)
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if ($code == 200 && $content) {
            $response = json_decode($content, true);
            if (isset($response['GatewayPageURL']) && $response['GatewayPageURL'] != "") {
                return redirect()->away($response['GatewayPageURL']);
            } else {
                return back()->with('error', 'Failed to create payment session.');
            }
        }

        return back()->with('error', 'Failed to connect to SSLCommerz.');
    }

    /**
     * Step 2: Handle Payment Success + Validation API Check
     */
    public function success(Request $request)
    {
        $val_id = urlencode($request->val_id);
        $store_id = env('SSLCZ_STORE_ID');
        $store_passwd = env('SSLCZ_STORE_PASSWD');

        $validation_url = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id={$val_id}&store_id={$store_id}&store_passwd={$store_passwd}&v=1&format=json";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $validation_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        curl_close($handle);

        $result = json_decode($result);

        if ($result && isset($result->status) && $result->status == "VALID") {
            // ✅ Verified Payment
            return view('payment.success', ['data' => $result]);
        } else {
            // ❌ Invalid or failed validation
            return view('payment.fail', ['message' => 'Validation failed.']);
        }
    }

    public function fail()
    {
        return view('payment.fail', ['message' => 'Payment failed.']);
    }

    public function cancel()
    {
        return view('payment.cancel', ['message' => 'Payment cancelled by user.']);
    }
}
