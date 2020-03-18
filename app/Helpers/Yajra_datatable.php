<?php
namespace App\Helpers;

class Yajra_datatable{

    /**
    * Get row number Yajra Datatable
    * @author moko
    * @param $primary_key string
    * @param $request array
    * @return string sql
    */
    public static function get_no_urut($primary_key, $request){
        // get column index frontend
        $order_column = $request->get('order')[0]['column'];

        // nomor urut
        $sql_no_urut = "row_number() OVER (ORDER BY $primary_key DESC) AS rownum"; // row_number() = postgresql function
        if($order_column != 0){

            // ----------------------------
            // Yajra Datatable Index
            $field_name = $request->get('columns')[$order_column]['data']; // field_name

            if(isset($request->get('columns')[$order_column]['name'])){
                $field_name =  $request->get('columns')[$order_column]['name']; // table.field_name
            }

            $ordering   = $request->get('order')[0]['dir']; // asc|desc
            // ----------------------------
            
            $sql_no_urut= "row_number() OVER (ORDER BY $field_name $ordering) AS rownum";
        }

        return $sql_no_urut;
    }

    public static function generateButton($controller,$route,$model,$permission,$remark,$anotherButton="") {
        //$route_name = explode('.', Route::currentRouteName());
        $route_show     = $route[0].'.'.$route[1].'.show';
        $route_edit     = $route[0].'.'.$route[1].'.edit';
        $route_destroy  = $route[0].'.'.$route[1].'.destroy';

        if(count($permission) > 1){
            $btn_action = '<span class="dropdown">                          
                        <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                            <i class="la la-ellipsis-h"></i>
                        </a>                            
                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';

            if(array_key_exists('show', $permission)){
                if (method_exists($controller, 'show') && is_callable(array($controller, 'show'))){
                    $btn_action .= '<a href="'. route($route_show, $model->id) .'" class="dropdown-item"><i class="la la-search"></i> Detail '.$remark.'</a>';
                }
                
            }

            if(array_key_exists('edit', $permission)){
                if (method_exists($controller, 'show') && is_callable(array($controller, 'edit'))){
                    $btn_action .= '<a href="'. route($route_edit, $model->id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit '.$remark.'</a>';
                }
            }

            if(array_key_exists('destroy', $permission)){
                if (method_exists($controller, 'destroy') && is_callable(array($controller, 'destroy'))){
                    $btn_action .= '<a data-remark="'.$remark.'" data-delete="'. $model->id .'" href="#" class="dropdown-item delete_this" style="color: #575962 !important;"><i class="la la-trash"></i>Delete '.$remark.'</a>';
                }
            }

            $btn_action .= $anotherButton;

            $btn_action .= '</div></span>';
        } else {
            $btn_action = '';
        } 
        return $btn_action;
    }
}