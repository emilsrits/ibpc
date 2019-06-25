<?php

namespace App\Observers;

use App\Media;
use Illuminate\Support\Facades\Storage;

class MediaObserver
{

    /**
     * Listen to the Media deleting event.
     *
     * @param  \App\Media  $media
     * @return void
     */
    public function deleting(Media $media)
    {
        // Delete the media from local storage
        $file = str_replace('/storage', '', $media->path);
        if ($file && Storage::exists('/public' . $file)) {
            Storage::delete('/public' . $file);
        }
    }
}