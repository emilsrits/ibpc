@if($parentCategories && $childCategories)
<button id="categories-collapse" type="button" class="collapsed" data-toggle="collapse" data-target="#categories-navigation" aria-expanded="false">
    <i class="fa fa-bars" aria-hidden="true"></i>
</button>
<div id="categories-navigation" class="collapse">
    <div class="categories-container">
        <ul class="cf">
            @foreach($parentCategories as $parent)
                <li class="dropdown-trigger">
                    <a href="#">{{ $parent->title }}</a>
                    <ul class="dropdown-content">
                        @foreach($childCategories as $child)
                            @if((int)$child->parent_id === (int)$parent->id)
                                <li>
                                    <a href="{{ url('/c', ['parent' => $parent->slug, 'child' => $child->slug]) }}">
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
