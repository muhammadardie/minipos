<?php
 
namespace App\View\Composers;
 
use Illuminate\View\View;
use App\Models\cashier\Cashiers;
use App\Models\master_data\Shift;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // share cashier status to sidebar
        $id_cashiers = Cashiers::with('employee', 'shift')->where('opened', true)->where('closed', false)->first();
        $shift       = Shift::whereTime('start_time', '<', date("H:i:s"))
                            ->whereTime('end_time', '>', date("H:i:s"))
                            ->first();
        $shift = $shift ?? Shift::latest('id')->first(); // if null then shift malam
        $view->with('id_cashiers', json_encode($id_cashiers));
        $view->with('shift', $shift);
    }
}