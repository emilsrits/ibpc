@if($parentCategories)
<aside id="categorize">
    @foreach($parentCategories as $parent)
        <div class="category is-active">
            <div class="category-header">
                <a class="category-toggle">
                    <span class="icon">
                        <i class="fa fa-angle-down"></i>
                    </span>
                </a>
                <a class="category-name">
                    {{ $parent->title }}
                </a>
            </div>
            @if($parent->children())
                <ul class="category-list">
                    @foreach($parent->children as $child)
                    <li>
                        <a href="{{ url('/c', ['parent' => $parent->slug, 'child' => $child->slug]) }}">
                            {{ $child->title }} <span>({{ count($child->products) }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</aside>
@endif