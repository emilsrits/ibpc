<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
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
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * Properties mass action
     *
     * @param \App\Http\Requests\Specification\PropertyActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(PropertyActionRequest $request)
    {
        $this->propertyService->action($request->validated());

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
        $this->propertyService->store($request->validated(), $specification);

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
        $this->propertyService->update($request->validated(), $property);

        return redirect()->back();
    }

    /**
     * Delete property
     *
     * @param Request $request
     * @param Property $property
     * @return mixed
     */
    public function delete(Request $request, Property $property)
    {
        $async = $request->wantsJson();

        $this->propertyService->delete($property);

        if ($async) {
            return response()->json(array('redirectUrl'=> route('specification.edit', ['specification' => $property->specification])), 200);
        }

        return redirect()->route('specification.edit', ['specification' => $property->specification]);
    }
}
