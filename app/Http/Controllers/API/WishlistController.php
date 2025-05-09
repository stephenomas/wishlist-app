<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishList\StoreRequest;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->wishlist
        ]);
    }

    public function store(StoreRequest $request)
    {

        $request->user()->wishlist()->create($request->all());

        return response()->json(['message' => 'Added to wishlist']);
    }

    public function destroy(Request $request, $productId)
    {
        $wishlist = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Removed from wishlist']);
        }

        return response()->json(['message' => 'Product not in your wishlist'], 404);
    }
}
