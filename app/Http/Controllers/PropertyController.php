<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Actions\Property\PropertyActionAction;
use App\Http\Requests\Property\PropertyUpdateRequest;
use App\Actions\Property\PropertyStoreAction;
use App\Actions\Property\PropertyUpdateAction;

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
     * @param $specificationId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($specificationId)
    {
        return view('admin.property.create', compact('specificationId'));
    }

    /**
     * Save property
     *
     * @param \App\Http\Requests\Property\PropertyUpdateRequest $request
     * @param \App\Actions\Property\PropertyStoreAction $action
     * @param string $specificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PropertyUpdateRequest $request, PropertyStoreAction $action, $specificationId)
    {
        $flash = $action->execute($request->validated(), $specificationId);

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.edit', compact('specificationId'));
    }

    /**
     * Return property edit view
     *
     * @param string $specificationId
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($specificationId, $id)
    {
        $property = $this->property->findOrFail($id);

        return view('admin.property.edit', compact('specificationId', 'property'));
    }

    /**
     * Update property
     *
     * @param \App\Http\Requests\Property\PropertyUpdateRequest $request
     * @param \App\Actions\Property\PropertyUpdateAction $action
     * @param string $specificationId
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyUpdateRequest $request, PropertyUpdateAction $action, $specificationId, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Property deleted!');
        return redirect()->route('specification.edit', compact('specificationId'));
    }
}
