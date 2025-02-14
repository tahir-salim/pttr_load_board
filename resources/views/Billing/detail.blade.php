@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            
            <div class="main-header">
                <h2>Billing Detail</h2>
            </div>
            @php 
                $top_header1 = ads('Billing_details','top_header1');
                $top_header2 = ads('Billing_details','top_header2');
                $top_header3 = ads('Billing_details','top_header3');
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
                <div class="card">
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Truck Status :</strong></label>
                                <select id='truck_status' class="form-control" style="width: 200px">
                                    <option value="">All</option>
                                    <option value="available">Available</option>
                                    <option value="pending">Pending</option>
                                    <option value="pickup">Pickup</option>
                                    <option value="drop off">Drop off</option>
                                    <option value="in transit">In transit</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="decline">Decline</option>
                                    <option value="accepted">Accepted</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    {{-- {{dd($subscription->is_active)}} --}}
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Billing ID : <span>{{ $subscription->id }}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Invoice No : <span>{{ $subscription->invoice_no }}</span></h5>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Transaction ID : <span>{{ $subscription->transaction_id }}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Transaction Detail : <span>{{ $subscription->transaction_detail }}</span></h5>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Subscription ID : <span>{{ $subscription->subscription_id }}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Amount : <span>${{ $subscription->amount }}</span></h5>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Expired At : <span>{{ $subscription->expired_at }}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Subscription Status : <span>
                                            @if ($subscription->is_active == 1)
                                                Active
                                            @else
                                                In Active
                                            @endif
                                        </span></h5>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    @if ($subscription->user->parent_id == null)
                                    <h5>User Name : <span>{{ $subscription->user->name }} <i class="fa fa-user-tie" style="color:#0682be; font-size:23px;"></i></span></h5>
                                    @else
                                    <h5>User Name : <span>{{ $subscription->user->name }}</span></h5>
                                    @endif
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>User Email : <span>{{ $subscription->user->email }}</span></h5>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>User Status : <span>
                                            @if ($subscription->user->status == 1)
                                                Active
                                            @else
                                                In Active
                                            @endif
                                        </span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="userdet_info2">
                                    <h5>Package Name : <span>{{ $subscription->package->name }}</span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Back</a>
                            <a href="{{ route(auth()->user()->type . '.billing.download_pdf', $subscription->id) }}"
                                class="btn btn-outline-success" target="_blank"><i class="fa fa-download"></i> Download PDF</a>
                            </div>
                            
                            
                        </div>
    
    
                    
                </div>
                
                <div class="main-header">
                    <h3>Transactions Detail</h3>
                </div>
            
                <div class="tablescroll">
                    <div class="card">
                        <div class="showfirst">
                            <div class="tableLayout">
                                <table id="ShipmentTable1" class="display customTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($allTransactions) == true)
                                            @foreach($allTransactions as $allTransaction)
                                            <tr>
                                                <td>{{$allTransaction->gettransId()}}</td>
                                                <td>${{isset($trialAmount) ? $trialAmount : $amount }}</td>
                                                <td>{{Carbon\Carbon::parse($allTransaction->getsubmitTimeUTC())->format('F j Y h:m:s A') }}</td>
                                                <td>{{$allTransaction->getresponse()}}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
