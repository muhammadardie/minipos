
<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i class="la la-close"></i></button>

<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-light ">   
    <!-- BEGIN: Aside Menu -->
    <div 
        id="m_ver_menu" 
        class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light the-sidebar" 
        m-menu-vertical="1"Dash
         m-menu-scrollable="1" m-menu-dropdown-timeout="500"  
        style="position: relative;"> 
        {!! $html_menu !!}
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->   

<!-- Modal Open Cashier-->
<div class="modal fade" id="modal-open-close-cashier" tabindex="-1" role="dialog" style="opacity:unset !important">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
            Open Cashier 
        </h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="m-form m-form--fit m-form--label-align-right" id="form-open-cashier">
            <div class="m-portlet__body">   
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <label>
                            Shift
                        </label>
                        <input type="text" name="m-shift-info" class="form-control m-input" disabled data-container="body" data-toggle="m-popover" data-placement="top" data-content="Last shift auto selected when there is no matching time" data-original-title="" title="">
                        <input type="hidden" name="m-shift-id" class="form-control m-input">
                    </div>
                    <div class="col-lg-6">
                        <label class="">User</label>
                        <input type="text" class="form-control m-input" placeholder="{{ \Auth::user()->employee->first_name.' '.\Auth::user()->employee->last_name }}"disabled>
                    </div>
                </div>   
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <label>Total Paper Money</label>
                        <input type="text" name="paper_money" class="form-control m-input" readonly style="border-color: #f4f5f8;color: #6f727d;background-color: #f4f5f8;cursor: not-allowed;" data-total-type="paper-money">
                    </div>
                    <div class="col-lg-6">
                        <label class="">Total Coin Money</label>
                        <input type="text" name="coin_money" class="form-control m-input" readonly style="border-color: #f4f5f8;color: #6f727d;background-color: #f4f5f8;cursor: not-allowed;" data-total-type="coin-money">
                    </div>
                </div>   
                <div class="form-group m-form__group row" id="m-money-counter">
                    <div class="col-lg-6">
                        <div class="m-form__heading" style="margin-left:50px">
                            <h4><span class="fa fa-money-bill"></span> Paper Money</h4>
                        </div>
                        <label>100.000</label>
                        <input type="number" data-paper="100000" class="form-control" data-type="paper-money">
                        <br />
                        <label>50.000</label>
                        <input type="number" data-paper="50000" class="form-control" data-type="paper-money">
                        <br />
                        <label>20.000</label>
                        <input type="number" data-paper="20000" class="form-control" data-type="paper-money">
                        <br />
                        <label>10.000</label>
                        <input type="number" data-paper="10000" class="form-control" data-type="paper-money">
                        <br />
                        <label>5.000</label>
                        <input type="number" data-paper="5000" class="form-control" data-type="paper-money">
                        <br />
                        <label>2.000</label>
                        <input type="number" data-paper="2000" class="form-control" data-type="paper-money">
                        <br />
                        <label>1.000</label>
                        <input type="number" data-paper="1000" class="form-control" data-type="paper-money">
                    </div>
                    <div class="col-lg-6">
                        <div class="m-form__heading" style="margin-left:50px">
                            <h4><span class="fa fa-coins"></span> Coin Money</h4>
                        </div>
                        <label>1.000</label>
                        <input type="number" data-coin="1000" class="form-control m-input" data-type="coin-money">
                        <br />
                        <label>500</label>
                        <input type="number" data-coin="500" class="form-control m-input" data-type="coin-money">
                        <br />
                        <label>200</label>
                        <input type="number" data-coin="200"class="form-control m-input" data-type="coin-money">
                        <br />
                        <label>100</label>
                        <input type="number" data-coin="100" class="form-control m-input" data-type="coin-money">
                    </div>
                </div>                  
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success set-cashier-money">Proceed</button>
      </div>    
    </div>
  </div>
</div>
<!-- End Modal Open Cashier -->


<!-- Modal Open Last Cashier-->
<div class="modal fade" id="modal-user-cashier" tabindex="-1" role="dialog" style="opacity:unset !important">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Open Cashier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">   
                <div class="form-group m-form__group row">
                    <label>Username</label>
                    <input type="text" name="m-cashier-username" class="form-control m-input" disabled>
                </div>
                <div class="form-group m-form__group row">
                        <label class="">Password</label>
                        <input type="password" name="m-cashier-password" class="form-control m-input">
                </div>   
                <div class="form-group m-form__group row">
                    <div class="col-lg-offset-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success proceed-user-cashier" style="margin-left: 10px;">Proceed</button>
                    </div>
                </div>                  
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Open Cashier -->

