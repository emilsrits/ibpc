@if($parentCategories && $childCategories)
<div id="categories-navigation">
    <div class="categories-container">
        <ul class="cf">
            @foreach($parentCategories as $parent)
                <li class="dropdown-trigger">
                    <a href="#">{{ $parent->title }}</a>
                    <ul class="dropdown-content">
                        @foreach($childCategories as $child)
                            @if($child->parent_id === $parent->id)
                                <li>
                                    <a href="{{ url('/store', ['parent' => $parent->slug, 'child' => $child->slug]) }}">
                                        {{ $child->title }} <span>({{ count($child->products) }})</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
