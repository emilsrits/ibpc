<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Actions\Attribute\AttributeActionAction;
use App\Http\Requests\Attribute\AttributeUpdateRequest;
use App\Actions\Attribute\AttributeStoreAction;
use App\Actions\Attribute\AttributeUpdateAction;

class AttributeController extends Controller
{
    /**
     * AttributeController constructor
     *
     * @param Attribute $attribute
     */
    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Attributes mass action
     *
     * @param \App\Http\Requests\Specification\SpecificationActionRequest $request
     * @param \App\Actions\Attribute\AttributeActionAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request, AttributeActionAction $action)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        return redirect()->back();
    }

    /**
     * Return attribute create view
     *
     * @param $specificationId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($specificationId)
    {
        return view('admin.attribute.create', compact('specificationId'));
    }

    /**
     * Save attribute
     *
     * @param \App\Http\Requests\Attribute\AttributeUpdateRequest $request
     * @param \App\Actions\Attribute\AttributeStoreAction $action
     * @param string $specificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttributeUpdateRequest $request, AttributeStoreAction $action, $specificationId)
    {
        $flash = $action->execute($request->validated(), $specificationId);

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.edit', compact('specificationId'));
    }

    /**
     * Return attribute edit view
     *
     * @param string $specificationId
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($specificationId, $id)
    {
        $attribute = $this->attribute->findOrFail($id);

        return view('admin.attribute.edit', compact('specificationId', 'attribute'));
    }

    /**
     * Update attribute
     *
     * @param \App\Http\Requests\Attribute\AttributeUpdateRequest $request
     * @param \App\Actions\Attribute\AttributeUpdateAction $action
     * @param string $specificationId
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttributeUpdateRequest $request, AttributeUpdateAction $action, $specificationId, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Attribute deleted!');
        return redirect()->route('specification.edit', compact('specificationId'));
    }
}
