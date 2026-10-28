
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCSFES v2</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}">

    @include('shared.css_links.css_links')
    </head>
    <body class="hold-transition sidebar-mini">
        @if (isset($_SESSION["rapidx_user_id"]))
            <input type="hidden" id="loginEmployeeId" value="<?php echo $_SESSION["rapidx_user_id"]; ?>">
        @endif
        <div class="wrapper">
            @include('shared.pages.header')
            @include('shared.pages.user_nav')
            @yield('content_page')
            @include('shared.pages.footer')
        </div>
        @include('shared.js_links.js_links')
        @yield('js_content')

        <script type="text/javascript">
            $(document).ready(function(){
                verifyUser()
                function verifyUser(){
                    let loginEmployeeId = $('#loginEmployeeId').val();
                    console.log('Session(Admin/User):', loginEmployeeId);
                    $.ajax({
                        url: "get_user_log",
                        method: "get",
                        data: {
                            loginEmployeeId : loginEmployeeId
                        },
                        dataType: "json",

                        success: function(response){
                            if(response['result'].length > 0){
                                if([2, 3].includes(response['result'][0].classification)){
                                    $('#selection').removeClass('d-none')
                                }else{
                                    $('#selection').addClass('d-none')
                                    $('#changeEquipmentModelChecklistTitle').text('View Records for Factory '+response['result'][0].category+'')
                                    $('#setTitle').text('FACTORY '+response['result'][0].category+'')
                                    $('#factory').val(response['result'][0].category).trigger('change')
                                }
                                
                                $('#factory').change(function (e) { 
                                    e.preventDefault();
                                    $('#changeEquipmentModelChecklistTitle').text('View Records for Factory '+$('#factory').val()+'')
                                    $('#setTitle').text('FACTORY '+$('#factory').val()+'')
                                    console.log('FACTORY '+$('#factory').val()+'');
                                });
                                for(let i = 0; i<response['result'].length;i++){
                                    if(response['result'][i].classification != "0"){
                                        $('.userList').removeClass('d-none');
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    </body>
</html>

