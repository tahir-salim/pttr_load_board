<div class="mainNotifications">
    <div class="close"><i class="fal fa-chevron-left"></i></div>
    <div class="notific_head">
        <h3>Notifications</h3>
        <div class="filtersbtns">
            <!--<a class="settingIcons" href="javascript:;" title=""><i class="fas fa-cog"></i></a>-->
        </div>
    </div>
    <div class="notifBody contBody">

        <ul class="notificationsLists" id="all_notifications"> 
           
            
        </ul>
            
    </div>
    <div class="btnShipments">
        <a class="cancelBtn" id="all_noti_dismiss" style="display: block;" href="javascript:;" title=""
            onclick="dismiss_notification()"> Dismiss 
        </a>
        <a class="postBtn" id="allbtn"  href="{{ route(auth()->user()->type . '.all_notifications') }}" title="">
             See All notifications 
             </a>
    </div> 
    
    @push('js') 
    <script>
                $(document).ready( function(){
                all_notification();
                });
                
                setInterval(all_notification, 10000);
                function all_notification() {
                    var url = "{{ route(auth()->user()->type .'.get_all_notifications') }}";
                    $.ajax({
                        'type': 'get',
                        'url': url,
                        
                        success: function(response) {

                            $('#all_notifications').empty();
                            if (response.notitfication_count == 0) {


                                $('#all_notifications').append('<p style="padding: 94px;">No notifications found.</p>');
                                // $('#all_noti_dismiss').css('display','none');
                                document.getElementById('all_noti_dismiss').style.display = 'none';
                                document.getElementById('allbtn').style.display = 'none';
                            } else {
                                $.each(response.notifications, function(index, item) {
                                    if (item.un_read == 0) {
                                        var adclass = 'notify2';
                                    } else {
                                        var adclass = '';
                                    }
                                    $('#all_notifications').append(' <li class="' + adclass +
                                        '"><a href="{{config("app.url")}}/notification_redirect/' +
                                                item.id +
                                                '" title=""> <i class="fal fa-bell"></i> <p><span class="themeCol">' +
                                                item.title + ' <br/></span> ' + item.body + '</p><div class="timezone"> '+ item.created_at +'</div></a></li>'
                                    );
                                });

                                
                                
                                if (response.all_unread_count > 0) {
                                    $('#noti_count').show();
                                    $('#noti_count').html(response.all_unread_count);
                                    document.getElementById('all_noti_dismiss').style.display = 'block';
                                }else{
                                    $('#noti_count').html(response.all_unread_count);
                                    $('#noti_count').hide();
                                    document.getElementById('all_noti_dismiss').style.display = 'none';
                                }
                                document.getElementById('allbtn').style.display = 'block';

                            }

                        }
                    })
                }

                function dismiss_notification() {
                $.ajax({
                    'type': 'get',
                    'url': '{{ route('dissmiss_all_notifications') }}',
                        success: function(response) {

                            $.each(response.notifications, function(index, item) {
                                    if (item.un_read == 0) {
                                        var adclass = 'notify2';
                                    } else {
                                        var adclass = '';
                                    }
                                    $('#all_notifications').append(' <li class="' + adclass +
                                        '"><a href="{{config("app.url")}}/notification_redirect/' +
                                                item.id +
                                                '" title=""> <p><span class="themeCol">' +
                                                item.title + ' :</span> ' + item.body + '</p><div class="timezone"> 2h ago</div></a></li>'
                                    );
                                });

                                document.getElementById('allbtn').style.display = 'block';
                                if (response.all_unread_count > 0) {
                                    $('#noti_count').show();
                                    $('#noti_count').html(response.all_unread_count);
                                    document.getElementById('all_noti_dismiss').style.display = 'block';
                                }else{
                                    $('#noti_count').html(response.all_unread_count);
                                     $('#noti_count').hide();
                                    document.getElementById('all_noti_dismiss').style.display = 'none';
                                }



                            // $('#all_notifications').empty();
                            // $('#all_notifications').append('<li>No unread notificaitions found.</li>');
                        }
                    })
                }
            </script> 
    @endpush
</div>