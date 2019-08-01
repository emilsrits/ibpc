<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specification;
use App\Services\SpecificationService;
use App\Http\Requests\Specification\SpecificationStoreRequest;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Http\Requests\Specification\SpecificationUpdateRequest;

class SpecificationController extends Controller
{
    /**
     * SpecificationController constructor
     *
     * @param SpecificationService $specificationService
     * @param Specification $specification
     */
    public function __construct(SpecificationService $specificationService, Specification $specification)
    {
        $this->specificationService = $specificationService;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request)
    {
        $action = $this->specificationService->action($request->validated());
        if ($action) {
            $request->session()->flash($this->specificationService->message['type'], $this->specificationService->message['content']);
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
     * @param \App\Http\Requests\Specification\SpecificationStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SpecificationStoreRequest $request)
    {
        $this->specificationService->store($request->validated());

        $request->session()->flash($this->specificationService->message['type'], $this->specificationService->message['content']);
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
     * @param Specification $specification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SpecificationUpdateRequest $request, Specification $specification)
    {
        $this->specificationService->update($request->validated(), $specification);

        $request->session()->flash($this->specificationService->message['type'], $this->specificationService->message['content']);
        return redirect()->back();
    }

    /**
     * Delete specification
     *
     * @param Request $request
     * @param Specification $specification
     * @return mixed
     */
    public function delete(Request $request, Specification $specification)
    {
        $async = $request->wantsJson();

        $this->specificationService->delete($specification);

        $request->session()->flash($this->specificationService->message['type'], $this->specificationService->message['content']);

        if ($async) {
            return response()->json(array('redirectUrl'=> route('specification.index')), 200);
        }
        return redirect()->route('specification.index');
    }
}
