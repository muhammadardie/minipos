<?php

namespace App\Models\app_management;
use Venturecraft\Revisionable\Revisionable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Revisionable
{
    public $table 		= 'permissions';
}
