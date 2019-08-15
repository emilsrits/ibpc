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
                @foreach($parent->children as $child)
                    <ul class="category-list">
                        <li>
                            <a href="{{ url('/c', ['parent' => $parent->slug, 'child' => $child->slug]) }}">
                                {{ $child->title }} <span>({{ count($child->products) }})</span>
                            </a>
                        </li>
                    </ul>
                @endforeach
            @endif
        </div>
    @endforeach
</aside>
@endif