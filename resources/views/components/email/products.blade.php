@props(['products'])
<table>
    <thead>
        <tr>
            <th class="empty-heading"></th>
            <th class="product-heading">@lang('Product')</th>
            <th class="price-heading">@lang('Price')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td class="product-image">
                    <a href="{{ config('app.url').$product->url }}">
                        <img
                            src="{{ config('app.url').'/storage/' . config('rapidez.store') . '/resizes/80x80/magento/catalog/product'.$product->thumbnail.'.webp' }}"
                            alt="{{ $product->name }}"
                        >
                    </a>
                </td>
                <td class="product-name">
                    <a class="product-link" href="{{ config('app.url').$product->url }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td class="price">
                    <p>&euro; {{ str_replace(',00', ',-', number_format($product->special_price ?? $product->price, 2, ',', '.')) }}</p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
