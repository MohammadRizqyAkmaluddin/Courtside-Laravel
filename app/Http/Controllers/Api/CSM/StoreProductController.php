<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\StoreCart;
use App\Models\StoreProduct;
use App\Models\StoreTransaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreProductController extends Controller
{
    public function indexProduct(Request $request)
    {
        $data = StoreProduct::where('venue_id', Auth::id());

        if ($request->filled('search')) {
            $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $data->where('product_type', $request->type);
        }
        if ($request->filled('stock')) {
            if ($request->stock == 'available') {
                $data->where('stock', '>=', 1);
            } elseif ($request->stock == 'unavailable') {
                $data->where('stock', '<', 1);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data->get()
        ]);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'product_type' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = Str::random(20) . '.' . $extension;
            $file->storeAs('public/product', $imageName);
        }

        $data = StoreProduct::create([
            'venue_id' => Auth::id(),
            'product_type' => $request->product_type,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName
        ]);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function addStock(Request $request)
    {
        $initialStock = StoreProduct::where('id', $request->id)->first();


        StoreProduct::where('id', $request->id)
            ->update(['stock' => ($initialStock->stock + $request->stock)]);

        $finalStock = StoreProduct::where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'added' => $request->stock,
                'initial' => $initialStock,
                'final' => $finalStock
            ]
        ]);
    }

    public function changePrice(Request $request)
    {
        StoreProduct::where('id', $request->id)
            ->update(['price' => $request->price]);

        $data = StoreProduct::where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function removeProduct(Request $request)
    {

        $data = StoreProduct::where('id', $request->id)->first();
        StoreProduct::where('id', $request->id)->delete();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'addQuantity' => 'nullable',
            'minQuantity' => 'nullable'
        ]);

        $existsCart = StoreCart::where('venue_id', Auth::id())
            ->where('store_product_id', $request->product_id)->first();

        if ($existsCart) {
            $item = StoreCart::where('venue_id', Auth::id())->where('store_product_id', $request->product_id);

            if ($request->addQuantity == 1) {

                $newQty = $existsCart->quantity + 1;
            } elseif ($request->minQuantity == 1) {

                $newQty = $existsCart->quantity - 1;

                if ($newQty <= 0) {
                    $existsCart->delete();
                    return response()->json(['success' => true]);
                }
            } elseif ($request->quantity !== null) {

                $newQty = $request->quantity;
            } else {
                $newQty = $existsCart->quantity;
            }

            $existsCart->update([
                'quantity' => $newQty,
                'subtotal' => $existsCart->unit_price * $newQty
            ]);
        } else {
            $product = StoreProduct::where('id', $request->product_id)->first();
            StoreCart::create([
                'venue_id' => Auth::id(),
                'store_product_id' => $request->product_id,
                'unit_price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product Added Successfully'
        ]);
    }

    public function removeCart()
    {
        StoreCart::where('venue_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'successfully removed cart'
        ]);
    }

    public function indexCart()
    {
        $data = StoreCart::where('venue_id', Auth::id())
            ->with('product')
            ->get();

        $total_price = $data->sum('subtotal');

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_price' => $total_price
        ]);
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $cart = StoreCart::where('venue_id', Auth::id())->get();
            $total_price = $cart->sum('subtotal');

            $transaction = StoreTransaction::create([
                'venue_id' => Auth::id(),
                'total_price' => $total_price,
                'payment_method' => $request->payment_method,
            ]);

            $itemData = [];

            foreach ($cart as $items) {
                $itemData[] = TransactionItem::create([
                    'store_transaction_id' => $transaction->id,
                    'store_product_id' => $items->store_product_id,
                    'unit_price' => $items->unit_price,
                    'quantity' => $items->quantity,
                    'subtotal' => $items->subtotal
                ]);

                $product = StoreProduct::where('id', $items->store_product_id);
                $products = $product->first();
                $product->update(['stock' => $products->stock - $items->quantity]);
            }

            StoreCart::where('venue_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'header' => $transaction,
                    'item' => $itemData
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
