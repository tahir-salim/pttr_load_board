@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Feedback</h2>
            </div>
            @php 
                $top_header1 = ads('feedbacks_form','top_header1');
                $top_header2 = ads('feedbacks_form','top_header2');
                $top_header3 = ads('feedbacks_form','top_header3');
                $bottom_footer1 = ads('feedbacks_form','bottom_footer1');
                $bottom_footer2 = ads('feedbacks_form','bottom_footer2');
            @endphp
            <div class="contBody">
                @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                <div class="row">
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="{{$top_header3->url}}" target="_blank" title=""><img src="{{asset($top_header3->image)}}" alt=""></a>
                        </div>
                    </div>
                </div>
                @endif
                <form action="{{ route(auth()->user()->type . '.feedback_submit') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class=" col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Please correct the errors in the following fields:<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            @if ($error == 'Phone')
                                                <li>* Please select at least one method of contact to post</li>
                                            @elseif ($error == 'Email')
                                            @else
                                                <li>* {{ $error }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card shipmentDetails">
                                
                                <h3>Describe your issue</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <textarea name="message" id="" cols="10" rows="10" required placeholder="Your message"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnShipments col-md-3">
                        <input type="submit" class="postBtn" value="Submit Feedback">
                    </div>
                </form>
                @if(isset($bottom_footer1) && isset($bottom_footer2))
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="advertisments height_auto">
                            <a href="{{$bottom_footer1->url}}" target="_blank" title=""><img src="{{asset($bottom_footer1->image)}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="advertisments height_auto">
                            <a href="{{$bottom_footer2->url}}" target="_blank" title=""><img src="{{asset($bottom_footer2->image)}}" alt=""></a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>


@endsection
