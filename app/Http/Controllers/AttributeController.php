<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * AttributeController constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
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
     * @param Request $request
     * @param $specificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $specificationId)
    {
        if ($request['name']) {
            $attribute = new Attribute();
            $attribute->specification_id = $specificationId;
            $attribute->name = $request['name'];
            $attribute->save();

            $request->session()->flash('message-success', 'Attribute successfully created!');
        } else {
            $request->session()->flash('message-danger', 'Missing attribute name!');
        }

        return redirect()->route('specification.edit', ['specificationId' => $specificationId]);
    }

    /**
     * Return attribute edit view
     *
     * @param $specificationId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($specificationId, $id)
    {
        $attribute = Attribute::find($id);

        return view('admin.attribute.edit', [
            'specificationId' => $specificationId,
            'attribute' => $attribute
        ]);
    }

    /**
     * Update attribute
     *
     * @param Request $request
     * @param $specificationId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $specificationId, $id)
    {
        // Delete attribute
        if ($request['submit'] === 'delete') {
            $attribute = new Attribute();
            $attribute->deleteAttribute($id);

            $request->session()->flash('message-success', 'Attribute deleted!');
            return redirect()->route('specification.edit', ['specificationId' => $specificationId]);
        }

        // Update attribute
        if ($request['submit'] === 'save') {
            $attribute = Attribute::find($id);

            if ($request['name'] != $attribute->name) {
                if ($this->attributeExists($request['name'])) {
                    $request->session()->flash('message-danger', 'Attribute with this name already exists!');
                    return redirect()->back();
                } else {
                    $attribute->name = $request['name'];
                }
            }
            $attribute->save();

            $request->session()->flash('message-success', 'Attribute successfully updated!');
            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
    }

    /**
     * Delete attribute
     *
     * @param $id
     */
    public function delete($id)
    {
        $attribute = new Attribute();
        $attribute->deleteAttribute($id);
    }

    /**
     * Attributes mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function massAction(Request $request)
    {
        $attributeIds = $request->input('attributes');
        $attribute = new Attribute();

        switch ($request->input('mass-action')) {
            case 1:
                $attribute->deleteAttribute($attributeIds);
                $request->session()->flash('message-success', 'Attribute(s) deleted!');
                break;
        }

        return redirect()->back();
    }

    /**
     * Check if attribute exists
     *
     * @param $name
     * @return mixed
     */
    protected function attributeExists($name)
    {
        return $attribute = Attribute::where('name', $name)->exists();
    }
}
