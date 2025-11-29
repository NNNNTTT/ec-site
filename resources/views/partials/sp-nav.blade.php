<style>
    .mask{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 999;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .mask.active{
        display: block;
    }
    .sp-nav{
        right: -30%;
        position: fixed;
        top: 0;
        width: 30%;
        height: 100vh;
        z-index: 1000;
        background-color: #fff;
        transition: all 0.3s;
    }
    .sp-nav.active{
        right: 0;
    }
    @media (max-width: 760px) {
        .sp-nav{
            right: -50%;
            width: 50%;
        }
    }
    @media (max-width: 430px) {
        .sp-nav{
            right: -60%;
            width: 60%;
        }
    }
</style>

<div class="mask d-xl-none"></div>

<div class="sp-nav p-4 d-xl-none">
    <h3 class="pb-3 mb-3" style="font-size: 1.5rem;">カテゴリー</h3>
    <ul class="list-unstyled">
        @foreach($product_categories as $product_category)
        <li class="pb-3 mb-3">
            <a href="{{ route('product.index', ['parent_slug' => $product_category->slug])}}" class="d-inline-block mb-2">{{ $product_category->name }}</a>
            <ul>
                @foreach($product_category->children as $child)
                <li><a href="{{ route('product.index', ['parent_slug' => $product_category->slug, 'category_slug' => $child->slug]) }}">{{ $child->name }}</a></li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</div>
