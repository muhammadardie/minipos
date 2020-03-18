<?php

namespace App\Models\emp_management;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Identity extends Revisionable
{
	use Scopes;

    public $table 		= 'identities';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }
    
}
