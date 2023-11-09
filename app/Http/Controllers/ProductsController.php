<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel as Products;
use App\Models\ProductsVariantModel as ProductsVariant;

class ProductsController extends Controller
{
    public function index()
    {
        try {
            $products = Products::with(['variants' => function ($query) {
                $query->select('name', 'additional_price', 'products');
            }])->select('id', 'name', 'desc', 'price')->get();

            if ($products->isEmpty()) {
                return response()->json(['message' => 'No products found.'], 404);
            }

            $combine = $products->map(function ($product) {
                $variants = $product->variants->map(function ($variant) {
                    unset($variant->products);
                    return $variant;
                });

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->desc,
                    'price' => number_format($product->price, 0, ',', '.'),
                    'variants' => $variants,
                ];
            });

            return response()->json($combine, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to fetch products', 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $product = Products::with(['variants' => function ($query) {
                $query->select('name', 'additional_price', 'products');
            }])->select('id', 'name', 'desc', 'price')->find($id);

            if (!$product) {
                return response()->json(['message' => 'No product found.'], 404);
            }

            $variants = $product->variants->map(function ($variant) {
                unset($variant->products);
                return $variant;
            });

            $response = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->desc,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'variants' => $variants,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed show Products', 'message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'desc' => 'string',
            'price' => 'required|numeric',
            'variants' => 'array',
        ]);

        try {
            $product = Products::create($request->only(['name', 'desc', 'price']));

            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variant) {
                    ProductsVariant::create([
                        'products' => $product->id,
                        'name' => $variant['name'],
                        'additional_price' => $variant['additional_price'],
                    ]);
                }
            }
            return response()->json(['message' => 'Product created successfully', 'data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to create products', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Products::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $request->validate([
                'name' => 'string',
                'desc' => 'string',
                'price' => 'numeric',
            ]);

            $product->update($request->only(['name', 'desc', 'price']));

            if ($request->has('variants') && is_array($request->variants)) {
                ProductsVariant::where('products', $product->id)->delete();

                foreach ($request->variants as $variant) {
                    ProductsVariant::create([
                        'products' => $product->id,
                        'name' => $variant['name'],
                        'additional_price' => $variant['additional_price'],
                    ]);
                }
            }

            return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to update products', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Products::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $product->variants()->delete();
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => 'Failed to delete products', 'message' => $e->getMessage()]);
        }
    }
}
