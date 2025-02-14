@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Live Support</h2>
            </div>
            @php 
                $center_header1 = ads('live_chat_support','center_header1');
                $center_header2 = ads('live_chat_support','center_header2');
            @endphp
            <div class="contBody">
                <div class="row">
                <div class="col-md-9">
                    <div class="">
                        <div class="card livehcatmm">
                            <div class="chatHeader">
                                <div class="chattitle">
                                    <figure>
                                        <img src="{{ asset('assets/images/liveuser-01.webp') }}" alt="">
                                    </figure>
                                    {{ $user->name }}
        
                                </div>
                                {{-- <div class="livechatBtn">
                                    <a class="redBtn" href="javascript:;" title="">End Chat</a>
                                </div> --}}
                            </div>
                            <div class="chatBody scrollcustoms">
                                <div id="message-container"></div>
                            </div>
                            <div class="chatFooter">
                                <form action="" method="POST" id="send_container_messge">
                                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                                    <div class="messageType">
                                        <textarea name="message" id="message" required cols="10" rows="10" placeholder="Start typing here"></textarea>
                                        <button>
                                            <i class="fal fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
        
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($center_header1) && isset($center_header2))
                <div class="col-md-3">
                    <div class="advertisments height_auto mt-3">
                        <a href="{{$center_header1->url}}" target="_blank" title=""><img src="{{asset($center_header1->image)}}" alt=""></a>
                    </div>
                    <div class="advertisments height_auto mt-3">
                        <a href="{{$center_header2->url}}" target="_blank" title=""><img src="{{asset($center_header2->image)}}" alt=""></a>
                    </div>
                </div>
                @endif
            </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyDUxKPRi3ec_FQxDv33hOssPfx7b75yi4c",
            authDomain: "pttr-12c10.firebaseapp.com",
            databaseURL: "https://pttr-12c10-default-rtdb.firebaseio.com",
            projectId: "pttr-12c10",
            storageBucket: "pttr-12c10.appspot.com",
            messagingSenderId: "760302918794",
            appId: "1:760302918794:web:ddd0728da67dad0267a173",
            measurementId: "G-P01WSBPYRY"
        };

        firebase.initializeApp(firebaseConfig);
        firebase.analytics();

        var reff = firebase.database().ref("user_id_{{ auth()->user()->id }}/messages/user_id_1");
        reff.on('child_added', function(snapshot) {

            var AuthName = '{{ auth()->user()->id }}'
            var myname = "{{ Auth::user()->name }}";


            var name = snapshot.val().user_id;

            // console.log(moment(snapshot.val().date).fromNow());


            if (name == AuthName) {
                var block2 = '<div class="chatBox reply"><div class="chatuserName"><span>Me</span><span>' + snapshot
                    .val().date + '</span></div><p>' + snapshot.val().text + '</p></div>';


                $("#message-container").append(block2);

                //$('#data-container').mCustomScrollbar();

                // window.scrollTo(0, document.body.scrollHeight);
                 // Scroll to the last chatBox div
                var chatBoxes = document.getElementsByClassName("chatBox");
                if (chatBoxes.length > 0) {
                    chatBoxes[chatBoxes.length - 1].scrollIntoView();
                }

                

            } else {

                var block = '<div class="chatBox"><div class="chatuserName"><span>' + snapshot.val().user_name +
                    '</span><span>' + snapshot
                    .val().date + '</span></div><p>' + snapshot.val().text + '</p></div>';
                $("#message-container").append(block);
                
                 // Scroll to the last chatBox div
                var chatBoxes = document.getElementsByClassName("chatBox");
                if (chatBoxes.length > 0) {
                    chatBoxes[chatBoxes.length - 1].scrollIntoView();
                }
                
                // window.scrollTo(0, document.body.scrollHeight);

            }

        });


        // Add record
        $('#send_container_messge').submit(function(e) {


            e.preventDefault();
            // var username = $('#message_content').val();

            var form = new FormData(document.getElementById('send_container_messge'));
            var token = $('#token').val();
            form.append('_token', token);
            // var x = document.getElementById("myAudio");

            $.ajax({
                url: '{{ route('send_message', $id) }}',
                type: 'post',
                data: form,
                cache: false,
                contentType: false, //must, tell jQuery not to process the data
                processData: false,

                success: function(response) {


                    // var xdiv = document.getElementById("image_display");
                    // xdiv.style.display    = "none";
                    // $('#message').val('');
                    document.getElementById("send_container_messge").reset();

                    $("#message-container").animate({
                        scrollTop: $('#message-container').get(0).scrollHeight
                    }, 3000);
                    // console.log({'message': username});

                }
            });


        });
    </script>
@endpush