<script>
    $(document).ready(function(){

        var $openCashier    = $('.open-cashier', '#m_ver_menu');
        var $closeCashier   = $('.close-cashier', '#m_ver_menu');
        var $cashierCashier = $('.cashier-cashier', '#m_ver_menu');

        // if there is menu --open cashier --close cashier --cashier
        if($openCashier.length > 0 && $closeCashier.length > 0 && $cashierCashier.length > 0){
            var $linkOpen    = $openCashier;
            var $linkClose   = $closeCashier;
            var $linkCashier = $cashierCashier;
            var $username    = $('input[name=m-cashier-username]');
            var $password    = $('input[name=m-cashier-password]');
            var shift        = {!! $shift !!};
            console.log(shift)
            var idCashiers   = {!! $id_cashiers !!}; // if any opened cashier
            var owner        = {{ \Auth::user()->is_owner }};
            var emailEmp     = jQuery.isEmptyObject(idCashiers) === true ? '' : idCashiers.employee.email;

            $openCashier.removeClass('open-cashier');
            $closeCashier.removeClass('close-cashier');
            $cashierCashier.removeClass('cashier-cashier');

            // if there is no active cashier
            if(jQuery.isEmptyObject(idCashiers)){
                $linkOpen.addClass('open-cashier');
                $linkClose.addClass('noopened-cashier');
                $linkCashier.addClass('no-cashier');
            } else {
                $linkOpen.addClass('undisclosed-cashier');
                $linkClose.addClass('close-cashier');
                $linkCashier.addClass('last-cashier');
            }            

            // event handler
            $('.noopened-cashier', '#m_ver_menu').on('click',{
                title:'There is no opened cashier!', 
                text:'You have to open new cashier first to close cashier!', 
                type:'warning'
            }, justSwalThis);

            $('.no-cashier', '#m_ver_menu').on('click',{
                title:'There is no opened cashier!', 
                text:'You have to open new cashier first!', 
                type:'warning'
            }, justSwalThis);

            $('.undisclosed-cashier', '#m_ver_menu').on('click',{
                title:'There is still opened cashier!', 
                text:'You have to close opened cashier first to open new cashier!', 
                type:'warning'
            }, justSwalThis);

            $('.close-cashier', '#m_ver_menu').on('click', closeCashierClicked);
            
            $('.open-cashier', '#m_ver_menu').on('click', openCashierClicked);
            
            $('.last-cashier', '#m_ver_menu').on('click', lastCashierClicked);
            
            $('.proceed-user-cashier', '#modal-user-cashier').on('click', proceedUserClicked);
            
            $('.set-cashier-money', '#modal-open-close-cashier').on('click', setMoneyCashier); // 

            function justSwalThis(event){
                event.preventDefault();
                swal(
                    event.data.title,
                    event.data.text,
                    event.data.type
                    );
            }

            function closeCashierClicked(event){
                event.preventDefault();
                var $link = $(this).attr('href');
                $('#modal-user-cashier').find('.modal-title').html('Close Cashier');
                $('.proceed-user-cashier').attr('data-url', $link);

                $username.val(emailEmp);
                $password.val('');
                $('#modal-user-cashier').modal('toggle');
            }

            function openCashierClicked(event){
                event.preventDefault();
                var shiftInfo = shift.name;
                var shiftId   = shift.id;

                $('button.set-cashier-money').attr('data-url', 'open-cashier');
                $('input[name=m-shift-info]').val(shiftInfo);
                $('input[name=m-shift-id]').val(shiftId);

                openCloseCashierProcess();
            }

            function lastCashierClicked(event){
                event.preventDefault();
                var $link = $(this).attr('href');
                $('#modal-user-cashier').find('.modal-title').html('Open Last Cashier');
                $('.proceed-user-cashier').attr('data-url', $link);
                $username.val(emailEmp);
                $('#modal-user-cashier').modal('toggle');
            }

            function proceedUserClicked(){
                var $email    = $username.val();
                var $pass     = $password.val();
                var $link     = $(this).attr('data-url');

                if($email != '' && $pass != ''){
                    $(this).removeAttr('disabled');
                    mApp.unblock("#modal-user-cashier .modal-content");

                    $.ajax({
                      type: "POST",
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: '{{ route('cashier.cashier.ajax_check_cashier') }}',
                      data: { 
                              email: $email,
                              password: $pass,
                            },
                      dataType: 'json',
                      success: function(msg){
                        if(msg == 'success'){
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal-user-cashier .modal-content");
                            $("#modal-user-cashier").modal('hide');

                            swal({ 
                                title: "Success",
                                text: "Authentication Passed",
                                type: "success" 
                            }).then(function() {
                                // if close cashier open modal 'open close cashier' else redirect new cashier page  
                                if ($link.indexOf('close') > -1){
                                    $('button.set-cashier-money').attr('data-url', 'close-cashier');
                                    $('input[name=m-shift-info]').val(idCashiers.shift.name);
                                    $('input[name=m-shift-id]').val(idCashiers.shift.id);
                                    $('#modal-open-close-cashier').find('.modal-title').html('Close Cashier');
                                    openCloseCashierProcess();
                                } else {
                                    $(location).attr('href',$link);
                                }
                            });    
                        } else {
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal-user-cashier .modal-content");
                            //$("#modal-user-cashier").modal('hide');
                            swal("Authentication Failed!", "You have entered an invalid password", "error");    
                        }
                      },
                      error: function(err){
                        $(this).removeAttr('disabled');
                        mApp.unblock("#modal-open-close-cashier .modal-content");
                        //$("#modal-open-close-cashier").modal('hide');
                        swal("Authentication Failed!", "You have entered an invalid password", "error");
                      }
                    });    
                } else {
                    alert("Password can't be empty");
                    $password.focus();
                }
            }

            function openCloseCashierProcess(){
                $('#modal-open-close-cashier').modal('toggle');

                $('#m-money-counter').find('input').on('input', totalThisInput);            

                function totalThisInput(event){
                    var type    = $(this).attr('data-type');
                    var total   = 0;
                    var $elem   = $('input[data-type='+type+']');
                    var $output = $('input[data-total-type='+type+']');
                    for(var i = 0; i < $elem.length; i++){
                        var thisInput = $elem[i];
                        var money     = $(thisInput).prev().html().replace('.','');
                        var amount    = $(thisInput).val() != '' ? $(thisInput).val() : 0;
                        total += parseInt(money)*parseInt(amount);
                    }
                    $($output).val(total);
                    <?= \Helper::number_formats('$($output)', 'js', 0) ?>
                }
            }
            
            function setMoneyCashier(){
                var lastCashier = jQuery.isEmptyObject(idCashiers) === true ? '' : idCashiers.id;
                var url         = $(this).attr('data-url');
                var shift       = $('input[name="m-shift-id"]').val();
                var paperMoney  = $('input[name="paper_money"]').val();
                var coinMoney   = $('input[name="coin_money"]').val();
                var paperData   = [];
                var coinData    = [];

                $(this).attr('disabled', 'disabled');
                mApp.block("#modal-open-close-cashier .modal-content");
                // create array paper and coin money amount  
                $('input[data-type=paper-money]', '#form-open-cashier').each(function() {
                    var arr      = {};
                    arr['name']  = $(this).attr('data-paper');
                    arr['value'] = $(this).val();
                    paperData.push(arr);
                });
                $('input[data-type=coin-money]', '#form-open-cashier').each(function() {
                    var arr      = {};
                    arr['name']  = $(this).attr('data-coin');
                    arr['value'] = $(this).val();
                    coinData.push(arr);
                });
                if(paperMoney != '' && coinMoney != ''){
                    $.ajax({
                      type: "POST",
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: '{{ route('cashier.cashier.ajax_open_close_cashier') }}',
                      data: { 
                              lastCashier: lastCashier,
                              status: url,
                              shift: shift,
                              paperMoney: paperMoney,
                              paperData: paperData,
                              coinMoney: coinMoney,
                              coinData: coinData
                            },
                      dataType: 'json',
                      success: function(msg){
                        if(msg == 'success'){
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal-open-close-cashier .modal-content");
                            $("#modal-open-close-cashier").modal('hide');
                            var text = url == 'close-cashier' ? 'closed' : 'opened';
                            swal({ 
                                title: "Success",
                                text: "Cashier "+text+" successfully",
                                type: "success" 
                            }).then(function() {
                                if(url == 'open-cashier'){
                                    $(location).attr('href',$($linkCashier).attr('href'));  
                                } else {
                                    $(location).attr('href', '{{ route('dashboard') }}');
                                }
                            });    
                        } else {
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal-open-close-cashier .modal-content");
                            $("#modal-open-close-cashier").modal('hide');
                            swal("Failed!", "Please refresh the page and retry again", "error");    
                        }
                        
                      },
                      error: function(err){
                        $(this).removeAttr('disabled');
                        mApp.unblock("#modal-open-close-cashier .modal-content");
                        $("#modal-open-close-cashier").modal('hide');
                        swal("Failed!", "Please refresh the page and retry again", "error");
                      }
                    });
                } else {
                    $(this).removeAttr('disabled');
                    mApp.unblock("#modal-open-close-cashier .modal-content");
                    swal("","Money can't be empty","error");
                }
                

            }

            // feature submit when enter pressed
            $('#modal-open-close-cashier').keypress(function (e) {
                if(e.keycode == 13 || e.which == 13){
                    $('.set-cashier-money', '#modal-open-close-cashier').click();
                }
            });  

            $('#modal-user-cashier').keypress(function (e) {
                if(e.keycode == 13 || e.which == 13){
                    $('.proceed-user-cashier', '#modal-user-cashier').click();
                }
            });  

        } // end if menu exist

    });
</script>
