<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const STORAGE_ACCESS_PRODUCT_MEDIA_PATH = '/storage/media/products/';
    const STORAGE_SAVE_PRODUCT_MEDIA_PATH = '/public/media/products/';
    const DEFAULT_PRODUCT_MEDIA_PATH = '/media/products/default.png';

    /**
     * The properties that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'path', 'caption'
    ];

    /**
     * All of the relationships to be touched
     *
     * @var array
     */
    protected $touches = ['product'];

    /**
     * OneToMany inverse relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Store product media locally and return its path
     *
     * @param UploadedFile $file
     * @param Product $product
     * @return string
     */
    public function storeMedia(UploadedFile $file, Product $product)
    {
        $fileExt =  $file->guessClientExtension();
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $categoryId = $product->categories->first()->id;
        $generatedName = $product->code . '-' . $fileName . str_random(4) . '.' . $fileExt;
        $file->storeAs(self::STORAGE_SAVE_PRODUCT_MEDIA_PATH . $categoryId . '/', $generatedName);

        return self::STORAGE_ACCESS_PRODUCT_MEDIA_PATH . $categoryId . '/' . $generatedName;
    }
}
