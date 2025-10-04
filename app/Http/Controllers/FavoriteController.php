<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // お気に入りのボタンを押した時の処理
    public function index(Request $request)
    {
        if($request->input('type') == 'auth'){
            $user = Auth::user();
            $user_id = $user->id;
            $favoriteProducts = $user->favorites;
            return view('favorite.index', compact('favoriteProducts'));
        }else if($request->input('type') == 'guest'){
            $favorites_json = $request->input('favorites');
            $favorites = json_decode($favorites_json, true);
            $favoriteProducts = [];
            foreach ($favorites as $favorite) {
                $favoriteProducts[] = Product::find($favorite);
            }
            return view('favorite.index', compact('favoriteProducts'));
        }
    }

    public function store(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $product->favorites()->attach(Auth::id());
        $favoritecount = Auth::user()->favorites()->count();
        return response()->json(['success' => true, 'favoritecount' => $favoritecount]);
    }

    public function destroy(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $product->favorites()->detach(Auth::id());
        $favoritecount = Auth::user()->favorites()->count();
        return response()->json(['success' => true, 'favoritecount' => $favoritecount]);
    }
}
