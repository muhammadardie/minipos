<?php

namespace App\Traits;

trait Scopes 
{
    public function scopeDropdown($query)
    {
        return $query->whereNull('deleted_at')->orderBy('name', 'ASC')->pluck('name','id');
    }

    public function scopeDropdownNoCond($query)
    {
        return $query->orderBy('name', 'ASC')->pluck('name','id');
    }

    public function scopeAjaxDropdown($query,$condition)
    {
    	$condition = array($condition);
        $q = $query->select('id', 'name')
                   ->where($condition)
                   ->whereNull('deleted_at')
                   ->orderBy('name', 'ASC')
                   ->get()
                   ->toArray();

        if(!empty($q)){
            return json_encode($q);
        }else{
            return json_encode(array());
        }
    }

    public function scopeDropdownDisc($query)
    {
      return $query->whereNull('deleted_at')
                   ->whereIn('id', function($q){
                    $q->select('discount_id')->from('discount_price');
                  })
                   ->orderBy('name', 'ASC')
                   ->get();
    }
}