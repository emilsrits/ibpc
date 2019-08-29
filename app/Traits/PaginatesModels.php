<?php

namespace App\Traits;

trait PaginatesModels
{
    /**
     * Set session page size for paginated results
     *
     * @return bool
     */
    public function setSessionPageSize() {
        if (request()->ajax() && request('pageSize')) {
            session(['page-size' => request('pageSize')]);

            return true;
        }
        
        return false;
    }
}