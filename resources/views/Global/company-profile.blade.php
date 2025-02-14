@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            <div class="main-header">
                <h2>Company Profile</h2>
            </div>
            @php 
                $top_header1 = ads('compnay_profile','top_header1');
                $top_header2 = ads('compnay_profile','top_header2');
                $top_header3 = ads('compnay_profile','top_header3');
            @endphp
            <div class="contBody companyprofile">
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
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            	@if ($errors->any())
                                 <div class="alert alert-danger py-4">
                                     <ul>
                                         @foreach ($errors->all() as $error)
                                             <li>{{ $error }}</li>
                                         @endforeach
                                     </ul>
                                 </div>
                             @endif
                             
                            <h3>{{ $company->name }}</h3>
                            <p>
                                {{$company->address}}. {{$company->phone}}
                            </p>
                            <p>The information you provide in your company's profile(s) displays in the
                                PTTR Directory.</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card authorityLevel">
                            <h3>Authority Level</h3>
                         
                            <p>To change Authority Level, contact Customer Support.
                                <a href="javascript;:" data-toggle="modal" data-target="#exampleModal">EDIT</a>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Company Name
                                        <strong>{{ $company->name }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Company Type
                                        <strong>{{ auth()->user()->type }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Company DOT #
                                        <strong>{{ $company->dot }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Company MC#:
                                        <strong>{{ $company->mc }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Business Address:
                                        <strong>{{ $company->address }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Phone Number
                                        <strong>{{ $company->phone }}</strong>
                                    </p>
                                </div>
                            </div>
                            <p>This information is provided by FMCSA. To edit or update the information.
                                contact FMCSA</p>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="card">
                            <h3>Office</h3>
                            <div class="officeDv">
                                <div class="thead">
                                    <div>
                                        OFFICE NAME
                                    </div>
                                    <div>
                                        AUTHORITY NUMBERS
                                    </div>
                                </div>
                                <div class="tbody">
                                    <div>
                                        <p><strong>Parent </strong>{{$company->name}}<strong><br>
                                        MY OFFICE</strong> {{$company->address}}
                                        </p>
                                    </div>
                                    <div>
                                        <p>{{ auth()->user()->type }} DOT{{$company->dot}} | {{ auth()->user()->type }} MC{{$company->mc}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Company Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route(auth()->user()->type . '.update_company_profile') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="address">Company Address</label>
                            <input type="text" class="form-control" id="address" name="company_address"
                                placeholder="Enter address" required value="{{ $company->address }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Company Phone Number</label>
                            <input type="tel" class="form-control" required value="{{ $company->phone }}" id="phone" name="company_phone"
                                placeholder="Enter phone number">
                        </div>
                </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
