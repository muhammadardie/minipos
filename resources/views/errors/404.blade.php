@extends('layouts.base')
@section('content')

<div class="m-content">
    <div class="row">
            <!--begin::Portlet-->
                        <div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url({{ asset('assets/app/media/img/error/bg1.jpg') }});height:700px;width:100%;">
                        <div class="m-error_container">
                            <span class="m-error_number">
                                <h1>404</h1>             
                            </span>     
                            <p class="m-error_desc">
                                OOPS! Something went wrong here
                            </p>     
                        </div>   
                    </div>   
            <!--end::Portlet-->    
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.m-menu__item--active').removeClass('m-menu__item--active');
        $('.m-subheader ').remove();
    });
</script>
@endsection

{{-- @extends('layouts.base')
    @section('content')

        
        
    	<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    
            
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url({{ asset('assets/app/media/img/error/bg1.jpg') }}">
    <div class="m-error_container">
        <span class="m-error_number">
            <h1>404</h1>             
        </span>     
        <p class="m-error_desc">
            OOPS! Something went wrong here
        </p>     
    </div>   
</div>              
        

</div>		
		

<!-- end:: Page -->

@endsection --}}