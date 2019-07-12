<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Http\Requests\Specification\SpecificationUpdateRequest;
use App\Actions\Specification\SpecificationStoreAction;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Actions\Specification\SpecificationActionAction;
use App\Actions\Specification\SpecificationUpdateAction;

class SpecificationController extends Controller
{
    /**
     * SpecificationController constructor
     *
     * @param Specification $specification
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Return specifications view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $specifications = $this->specification->paginate(20);

        return view('admin.specification.specifications', compact('specifications'));
    }

    /**
     * Specification mass action
     *
     * @param \App\Http\Requests\Specification\SpecificationActionRequest $request
     * @param \App\Actions\Specification\SpecificationActionAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request, SpecificationActionAction $action)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        return redirect()->back();
    }

    /**
     * Return specification create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.specification.create');
    }

    /**
     * Save a specification
     *
     * @param \App\Http\Requests\Specification\SpecificationUpdateRequest $request
     * @param \App\Actions\Specification\SpecificationStoreAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SpecificationUpdateRequest $request, SpecificationStoreAction $action)
    {
        $flash = $action->execute($request->all());

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.index');
    }

    /**
     * Return specification edit view
     *
     * @param Specification $specification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Specification $specification)
    {
        return view('admin.specification.edit', compact('specification'));
    }

    /**
     * Update specification
     *
     * @param \App\Http\Requests\Specification\SpecificationUpdateRequest $request
     * @param \App\Actions\Specification\SpecificationUpdateAction $action
     * @param Specification $specification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SpecificationUpdateRequest $request, SpecificationUpdateAction $action, Specification $specification)
    {
        $flash = $action->execute($request->except('_token'), $specification);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Property group deleted!');
        return redirect()->route('specification.index');
    }
}
