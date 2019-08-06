<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_media_file()
    {
        $file = UploadedFile::fake()->image('picture.jpg');
        $product = $this->createProductWithCategory();
        $media = new Media();

        $uploaded = $media->storeMedia($file, $product);
        $product->media()->save($media);
        $path = $media->path;

        $this->assertTrue($uploaded);
        $this->assertTrue(File::exists(public_path($path)));

        $media->delete();

        $this->assertFalse(File::exists(public_path($path)));
    }
}
