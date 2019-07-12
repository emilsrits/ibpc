<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Specification;
use App\Actions\Property\PropertyStoreAction;
use App\Actions\Property\PropertyActionAction;
use App\Actions\Property\PropertyUpdateAction;
use App\Http\Requests\Property\PropertyStoreRequest;
use App\Http\Requests\Property\PropertyUpdateRequest;
use App\Http\Requests\Specification\SpecificationActionRequest;

class PropertyController extends Controller
{
    /**
     * PropertyController constructor
     *
     * @param Property $property
     */
    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Properties mass action
     *
     * @param \App\Http\Requests\Specification\SpecificationActionRequest $request
     * @param \App\Actions\Property\PropertyActionAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request, PropertyActionAction $action)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        return redirect()->back();
    }

    /**
     * Return property create view
     *
     * @param Specification $specification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Specification $specification)
    {
        return view('admin.property.create', compact('specification'));
    }

    /**
     * Save property
     *
     * @param \App\Http\Requests\Property\PropertyStoreRequest $request
     * @param \App\Actions\Property\PropertyStoreAction $action
     * @param Specification $specification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PropertyStoreRequest $request, PropertyStoreAction $action, Specification $specification)
    {
        $flash = $action->execute($request->validated(), $specification);

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.edit', compact('specification'));
    }

    /**
     * Return property edit view
     *
     * @param Specification $specification
     * @param Property $property
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Specification $specification, Property $property)
    {
        return view('admin.property.edit', compact('specification', 'property'));
    }

    /**
     * Update property
     *
     * @param \App\Http\Requests\Property\PropertyUpdateRequest $request
     * @param \App\Actions\Property\PropertyUpdateAction $action
     * @param Specification $specification
     * @param Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyUpdateRequest $request, PropertyUpdateAction $action, Specification $specification, Property $property)
    {
        $flash = $action->execute($request->all(), $property);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Property deleted!');
        return redirect()->route('specification.edit', compact('specification'));
    }
}
