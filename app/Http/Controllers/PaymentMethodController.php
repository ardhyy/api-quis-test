<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\PaymentsMethodModel as Payment;

class PaymentMethodController extends Controller
{
    public function index()
    {
        try {
            $payment = Payment::all();
            if ($payment->isEmpty()) {
                return response()->json(['message' => 'No payment methods found.'], 404);
            }
            return response()->json($payment, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to fetch payment methods', 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $paymentMethod = Payment::findOrFail($id);
            return response()->json($paymentMethod);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment method not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:125',
                'account_number' => 'required|string|max:55',
                'account_holder' => 'required|string|max:125',
            ]);

            $paymentMethod = Payment::create($validatedData);
            return response()->json(['message' => 'Payment method created successfully', 'data' => $paymentMethod]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create payment method'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|max:125',
                'account_number' => 'string|max:55',
                'account_holder' => 'string|max:125',
            ]);

            $paymentMethod = Payment::findOrFail($id);
            $paymentMethod->update($validatedData);

            return response()->json(['message' => 'Payment method updated successfully', 'data' => $paymentMethod]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update payment method'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $paymentMethod = Payment::findOrFail($id);
            $paymentMethod->delete();

            return response()->json(['message' => 'Payment method deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete payment method'], 500);
        }
    }
}
