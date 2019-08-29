<?php

namespace App\Http\Controllers;

use App\Admin\Tables\PropertyTable;
use App\Admin\Tables\SpecificationTable;
use Illuminate\Http\Request;
use App\Models\Specification;
use App\Services\SpecificationService;
use App\Http\Requests\Specification\SpecificationStoreRequest;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Http\Requests\Specification\SpecificationUpdateRequest;
use App\Repositories\SpecificationRepository;
use App\Traits\PaginatesModels;

class SpecificationController extends Controller
{
    use PaginatesModels;
    
    /**
     * SpecificationController constructor
     *
     * @param SpecificationService $specificationService
     * @param SpecificationRepository $specificationRepository
     * @param SpecificationTable $specificationTable
     * @param PropertyTable $propertyTable
     */
    public function __construct(
        SpecificationService $specificationService,
        SpecificationRepository $specificationRepository,
        SpecificationTable $specificationTable,
        PropertyTable $propertyTable
    ) {
        $this->specificationService = $specificationService;
        $this->specificationRepository = $specificationRepository;
        $this->specificationTable = $specificationTable;
        $this->propertyTable = $propertyTable;
    }

    /**
     * Return specifications view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if($this->setSessionPageSize()) {
            return response()->json(array('redirectUrl'=> request()->url()), 200);
        }
        
        $specifications = $this->specificationRepository->paginate();
        $table = $this->specificationTable;

        return view('admin.specification.specifications', compact('specifications', 'table'));
    }

    /**
     * Specification mass action
     *
     * @param \App\Http\Requests\Specification\SpecificationActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request)
    {
        $this->specificationService->action($request->validated());

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
        $table = $this->propertyTable;

        return view('admin.specification.edit', compact('specification', 'table'));
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

        if ($async) {
            return response()->json(array('redirectUrl'=> route('specification.index')), 200);
        }
        
        return redirect()->route('specification.index');
    }
}
