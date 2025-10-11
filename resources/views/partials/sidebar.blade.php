<div class="sidebar p-4 col-2" style="background-color: #f8f9fa;">
    <h3 class="pb-3 mb-3">カテゴリー</h3>
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