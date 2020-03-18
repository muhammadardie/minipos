@extends('layouts.base')
@section('content')

<div class="m-content">
    <div class="row">
        <div class="col-md-12"> 
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Dashboard
                            </h3>
                        </div>          
                    </div>
                </div>
                <div class="m-portlet__body">
                    <center>
                        <img width="50%" src="{{ asset('assets/app/media/img/misc/dashboard.png') }}" style="margin: 50px 0 150px 0">
                    </center>
                </div>
            </div>  
            <!--end::Portlet-->    
        </div>
    </div>
</div>    
<script>
    $(document).ready(function(){
        $('.m-menu__item--active').removeClass('m-menu__item--active');
        $('.m-subheader ').remove();
    });
</script>
@endsection