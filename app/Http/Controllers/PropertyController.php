<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Specification;
use App\Services\PropertyService;
use App\Http\Requests\Property\PropertyStoreRequest;
use App\Http\Requests\Property\PropertyActionRequest;
use App\Http\Requests\Property\PropertyUpdateRequest;

class PropertyController extends Controller
{
    /**
     * PropertyController constructor
     *
     * @param PropertyService $propertyService
     * @param Property $property
     */
    public function __construct(PropertyService $propertyService, Property $property)
    {
        $this->propertyServoce = $propertyService;
        $this->property = $property;
    }

    /**
     * Properties mass action
     *
     * @param \App\Http\Requests\Specification\PropertyActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(PropertyActionRequest $request)
    {
        $action = $this->propertyServoce->action($request->validated());
        if ($action) {
            $request->session()->flash($this->propertyServoce->message['type'], $this->propertyServoce->message['content']);
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
     * @param Specification $specification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PropertyStoreRequest $request, Specification $specification)
    {
        $this->propertyServoce->store($request->validated(), $specification);

        $request->session()->flash($this->propertyServoce->message['type'], $this->propertyServoce->message['content']);
        return redirect()->route('specification.edit', compact('specification'));
    }

    /**
     * Return property edit view
     *
     * @param Specification $specification
     * @param Property $property
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Property $property)
    {
        return view('admin.property.edit', compact('property'));
    }

    /**
     * Update property
     *
     * @param \App\Http\Requests\Property\PropertyUpdateRequest $request
     * @param Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $action = $this->propertyServoce->update($request->except('_token'), $property);
        if ($action) {
            $request->session()->flash($this->propertyServoce->message['type'], $this->propertyServoce->message['content']);
            return redirect()->back();
        }

        $request->session()->flash($this->propertyServoce->message['type'], $this->propertyServoce->message['content']);
        return redirect()->route('specification.edit', ['specification' => $property->specification]);
    }
}
