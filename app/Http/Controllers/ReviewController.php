<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

// モデルクラス
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;

// ファサードクラス
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    // 商品レビューを作成する
    public function create($order_id, $product_id){
        $user_id = Auth::id();
        $order = Order::find($order_id);

        // 注文者とログインユーザーが一致しない場合はリダイレクトさせる
        if($order->user_id !== $user_id){
            return redirect()->route('mypage.order_detail', $order_id);
        }else{
            return view('mypage.review.create')
            ->with('product', Product::find($product_id))
            ->with('order_id', $order_id);
        }
    }

    // 商品レビューを登録する
    // StoreReviewRequestでバリデーションを行う
    public function store(StoreReviewRequest $request){

        DB::beginTransaction();
        try{
            Review::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
            ]);
            DB::commit();
            return redirect()->route('mypage.order_detail', $request->order_id)->with('success', '商品レビューを登録しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの登録に失敗しました');
        }
    }

    // 商品レビューを編集する
    public function product_review_edit($id){
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('product_id', $id)->first();
        if($review == null){
            return redirect()->route('product.index');
        }else{
            $product = Product::find($review->product_id);
            return view('product.review.edit')
                ->with('product', $product)
                ->with('review', $review);
        }
    }

    // 商品レビューを更新する
    // UpdateReviewRequestでバリデーションを行う
    public function product_review_update(UpdateReviewRequest $request, $id){

        DB::beginTransaction();
        try{
            Review::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.show', $request->product_id)->with('success', '商品レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの更新に失敗しました');
        }
    }

    // 商品レビューを編集する(マイページ用)
    // UpdateReviewRequestでバリデーションを行う
    public function mypage_review_edit($order_id, $product_id){
        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if($review == null){
            return redirect()->route('mypage.index');
        }else{
            $product = Product::find($review->product_id);
            return view('mypage.review.edit')
                ->with('product', $product)
                ->with('review', $review)
                ->with('order_id', $order_id);
        }
    }

    // 商品レビューを更新する(マイページ用)
    // UpdateReviewRequestでバリデーションを行う
    public function mypage_review_update(UpdateReviewRequest $request, $order_id, $review_id){

        DB::beginTransaction();
        try{
            Review::find($review_id)->update($request->all());
            DB::commit();
            return redirect()->route('mypage.order_detail', $request->order_id)->with('success', '商品レビューを更新しました');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', '商品レビューの更新に失敗しました');
        }
    }
}
