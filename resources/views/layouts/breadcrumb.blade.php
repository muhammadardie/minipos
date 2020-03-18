





<!-- BEGIN: Breadcrumb -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"></h3>         
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                
            </ul>
        </div>
    <div>

    </div>
</div>
</div>
<!-- END: Breadcrumb -->             

<script>
    $(document).ready(function(){

        var menu_open    = $('.the-sidebar').find('li.m-menu__item--active');
        var len_menu     = $(menu_open).length;
        var breadcrumb   = '';

        // FIX BUGS : submenu2 not 'open'
        // check have 3 menu
        // if have, add class 'open' in submenu2
        ishave_3menu = $('.the-sidebar').find('li.m-menu__item--active > div.m-menu__submenu').css('display') == 'block';

        if(ishave_3menu == true){
            menu_no2    = $('.the-sidebar').find('li.m-menu__item--active div.m-menu__submenu[style="display:block"]').parent();
            li          = $(menu_no2).closest('li').addClass('m-menu__item--open m-menu__item--active');

            // refresh var, because previously we add class 'open'
            var menu_open   = $('.the-sidebar').find('li.m-menu__item--active');
            var len_menu    = $(menu_open).length;
        }
        var il = 0;
        $.each(menu_open, function(i, v){ // i = 0
            i1      = (parseInt(i) + 1);
            href    = $(v).find('a').attr('href');
            text    = $(v).find('a:eq(0)').text().trim();

            if(len_menu > 1){
                if(il == len_menu){
                    breadcrumb += '<li class="m-nav__item"><a href="'+ href +'" class="m-nav__link"><span class="m-nav__link-text">'+ text +'</span></a></li>';
                } else {
                    breadcrumb += '<li class="m-nav__item"><a href="#" class="m-nav__link"><span class="m-nav__link-text">'+ text +'</span></a></li>';
                    $('.m-subheader__title').text(text);
                }
                
            } else {
                breadcrumb += '<li class="m-nav__item"><a href="'+ href +'" class="m-nav__link"><span class="m-nav__link-text">'+ text +'</span></a></li>';
                $('.m-subheader__title').text(text);
            }

            if(i1 >= 1 && i1 < len_menu){
                breadcrumb += '<li class="m-nav__separator">-</li>';
            }

        });

        // delete first tmp icon
        //$('.the-breadcrumb i.fa.fa-home').replaceWith('');

        // append breadcumb list to first - breadcumb
        $('.m-subheader__breadcrumbs').prepend(breadcrumb);
    });        
</script>