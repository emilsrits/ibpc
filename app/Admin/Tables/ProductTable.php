<?php

namespace App\Admin\Tables;

use App\Admin\Inputs\NumberInput;
use App\Admin\Inputs\SelectInput;
use App\Admin\Inputs\TextInput;
use App\Admin\Tables\Table;
use App\Repositories\CategoryRepository;
use Illuminate\Container\Container as App;

class ProductTable extends Table
{
    /**
     * ProductTable constructor
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository, App $app)
    {
        $this->categoryRepository = $categoryRepository;
        
        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Product';
    }

    /**
     * Specify table slug
     *
     * @return string
     */
    function slug()
    {
        return 'product';
    }

    /**
     * Add columns to the table
     */
    function addColumns()
    {
        $this->columnSet->add('id', '#ID')
            ->filter(new NumberInput('id'))
            ->width('100px');

        $this->columnSet->add('title', 'Title')
            ->filter(new TextInput('title'));
        
        $this->columnSet->add('code', 'Code')
            ->filter(new TextInput('code'));

        $this->columnSet->add('price_parsed', 'Price');

        $this->columnSet->add('stock', 'Stock');

        $this->columnSet->add('full_status', 'Status')
            ->filter(new SelectInput('status', [
                '1' => 'Enabled',
                '0' => 'Disabled'
            ]));

        $this->columnSet->add('category_title', 'Category')
            ->filter(new SelectInput('category', arrayFromCollection($this->categoryRepository->child()->get(), 'id', 'title')));

        $this->columnSet->add('created_at', 'Created')
            ->filter(new TextInput('createdAt'));

        $this->columnSet->add('updated_at', 'Updated')
            ->filter(new TextInput('updatedAt'));
    }
}
