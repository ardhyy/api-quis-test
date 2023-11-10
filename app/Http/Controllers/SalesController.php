<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\ProductsVariantModel as ProductsVariant;
use App\Models\SalesModel as Sales;
use App\Models\CartModel as Cart;
use App\Models\PaymentsMethodModel as Payment;

class SalesController extends Controller
{
    public function index()
    {
        try {
            $salesData = $this->getAllSalesData();

            $formattedSales = [];

            foreach ($salesData as $salesItem) {
                $formattedSale = [
                    'id' => $salesItem->id,
                    'cart' => $this->formatCartData([$salesItem]),
                    'total' => $salesItem->total_price,
                    'created' => $salesItem->created_at->format('j F Y H:i:s'),
                    'payment_method' => $salesItem->payment_method_name,
                ];

                $formattedSales[] = $formattedSale;
            }

            return response()->json($formattedSales);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $salesData = $this->getSalesDataByID($id);

            $formattedSale = [
                'id' => $salesData[0]->id,
                'cart' => $this->formatCartData($salesData),
                'total' => number_format($salesData[0]->total_price, 0, ',', '.'),
                'created' => $salesData[0]->created_at->format('j F Y H:i:s'),
                'payment_method' => $salesData[0]->payment_method_name,
            ];

            return response()->json($formattedSale);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['code' => 404, 'message' => 'Sale not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'payment' => 'required|exists:payment_methods,name',
                'cart' => 'required|array',
                'cart.*.product_id' => 'required|exists:products,id',
                'cart.*.price' => 'required|numeric',
                'cart.*.variants' => 'array',
                'cart.*.variants.*' => 'string|distinct|exists:products_variant,name',
            ]);

            $idSales = 'S-' . now()->format('ymd-His');
            $paymentName = $validatedData['payment'];
            $payment = Payment::where('name', $paymentName)->firstOrFail();

            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $sale = Sales::create([
                'id' => $idSales,
                'total_price' => 0,
                'payment' => $payment->id,
            ]);

            $totalPrice = 0;

            foreach ($validatedData['cart'] as $cartItemData) {
                $product_id = $cartItemData['product_id'];
                $price = $cartItemData['price'];

                $cartItem = new Cart([
                    'sales_id' => $sale->id,
                    'products_id' => $product_id,
                    'price' => $price,
                ]);
                $cartItem->save();

                $totalPrice += $price;

                if (isset($cartItemData['variants']) && is_array($cartItemData['variants'])) {
                    foreach ($cartItemData['variants'] as $variantName) {
                        $variant = ProductsVariant::firstOrCreate(['products' => $product_id, 'name' => $variantName]);
                        $totalPrice += $variant->additional_price;
                        $cartItem->variants()->attach($variant->id);
                    }
                }
            }

            $sale->total_price = $totalPrice;
            $sale->save();

            return response()->json(['message' => 'Sale created successfully', 'data' => $sale]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create sale', 'message' => $e->getMessage()], 500);
        }
    }

    // function private

    private function getAllSalesData()
    {
        return Sales::select(
            'sales.id',
            'sales.total_price',
            'sales.created_at',
            'payment_methods.name as payment_method_name',
            'cart.price as cart_price',
            'products.id as product_id',
            'products.name as product_name',
            'products_variant.name as variant_name',
            'products_variant.additional_price as variant_price'
        )
            ->join('payment_methods', 'sales.payment', '=', 'payment_methods.id')
            ->join('cart', 'sales.id', '=', 'cart.sales_id')
            ->leftJoin('products', 'cart.products_id', '=', 'products.id')
            ->leftJoin('cart_variant_products', 'cart.id', '=', 'cart_variant_products.cart_id')
            ->leftJoin('products_variant', 'cart_variant_products.variant_products_id', '=', 'products_variant.id')
            ->get();
    }

    private function getSalesDataByID($id)
    {
        return Sales::select(
            'sales.id',
            'sales.total_price',
            'sales.created_at',
            'payment_methods.name as payment_method_name',
            'cart.price as cart_price',
            'products.id as product_id',
            'products.name as product_name',
            'products_variant.name as variant_name',
            'products_variant.additional_price as variant_price'
        )
            ->where('sales.id', $id)
            ->join('payment_methods', 'sales.payment', '=', 'payment_methods.id')
            ->join('cart', 'sales.id', '=', 'cart.sales_id')
            ->leftJoin('products', 'cart.products_id', '=', 'products.id')
            ->leftJoin('cart_variant_products', 'cart.id', '=', 'cart_variant_products.cart_id')
            ->leftJoin('products_variant', 'cart_variant_products.variant_products_id', '=', 'products_variant.id')
            ->get();
    }

    private function formatCartData($salesData)
    {
        $formattedCart = [];

        foreach ($salesData as $item) {
            $productId = $item->product_id;

            if (!isset($formattedCart[$productId])) {
                $formattedCart[$productId] = [
                    'product_id' => $item->product_id,
                    'price' => number_format($item->cart_price, 0, ',', '.'),
                ];
            }

            if (!is_null($item->product_name) && !is_null($item->variant_name)) {
                if (!isset($formattedCart[$productId]['variants'])) {
                    $formattedCart[$productId]['variants'] = [];
                }

                $variant = [
                    'variant_name' => $item->variant_name,
                    'price' => number_format($item->variant_price, 0, ',', '.'),
                ];

                $formattedCart[$productId]['variants'][] = $variant;
            }
        }

        return array_values($formattedCart);
    }
}
