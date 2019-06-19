<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Actions\Attribute\AttributeActionAction;
use App\Http\Requests\Attribute\AttributeUpdateRequest;
use App\Actions\Attribute\AttributeStoreAction;
use App\Actions\Attribute\AttributeUpdateAction;

class AttributeController extends Controller
{
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
        return view('admin.attribute.create', [
            'specificationId' => $specificationId
        ]);
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
        $flash = $action->execute($request->all(), $specificationId);

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.edit', ['specificationId' => $specificationId]);
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
        $attribute = Attribute::findOrFail($id);

        return view('admin.attribute.edit', [
            'specificationId' => $specificationId,
            'attribute' => $attribute
        ]);
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
        return redirect()->route('specification.edit', ['specificationId' => $specificationId]);
    }
}
