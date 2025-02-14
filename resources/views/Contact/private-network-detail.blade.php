@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Contact Detail</h2>
                <div class="rightBtn">
                    <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.private_network')}}" tile="">
                        All CONTACTS
                    </a>
                </div>
            </div>
            @php
                $top_header1 = ads('private_network_detail','top_header1');
                $top_header2 = ads('private_network_detail','top_header2');
                $top_header3 = ads('private_network_detail','top_header3');
            @endphp

            @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                <div class="row mb-3">
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
            <div class="contBody halfscroll">

                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="trackhead">
                                <h3>Contact Information</h3>
                            </div>
                            <div class="infoGroupDet">
                                <h3>Information</h3>
                                <div class="infodetb">
                                    <div class="items">
                                        <h6>Phone Number</h6>
                                        <p>{{$contact->phone ? $contact->phone : '-' }}</p>
                                    </div>
                                    <div class="items">
                                        <h6>Email Address</h6>
                                        <p><a href="javascript:;" title="">{{$contact->email ? $contact->email : '-' }}</a></p>
                                    </div>
                                    <div class="items">
                                        <h6>Location</h6>
                                        <p>{{$contact->state ? $contact->state.',' : '' }}  {{$contact->city ? ' '.$contact->city.',' : '' }} {{$contact->zip_code ? ' '.$contact->zip_code : '' }}</p>
                                    </div>
                                    <div class="items">
                                        <h6>Affiliate Id</h6>
                                        <p>{{$contact->affiliat ? $contact->affiliat : '-' }} </p>
                                    </div>
                                </div>
                                {{-- <div class="assignGroupsadd">
                                    <h3>Assign Groups</h3>
                                    <p>You can add this contact to groups you create in irder to quickly
                                        diffrentiate them from others.</p>
                                    <div class="groupADDBtns">
                                        <a class="themeBtn" href="javascript:;" title="">Add to groups</a>
                                        <p class="text-right">Source: SP Freight Brokerage Inc</p>
                                    </div>
                                </div> --}}

                                @if(count($contact->groups()->get()) > 0)
                                <div class="groupalredyAdded">
                                    <h3>All Groups</h3>
                                    {{-- <p>{{dd($contact->groups()->get())}}</p> --}}
                                    <a class="editgroup" onclick="return confirm('Are you sure want to delete?')" href="{{route(auth()->user()->type.'.contact_remove_groups',[$contact->id])}}" title=""><i
                                            class="fas fa-trash"></i> Remove Groups</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="trackhead">
                                <h3>Company Information</h3>
                            </div>
                            @if($contact->legal_mc_number || $contact->legal_dot_number)
                            <div class="infoGroupDet">
                                <h3>{{$contact->company_name ? $contact->company_name : '-'}}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            <li>
                                                <div>
                                                    <p>DOT#</p>
                                                </div>
                                                <div>
                                                    <p><a href="javascript:;" title="">{{$contact->legal_dot_number ? $contact->legal_dot_number : '-'}}</a></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <p>Safety Rating</p>
                                                </div>
                                                <div>
                                                    <p>{{$contact->safety_rating ? $contact->safety_rating : '-'}}</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            {{-- <li>
                                                <div>
                                                    <p>Founded</p>
                                                </div>
                                                <div>
                                                    <p>-</p>
                                                </div>
                                            </li> --}}
                                            <li>
                                                <div>
                                                    <p>Power units</p>
                                                </div>
                                                <div>
                                                    <p>{{$contact->legal_power_units ? $contact->legal_power_units : '-'}}</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <p>Drivers</p>
                                                </div>
                                                <div>
                                                    <p>{{$contact->legal_drivers ? $contact->legal_drivers : '-'}}</p>
                                                </div>
                                            </li>
                                            {{-- <li>
                                                <div>
                                                    <p>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <a href="javascript:;" title="">(1)</a>
                                                    </p>
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p>Source: <a href="https://www.fmcsa.dot.gov/" title="">FMCSA</a></p>
                                </div>
                                <div class="viewdirectryBtn">
                                    {{-- <a href="javascript:;" title="">View In Directory</a> --}}
                                </div>
                            </div>
                            @else
                            <div class="informatNull infoGroupDet">
                                <h3>Company information Unavailable</h3>
                                <p>Company information for this account is currently unavailable.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
