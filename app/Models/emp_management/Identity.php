<?php

namespace App\Models\emp_management;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Identity extends Model
{
	use Scopes;

    public $table = 'identities';
}
