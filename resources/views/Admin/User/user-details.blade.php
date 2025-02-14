@extends('Admin.layouts.app')
@section('content')
<div class="col-md-10">
   <div class="mainBody">
      <!-- Begin: Notification -->
      @include('layouts.notifications')
      <!-- END: Notification -->
      <div class="main-header">
         <h2>User Detail</h2>
      </div>
      <div class="contBody">
         
         <div class="card">
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>User Name : <span>{{ $user->name }}</span></h5>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Email : <span>{{ $user->email }}</span></h5>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Phone : <span>{{ $user->phone }}</span></h5>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Status : <span>
                        @if($user->status == 1)
                        Active
                        @else
                        In Active
                        @endif
                        </span>
                     </h5>
                  </div>
               </div>
            </div>
            @php
             if($user->parent_id != null){
                    $company = App\Models\Company::where('user_id',$user->parent_id)->first();
             }
             else
            {
                $company = App\Models\Company::where('user_id', $user->id)->first();
            }
            @endphp
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Company Name : <span>{{ $company->name }}</span></h5>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Email : <span>{{ $company->email }}</span></h5>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Phone : <span>{{ $company->phone }}</span></h5>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Membership : <span>{{ $user->type ? $user->type == "trucker" ? "CARIER" : strtoupper($user->type)   : '-' }}</span></h5>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>MC Number : <span>{{ $company->mc }}</span></h5>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Dot Number : <span>{{ $company->dot }}</span></h5>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Address : <span>{{ $company->address }}</span></h5>
                  </div>
               </div>
               
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <h5>Card : <span>{{ $maskedNumber }}</span></h5>
                  </div>
               </div>
                
               
                    <div class="col-md-6">
                      <div class="userdet_info2">
                         <h5>Parent Account : @if($user->parentUser != null)<a href="{{route('super-admin.user_details', $user->parentUser->id)}}"><span>{{ $user->parentUser->name }} <br> <small>{{$user->parentUser->email}}</small></span></a>@else <span>N/A</span>@endif</h5>
                      </div>
                   </div>
               
               
               @if($user->type != "broker")
               @if($onboarding_file)
               <div class="col-md-6">
                  <div class="userdet_info2">
                     <button class="themeBtn" onclick="downloadPDF()">Download Info</buttonc>
                  </div>
               </div>
               @endif
               @endif
            </div>
         </div>
         @if($user->type != "broker")
            @if($onboarding_file)
            <div class="row">
    
           <style>
              /* Carriers View */
              .is-invalid{
              border-color: red !important;
              padding-right: calc(1.5em + 0.75rem);
              background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e);
              background-repeat: no-repeat;
              background-position: right calc(0.375em + 0.1875rem) center;
              background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
              }
              ul.accordion-list .answer .check .is-invalid {
              outline: 1px solid red !important;
              }
              .fileuploadmain.is-invalid {
              border: 1px solid;
              }
              .tabsData-view {
              padding: 3rem 2rem;
              border-bottom: 1px solid rgba(25, 47, 98, 0.13);
              }
              .tabsData-view:last-child {
              border-bottom: 0;
              }
              .tabsData-view h4 {
              color: var(--theme-color);
              font-weight: 600;
              text-transform: capitalize;
              font-size: 2rem;
              }
              .tabsData-view .mainHead {
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-bottom: 1rem;
              }
              .tabsData-view .showHide {
              opacity: 1;
              transition: opacity 0.3s ease;
              position: relative;
              }
    
    
           </style>
           <style>
           .content-to-pdf {
                 /* Overall styles */
           }
    
           .page-break {
                 page-break-before: always; /* Ensure a new page starts */
                 break-before: always;
           }
    
           /* Prevent breaking within certain elements */
           .no-break {
                 page-break-inside: avoid;
                 break-inside: avoid;
           }
           </style>
           @php
           $states = App\Models\State::where('country_id', 233)->get();
           @endphp
    
                          <div class="card shipmentDetails"  id="content-to-pdf">
                             <div class="tabsWrap">
                                <!-- Company Tab -->
                                <div class="tabsData-view companyContent">
                                   <div class="mainHead">
                                      <h4><i class="fas fa-building"></i> Company</h4>
    
                                   </div>
                                   <div class="showHide">
                                      <form method="post" enctype="multipart/form-data" id="step_from_1">
                                         <input type="hidden" id="token" value="{{ csrf_token() }}">
                                         <div class="row">
                                            <div class="col-md-6">
                                               <div class="items">
                                                  <label>Company
                                                  Type:</label>
                                                  <div class="fields">
                                                    <p>
                                                        @if ($onboarding_profile->company_type  == 'Corportion')
                                                        Corportion
                                                        @elseif ($onboarding_profile->company_type == 'Limited Liability Company (LLC)')
                                                        Limited Liability Company (LLC)
                                                        @elseif ($onboarding_profile->company_type  == 'Sole Proprietorship')
                                                        Sole Proprietorship
                                                        @elseif ($onboarding_profile->company_type == 'Partnership')
                                                        Partnership
                                                        @else
                                                        Cooprative (Canada)
                                                        @endif
                                                    </p>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <label>Year
                                                  Founded:</label>
                                                  <div class="fields">
                                                    <p>
                                                        {{$onboarding_profile->year_founded ? Carbon\Carbon::create($onboarding_profile->year_founded)->format('F Y') : '-'}}
                                                    </p>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <label>SCAC(s):
                                                  Seperate using commas</label>
                                                  <div class="fields">
                                                    <p>
                                                        {{ $onboarding_profile->scac ?? '' }}
                                                    </p>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="companyrightDv">
                                                  <div class="checkoptions">
                                                     <div class="items">
                                                        <div class="radioBtns">
                                                           <div class="radios">
                                                              <input type="radio" id="none" name="own_by"
                                                              value="none"
                                                              @if ($onboarding_profile->own_by == 'none' ) checked @endif>
                                                              <label for="none"> None </label>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="items">
                                                        <div class="radioBtns">
                                                           <div class="radios">
                                                              <input type="radio" id="womanowned" name="own_by"
                                                              value="womanowned"
                                                              @if ($onboarding_profile->own_by == 'womanowned' ) checked @endif>
                                                              <label for="womanowned"> Woman
                                                              owned</label>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="items">
                                                        <div class="radioBtns">
                                                           <div class="radios">
                                                              <input type="radio" id="Veteranowned"
                                                              name="own_by" value="Veteranowned"
                                                              @if ($onboarding_profile->own_by == 'Veteranowned') checked @endif>
                                                              <label for="Veteranowned"> Veteran
                                                              owned</label>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="items">
                                                        <div class="radioBtns">
                                                           <div class="radios">
                                                              <input type="radio" id="Minorityowned"
                                                              name="own_by" value="Minorityowned"
                                                              @if ($onboarding_profile->own_by == 'Minorityowned') checked @endif>
                                                              <label for="Minorityowned"> Minority
                                                              owned</label>
                                                           </div>
                                                        </div>
                                                        <div class="displayfield">
                                                           <div class="subitems">
                                                              <label>Minority Type:</label>
                                                              <div class="fields">
                                                                <p>
                                                                    @if ($onboarding_profile->minority_type == 'African American')
                                                                        African American
                                                                    @elseif ($onboarding_profile->minority_type == 'Asian-Indian-American')
                                                                        Asian-Indian-American
                                                                    @elseif ($onboarding_profile->minority_type == 'Asian Pacific')
                                                                        Asian Pacific
                                                                    @elseif ($onboarding_profile->minority_type == 'Hispanic')
                                                                        Hispanic
                                                                    @else
                                                                        Native American Indian
                                                                    @endif
                                                                </p>
                                                              </div>
                                                           </div>
                                                           <div class="radios">
                                                              <input type="radio" id="CertifiedbyNMSDC"
                                                              value="CertifiedbyNMSDC"
                                                              name="is_certified_msdsc" value="CertifiedbyNMSDC"
                                                              @if ($onboarding_profile->is_certified_msdsc == 'CertifiedbyNMSDC') checked @endif>
                                                              <label for="CertifiedbyNMSDC">
                                                              Certified
                                                              by NMSDC</label>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-md-6">
                                               <h3 class="mt-0">Do you use a factoring company?</h3>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="radioBtns">
                                                  <div class="radios">
                                                     <input type="radio" id="yes01" checked
                                                     name="has_factory_company" value="true"
                                                     onclick="toggleDiv(true)"
                                                     @checked ($onboarding_profile->has_factory_company == 'yes')
                                                     >
                                                     <label for="yes01"> Yes</label>
                                                  </div>
                                                  <div class="radios">
                                                     <input type="radio" id="no1" value="false"
                                                     onclick="toggleDiv(false)"
                                                     @checked ($onboarding_profile->has_factory_company == 'no')
                                                     name="has_factory_company">
                                                     <label for="no1"> No</label>
                                                  </div>
                                               </div>
                                            </div>
                                            @if($onboarding_profile->has_factory_company == 'no')
                                            <div class="page-break"></div>
                                            <div class="no-break"></div>
                                            <div class="no-break"></div>
                                            <div class="no-break"></div>
                                            @endif
                                            <div class="col-md-10" id="hide_PaymentRemit" @if($onboarding_profile->has_factory_company == 'yes')style="display: block" @else style="display: none;" @endif>
                                            
                                            <div class="row">
                                                <div class="col-md-8">
                                                   <div class="file-upload-form uploader">
                                                      @php
                                                      $file_1 = $onboarding_file;
                                                      @endphp
                                                      @if ($file_1->where('file_type','step_1_file')->first() != null)
                                                      <div class="file-upload-info" style="margin-top: 10px;">
                                                         <a href="{{asset('assets/images/onboarding_files/' . $file_1->where('file_type','step_1_file')->first()->file_name . ' ') }}" target="_blank">
                                                         <img class="file-preview" style="max-width: 100px;"
                                                          src="{{ asset('assets/images/onboarding_files/' . $file_1->where('file_type','step_1_file')->first()->file_name . ' ') }}"  />
                                                          </a>
                                                      </div>
                                                      @endif
                                                   </div>
                                                </div>
                                                <div class="col-md-12">
                                                <h3>Payment Remit to Address</h3>
                                                <div class="items">
                                                   <label>Factoring Company Name:</label>
                                                   <div class="fields">
                                                      <p>{{ $onboarding_profile->factory_name ?? '-' }}</p>
                                                   </div>
                                                </div>
                                                <div class="items">
                                                   <label>Street:</label>
                                                   <div class="fields">
                                                      <p>{{ $onboarding_profile->street ?? '-' }}</p>
                                                   </div>
                                                </div>
                                                <div class="items">
                                                   <label>City:</label>
                                                   <div class="fields">
                                                      <p>{{ $onboarding_profile->city ?? '-' }}</p>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-9">
                                                      <div class="items">
                                                         <label>State/Province:</label>
                                                         <div class="fields">
                                                            <p>
                                                               {{ $states->firstWhere('id', $onboarding_profile->state)->name ?? '-' }}
                                                            </p>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="items">
                                                         <label>Postal Code:</label>
                                                         <div class="fields">
                                                            <p>{{ $onboarding_profile->postal_code ?? '-' }}</p>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="page-break"></div>
                                                <div class="no-break"></div>
                                                <div class="row">
                                                   <div class="col-md-9">
                                                      <div class="items">
                                                         <label>Phone Number:</label>
                                                         <div class="fields">
                                                            <p>{{ $onboarding_profile->phone_num ?? '-' }}</p>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="items">
                                                         <label>Ext:</label>
                                                         <div class="fields">
                                                            <p>{{ $onboarding_profile->extansion ?? '-' }}</p>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             </div>
    
                                            </div>
                                         </div>
                                      </form>
                                   </div>
                                </div>
                             <!-- Contacts Tab -->
    
                             <div class="tabsData-view contactsContent ">
                                <div class="mainHead">
                                   <h4><i class="fas fa-user"></i> Contacts</h4>
                                </div>
                                <div class="showHide">
    
                                   <form method="post" id="step_from_2">
                                      <input type="hidden" id="token" value="{{ csrf_token() }}">
                                      <div class="listscontacts">
                                         <div class="head">
                                            <h3>Owner/Officer</h3>
                                         </div>
                                         <div class="contactsDet-users bglightgrey">
                                            <div class="row align-items-center">
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Name:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->officer_name ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="row">
                                                     <div class="col-md-9">
                                                        <div class="items">
                                                           <label>Phone:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->officer_phone ?? '-' }}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-md-3">
                                                        <div class="items">
                                                           <label>Ext:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->officer_ext ?? '-' }}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Email:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->officer_email ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Title:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->officer_title ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Fax:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->officer_fax ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="officer_is_primary"
                                                        @if ($onboarding_profile->officer_is_primary == 'yes') checked @endif
                                                        id="officer_is_primary">
                                                        <label for="officer_is_primary"> Primary</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
    
                                      </div>
                                      <div class="listscontacts">
                                         <div class="head">
                                            <h3>Accounting</h3>
                                         </div>
                                         <div class="contactsDet-users bglightgrey">
                                            <div class="row align-items-center">
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Name:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->accounting_name ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="row">
                                                     <div class="col-md-8">
                                                        <div class="items">
                                                           <label>Phone:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->accounting_phone ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-md-4">
                                                        <div class="items">
                                                           <label>Ext:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->accounting_ext ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Email:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->accounting_email ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Title:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->accounting_title ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Fax:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->accounting_fax ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="accounting_is_primary" id="accounting_is_primary" value="yes"
                                                        @checked($onboarding_profile->accounting_is_primary == 'yes')>
                                                        <label for="accounting_is_primary"> Primary</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
    
                                      </div>
                                      <div class="page-break"></div>
                                      <div class="no-break"></div>
                                      <div class="listscontacts">
                                         <div class="head">
                                            <h3>Dispatch & Operations</h3>
                                         </div>
                                         <div class="contactsDet-users bglightgrey">
                                            <div class="row align-items-center">
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Name:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->operation_name ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="row">
                                                     <div class="col-md-9">
                                                        <div class="items">
                                                           <label>Phone:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->operation_phone ?? '-' }}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-md-3">
                                                        <div class="items">
                                                           <label>Ext:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->operation_ext ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Email:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->operation_email ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Title:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->operation_title ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Fax:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->operation_fax ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" value="yes"
                                                           @checked($onboarding_profile->operation_is_primary == 'yes')
                                                           name="operation_is_primary" id="operation_is_primary">
                                                        <label for="operation_is_primary"> Primary</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
    
                                      </div>
                                      <div class="listscontacts">
                                         <div class="head">
                                            <h3>Safety & Claims</h3>
    
                                         </div>
                                         <div class="contactsDet-users bglightgrey">
                                            <div class="row align-items-center">
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Name:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->safety_name ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="row">
                                                     <div class="col-md-9">
                                                        <div class="items">
                                                           <label>Phone:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->safety_phone ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-md-3">
                                                        <div class="items">
                                                           <label>Ext:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->safety_ext ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Email:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->safety_email ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Title:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->safety_title ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Fax:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->safety_fax ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" value="yes"
                                                           name="safety_is_primary" id="safety_is_primary"
                                                           @checked($onboarding_profile->safety_is_primary == 'yes')>
                                                        <label for="safety_is_primary"> Primary</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
    
                                      </div>
                                      <div class="listscontacts">
                                         <div class="head">
                                            <h3>After Hours & Emergency</h3>
    
                                         </div>
                                         <div class="contactsDet-users bglightgrey">
                                            <div class="row align-items-center">
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Name:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->emergency_name ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="row">
                                                     <div class="col-md-9">
                                                        <div class="items">
                                                           <label>Phone:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->emergency_phone ?? '-'}}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-md-3">
                                                        <div class="items">
                                                           <label>Ext:</label>
                                                           <div class="fields">
                                                              <p>{{ $onboarding_profile->emergency_ext ?? '-' }}</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Email:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->emergency_email ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Title:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->emergency_title ?? '-' }}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="items">
                                                     <label>Fax:</label>
                                                     <div class="fields">
                                                        <p>{{ $onboarding_profile->emergency_title ?? '-'}}</p>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-4">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="emergency_is_primary"
                                                           value="yes" @checked($onboarding_profile->emergency_is_primary == 'yes')
                                                           id="emergency_is_primary">
                                                        <label for="emergency_is_primary"> Primary</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
    
                                      </div>
                                      <div class="page-break"></div>
                                      <div class="no-break"></div>
                                      <div class="refrencesmain">
                                        <h3>Adding References</h3>
                                        <p>References</p>
                                        <div class="refrencestable">
                                           <div class="tableshead">
                                              <div class="row">
                                                 <div class="col-md-3">
                                                    <div class="divs">Company</div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs">Name</div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs">Phone</div>
                                                 </div>
                                                 <div class="col-md-1">
                                                    <div class="divs">Ext</div>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="tablesbody contactsContent">
                                              <div class="items">
                                                 <div class="steps firststep">
                                                    <div class="row active">
                                                       <div class="col-md-3">
                                                          <div class="divs fields">
                                                             <p>{{ $onboarding_refrnces->company ?? '-' }}</p>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-3">
                                                          <div class="divs fields">
                                                             <p>{{ $onboarding_refrnces->name ?? '-' }}</p>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-3">
                                                          <div class="divs fields">
                                                             <p>{{ $onboarding_refrnces->company_phone ?? '-' }}</p>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-1">
                                                          <div class="divs fields">
                                                             <p>{{ $onboarding_refrnces->company_ext ?? '-' }}</p>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
    
    
                                   </form>
                                </div>
                             </div>
                             <!-- Fleet Tab -->
                             <div class="tabsData-view fleetContent">
                                <div class="mainHead">
                                   <h4><i class="fas fa-truck"></i> Fleet</h4>
                                </div>
                                <div class="showHide"id="div_step_from_3">
    
                                   <form method="post" id="step_from_3">
                                      <div class="items">
                                         <h3>Fleet Information</h3>
                                         <div class="fleetList">
                                            <p>Number of Power Units:</p>
                                            <p>{{ $onboarding_profile->number_of_power_units ?? '-' }}</p>
                                         </div>
                                         <div class="fleetList">
                                            <p>Number of Owner Operators (using their own authority):</p>
                                            <p>{{ $onboarding_profile->number_of_owner_operators ?? '-' }}</p>
                                         </div>
                                         <div class="fleetList">
                                            <p>Number of Company Drivers:</p>
                                            <p>{{ $onboarding_profile->number_of_company_drivers ?? '-' }}</p>
                                         </div>
                                         <div class="fleetList">
                                            <p>Number of Teams:</p>
                                            <p>{{ $onboarding_profile->number_of_teams ?? '-' }}</p>
                                         </div>
                                         <div class="fleetList">
                                            <p>On Board Communications:</p>
                                            <div class="radioBtns">
                                               <div class="radios">
                                                  <input type="radio" id="board_Cell"
                                                  name="on_board_contractors" @checked($onboarding_profile->on_board_contractors == 'Cell')
                                                  value="Cell">
                                                  <label for="board_Cell"> Cell</label>
                                               </div>
                                               <div class="radios">
                                                  <input type="radio" id="board_Satellite"
                                                  name="on_board_contractors" @checked($onboarding_profile->on_board_contractors == 'Satellite')
                                                  value="Satellite">
                                                  <label for="board_Satellite"> Satellite</label>
                                               </div>
                                               <div class="radios">
                                                  <input type="radio" id="board_None"
                                                  name="on_board_contractors" @checked($onboarding_profile->on_board_contractors == 'None')
                                                  value="None">
                                                  <label for="board_None"> None</label>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                </form>
                             </div>
                          </div>
                          <div class="page-break"></div>
                          <div class="no-break"></div>
                          @if($onboarding_profile->has_factory_company == 'no')
                             <div class="no-break"></div>
                             <div class="no-break"></div>
                          @endif
                          <div class="tabsData-view laneContent">
                             <div class="mainHead">
                                <h4><i class="fas fa-tachometer-slowest"></i> Lanes</h4>
                             </div>
                             <div class="showHide">
                                <h3>Preferred Lanes</h3>
                                <div class="refrencestable">
                                   <form method="post" id="step_from_4">
                                      <div class="tableshead">
                                         <div class="row">
                                            <div class="col-md-3">
                                               <div class="divs">Origin</div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="divs">Destination</div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="divs"></div>
                                            </div>
                                            <div class="col-md-1">
                                               <div class="divs"></div>
                                            </div>
                                            <div class="col-md-2">
                                               <div class="divs"></div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="tablesbody contactsContent">
                                        <div class="items">
                                           <div class="steps firststep">
                                              <div class="row active">
                                                 <div class="col-md-3">
                                                    <div class="divs fields">
                                                       <p>{{ isset($onboard_lanes[0]) ? $onboard_lanes[0]->origin : '-' }}</p>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs fields">
                                                       <p>{{ isset($onboard_lanes[0]) ? $onboard_lanes[0]->destination : '-' }}</p>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs fields">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-1">
                                                    <div class="divs fields">
                                                    </div>
                                                 </div>
                                                 <div class="col-md-2">
                                                    <div class="divs btnmain">
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
    
                                        @if ($onboard_lanes->count() > 0)
                                           @foreach ($onboard_lanes as $key => $onboard_lane)
                                              @php
                                                 $random_id = substr(bin2hex(random_bytes(ceil(7 / 2))), 0, 7);
                                              @endphp
                                              @if ($key == 0)
                                                 @continue
                                              @endif
                                              <div class="items">
                                                 <div class="steps firststep">
                                                    <div class="row active" id="id_{{ $random_id }}">
                                                       <div class="col-md-3">
                                                          <div class="divs fields">
                                                             <p>{{ $onboard_lane->origin }}</p>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-3">
                                                          <div class="divs fields">
                                                             <p>{{ $onboard_lane->destination }}</p>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-1">
                                                          <div class="divs fields">
                                                          </div>
                                                       </div>
                                                       <div class="col-md-2">
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           @endforeach
                                        @endif
                                        <div id="append_areas"></div>
                                     </div>
    
                                      <h3>Preferred Areas</h3>
                                      <ul class="accordion-list">
                                         <li class="active" id="canada_areas">
                                            <div class="accordhead">
                                               <h3>Canada & Mexico</h3>
                                               <div class="allzones">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" id="AllZones">
                                                        <label for="AllZones"> All Zones</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="answer">
                                               <div class="checkboxflex">
                                                  <div class="lists zonCm0">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" name="canada_maxico[]" value="Zone 0" id="Zonecm0">
                                                                 <label for="Zonecm0"> Zone 0</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="CT" id="Zones-01">
                                                                       <label for="Zones-01"> CT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="ME" id="Zones-02">
                                                                       <label for="Zones-02"> ME</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="MA" id="Zones-03">
                                                                       <label for="Zones-03"> MA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="NH" id="Zones-04">
                                                                       <label for="Zones-04"> NH</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="NJ" id="Zones-05">
                                                                       <label for="Zones-05"> NJ</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="RI" id="Zones-07">
                                                                       <label for="Zones-07"> RI</label>
                                                                    </div>
                                                                 </div>
                                                                 <p></p>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="VT" id="Zones-06">
                                                                       <label for="Zones-06"> VT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonCm1">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox"name="canada_maxico[]" value="Zone 1" id="Zonecm1">
                                                                 <label for="Zonecm1"> Zone 1</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="DE" id="Zones1-1">
                                                                       <label for="Zones1-1"> DE</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="NY" id="Zones1-2">
                                                                       <label for="Zones1-2"> NY</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="PA" id="Zones1-3">
                                                                       <label for="Zones1-3"> PA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonCm2">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" name="canada_maxico[]" value="Zone 2" id="Zonecm2">
                                                                 <label for="Zonecm2"> Zone 2</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="DC" id="Zones2-1">
                                                                       <label for="Zones2-1"> DC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="MD" id="Zones2-2">
                                                                       <label for="Zones2-2"> MD</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="NC" id="Zones2-3">
                                                                       <label for="Zones2-3"> NC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="SC" id="Zones2-4">
                                                                       <label for="Zones2-4"> SC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="VA" id="Zones2-5">
                                                                       <label for="Zones2-5"> VA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="WV" id="Zones2-6">
                                                                       <label for="Zones2-6"> WV</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="RI" id="Zones2-7">
                                                                       <label for="Zones2-7"> RI</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="VT" id="Zones-06">
                                                                       <label for="Zones-06"> VT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonCm3">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" name="canada_maxico[]" value="Zone 3" id="Zonecm3">
                                                                 <label for="Zonecm3"> Zone 3</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="AL" id="Zones3-1">
                                                                       <label for="Zones3-1"> AL</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="FL" id="Zones3-2">
                                                                       <label for="Zones3-2"> FL</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="GA" id="Zones3-3">
                                                                       <label for="Zones3-3"> GA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="MS" id="Zones3-4">
                                                                       <label for="Zones3-4"> MS</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="TN" id="Zones3-5">
                                                                       <label for="Zones3-5"> TN</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonCm4">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" name="canada_maxico[]" value="Zone 4" id="Zonecm4">
                                                                 <label for="Zonecm4"> Zone 4</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input
                                                                          type="checkbox"name="canada_maxico[]"
                                                                          value="IN" id="Zones4-1">
                                                                       <label for="Zones4-1"> IN</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="KY" id="Zones4-2">
                                                                       <label for="Zones4-2"> KY</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="MI" id="Zones4-4">
                                                                       <label for="Zones4-4"> MI</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="canada_maxico[]"
                                                                          value="OH" id="Zones4-3">
                                                                       <label for="Zones4-3"> OH</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                               </div>
                                            </div>
                                         </li>
                                         <div class="page-break"></div>
                                         <div class="no-break"></div>
                                         <div class="no-break"></div>
                                         <div class="no-break"></div>
                                         <li class="active" id="unitedstates_areas">
                                            <div class="accordhead">
                                               <h3>United States</h3>
                                               <div class="allzones">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" id="AllZones1">
                                                        <label for="AllZones1"> All Zones</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="answer">
                                               <div class="checkboxflex">
                                                  <div class="lists zonUs0">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" id="Zoneus0"   name="united_states_zones[]"
                                                                    value="Zones0">
                                                                 <label for="Zoneus0"> Zone 0</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="CT" id="Zones-01">
                                                                       <label for="Zones-01"> CT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="ME" id="Zones-02">
                                                                       <label for="Zones-02"> ME</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="MA" id="Zones-03">
                                                                       <label for="Zones-03"> MA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="NH" id="Zones-04">
                                                                       <label for="Zones-04"> NH</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="NJ" id="Zones-05">
                                                                       <label for="Zones-05"> NJ</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="RI" id="Zones-07">
                                                                       <label for="Zones-07"> RI</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="VT" id="Zones-06">
                                                                       <label for="Zones-06"> VT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonUs1">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox"   name="united_states_zones[]" id="Zoneus1" value="Zones1">
                                                                 <label for="Zoneus1"> Zone 1</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="DE" id="Zones1-1">
                                                                       <label for="Zones1-1"> DE</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="NY" id="Zones1-2">
                                                                       <label for="Zones1-2"> NY</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="PA" id="Zones1-3">
                                                                       <label for="Zones1-3"> PA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonUs2">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" id="Zoneus2"  name="united_states_zones[]"
                                                                    value="Zones2" >
                                                                 <label for="Zoneus2"> Zone 2</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="DC" id="Zones2-1">
                                                                       <label for="Zones2-1"> DC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="MD" id="Zones2-2">
                                                                       <label for="Zones2-2"> MD</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="NC" id="Zones2-3">
                                                                       <label for="Zones2-3"> NC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="SC" id="Zones2-4">
                                                                       <label for="Zones2-4"> SC</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="VA" id="Zones2-5">
                                                                       <label for="Zones2-5"> VA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="WV" id="Zones2-6">
                                                                       <label for="Zones2-6"> WV</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="RI" id="Zones2-7">
                                                                       <label for="Zones2-7"> RI</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="VT" id="Zones-06">
                                                                       <label for="Zones-06"> VT</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonUs3">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox"
                                                                    name="united_states_zones[]"
                                                                    value="Zones3" id="Zoneus3">
                                                                 <label for="Zoneus3"> Zone 3</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="AL" id="Zones3-1">
                                                                       <label for="Zones3-1"> AL</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="FL" id="Zones3-2">
                                                                       <label for="Zones3-2"> FL</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="GA" id="Zones3-3">
                                                                       <label for="Zones3-3"> GA</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="MS" id="Zones3-4">
                                                                       <label for="Zones3-4"> MS</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="TN" id="Zones3-5">
                                                                       <label for="Zones3-5"> TN</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                                  <div class="lists zonUs4">
                                                     <ul>
                                                        <li>
                                                           <div class="contactchecks">
                                                              <div class="check">
                                                                 <input type="checkbox" name="united_states_zones[]" id="Zoneus4" value="Zones4">
                                                                 <label for="Zoneus4"> Zone 4</label>
                                                              </div>
                                                           </div>
                                                           <ul>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="IN" id="Zones4-1">
                                                                       <label for="Zones4-1"> IN</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="KY" id="Zones4-2">
                                                                       <label for="Zones4-2"> KY</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="MI" id="Zones4-4">
                                                                       <label for="Zones4-4"> MI</label>
                                                                    </div>
                                                                 </div>
                                                                 <p></p>
                                                              </li>
                                                              <li>
                                                                 <div class="contactchecks">
                                                                    <div class="check">
                                                                       <input type="checkbox"
                                                                          name="united_states_zones[]"
                                                                          value="OH" id="Zones4-3">
                                                                       <label for="Zones4-3"> OH</label>
                                                                    </div>
                                                                 </div>
                                                              </li>
                                                           </ul>
                                                        </li>
                                                     </ul>
                                                  </div>
                                               </div>
                                            </div>
                                         </li>
                                      </ul>
                                      <input type="hidden" name="form_id"
                                         value="{{ $onboarding_profile->id ?? '-' }}">
    
                                   </form>
                                </div>
                             </div>
                          </div>
                          <div class="page-break"></div>
                          <div class="no-break"></div>
                          <!-- Documents Tab -->
                          <div class="tabsData-view docsContent">
                             <div class="mainHead">
                                <h4><i class="far fa-file-alt"></i> Documents</h4>
                             </div>
                             <div class="showHide">
                                <form method="post" id="step_from_6" enctype="multipart/form-data">
                                   <div class="row align-items-center justify-content-between">
                                      <div class="col-md-6">
                                         <p class="mb-0">Add any documents you want to include as part of your
                                            profile, such as an authority, insurance or Hazmat certificate or
                                            schedule of vehicles.
                                         </p>
                                      </div>
                                      <div class="col-md-4">
    
                                      </div>
                                   </div>
                                   <h3>Uploaded</h3>
                                   <div class="refrencestable">
                                      <div class="tableshead">
                                         <div class="row">
                                            <div class="col-md-3">
                                               <div class="divs">Name</div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="divs">Type</div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="divs">Description</div>
                                            </div>
                                            <div class="col-md-1">
                                               <div class="divs">File</div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="tablesbody contactsContent">
                                         <div class="items">
                                            <div class="steps active">
                                               <div class="row active">
                                                <div class="col-md-3">
                                                    <div class="divs fields">
                                                       <p>{{ $onboarding_profile->doc_name ?? '-'}}</p>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs fields">
                                                       <p>
                                                          {{ $onboarding_profile->doc_type == "Hazmat cert" ? 'Hazmat cert' :
                                                             ($onboarding_profile->doc_type == "W9" ? 'W9' :
                                                             ($onboarding_profile->doc_type == "Hazmat Permit" ? 'Hazmat Permit' :
                                                             ($onboarding_profile->doc_type == "MC" ? 'MC' :
                                                             ($onboarding_profile->doc_type == "Misc Permits" ? 'Misc Permits' : '')))) }}
                                                       </p>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-3">
                                                    <div class="divs fields">
                                                       <p>{{ $onboarding_profile->doc_description ?? '-' }}</p>
                                                    </div>
                                                 </div>
                                                  @php
                                                  $file_6 = App\Models\OnboardProfileFiles::where('form_id', $onboarding_profile->id)->where('file_type','step_6_file')->first();
                                                  @endphp
                                                  <div class="col-md-2">
                                                     <div class="divs fields filenameput">
                                                        @if($file_6 != null)
                                                        <a href="{{ asset('assets/images/onboarding_files/' . $file_6->file_name ?? '-' . '') }}" target="_blank"><img class="file-preview" style="max-width: 100px;" src="{{ asset('assets/images/onboarding_files/' .( $file_6->file_name ?? '')) }}" /></a>
                                                        @endif
                                                     </div>
                                                  </div>
                                                 
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
    
                                </form>
                             </div>
                          </div>
                          <!-- Insurance Tab -->
                          <div class="tabsData-view insuranceContent ">
                             <div class="mainHead">
                                <h4><i class="fas fa-shield"></i> Insurance </h4>
                             </div>
                             <div class="showHide">
    
                                <br>
                                <form method="post" id="step_from_7">
                                   <div class="listscontacts">
                                      <div class="head">
                                         <h3>Contact Information for your insurance</h3>
                                        
                                      </div>
                                      <div class="contactsDet-users bglightgrey">
                                         <div class="row active">
                                            <div class="col-md-3">
                                               <h3 class="mt-0">Coverage :</h3>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" value="true"
                                                        name="coverage_auto" @checked($onboarding_profile->coverage_auto == 'true')
                                                        id="coverage01">
                                                        <label for="coverage01"> Auto</label>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="coverage_cargo"
                                                        @checked($onboarding_profile->coverage_cargo == 'true') value="true"
                                                        id="coverage02">
                                                        <label for="coverage02"> Cargo</label>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="coverage_general"
                                                        @checked($onboarding_profile->coverage_general == 'true') value="true"
                                                        id="coverage03">
                                                        <label for="coverage03"> General</label>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" name="coverage_workers_comp"
                                                        @checked($onboarding_profile->coverage_workers_comp == 'true')
                                                        value="true" id="coverage04">
                                                        <label for="coverage04"> Worker's Comp</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-9">
                                               <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="items">
                                                       <label>Agent:</label>
                                                       <div class="fields">
                                                          <p>{{ $onboarding_profile->insurance_agent ?? '-' }}</p>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                    <div class="row">
                                                       <div class="col-md-9">
                                                          <div class="items">
                                                             <label>Phone:</label>
                                                             <div class="fields">
                                                                <p>{{ $onboarding_profile->insurance_phone ?? '-' }}</p>
                                                             </div>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-3">
                                                          <div class="items">
                                                             <label>Ext:</label>
                                                             <div class="fields">
                                                                <p>{{ $onboarding_profile->insurance_ext ?? '-'}}</p>
                                                             </div>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
    
                                                  <div class="col-md-4">
                                                     <div class="file-upload-form uploader">
                                                        @php
                                                        $file_7 = App\Models\OnboardProfileFiles::where('form_id', $onboarding_profile->id)->where('file_type','step_7_file')->first();
                                                        @endphp
                                                        @if($file_7 != null)
                                                        <div class="file-upload-info" style="margin-top: 10px;">
                                                          <a href="{{ asset('assets/images/onboarding_files/' . $file_7->file_name . '') }}" target="_blank">
                                                           <img class="file-preview"
                                                           src="{{ asset('assets/images/onboarding_files/' . $file_7->file_name . '') }}"
                                                           style="max-width: 100px;" />
                                                           </a>
                                                        </div>
                                                        @endif
                                                     </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="items">
                                                       <label>Email:</label>
                                                       <div class="fields">
                                                        <p>{{ $onboarding_profile->insurance_email ?? '-' }}</p>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                    <div class="items">
                                                       <label>Fax:</label>
                                                       <div class="fields">
                                                        <p>{{ $onboarding_profile->insurance_fax ?? '-'}}</p>
                                                       </div>
                                                    </div>
                                                 </div>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="contactsDet-users-show" style="display:none">
                                         <div class="row">
                                            <div class="col-md-3">
                                               <h3 class="mt-0">Coverage :</h3>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" value="Auto"
                                                        name="coverage_auto" id="coverage01"
                                                        @checked($onboarding_profile->coverage_auto == 'Auto')>
                                                        <label for="coverage01"> Auto</label>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="items">
                                                  <div class="contactchecks">
                                                     <div class="check">
                                                        <input type="checkbox" id="coverage02"
                                                        name="coverage_cargo" value="Cargo"
                                                        @checked($onboarding_profile->coverage_cargo == 'Cargo')>
                                                        <label for="coverage02"> Cargo</label>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-9">
                                               <div class="row align-items-center">
                                                  <div class="col-md-4">
                                                     <div class="items">
                                                        <label>Agent:</label>
                                                        <p>Superman</p>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                     <div class="row">
                                                        <div class="col-md-9">
                                                           <div class="items">
                                                              <label>Phone:</label>
                                                              <p>(123) 456-7890</p>
                                                           </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                           <div class="items">
                                                              <label>Ext:</label>
                                                              <p>(123)</p>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                     <div class="items filenameput">
                                                        <p class=""></p>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                     <div class="items">
                                                        <label>Email:</label>
                                                        <p>info@pttrboard.com</p>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                     <div class="items">
                                                        <label>Fax:</label>
                                                        <p></p>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
    
                                </form>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
            </div>
            @endif
         @endif
</div>
</div>
@endsection
@if($user->type != "broker")
@if($onboarding_file)
@push('js')
@php
 if(isset($file_1)){
        $ff = $file_1->where('file_type', 'step_1_file')->first();
    }else{
        $ff = null;
    }
    @endphp
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
      <script>
          function downloadPDF() {
        // Us div ko select karo jiska content PDF mein chahiye
        const element = document.getElementById("content-to-pdf");

        // HTML2PDF ke options set karo
        const options = {
            margin:       0, // PDF ke margins
            filename:     'download.pdf', // PDF ka naam
            image:        { type: 'jpeg', quality: 0.98 }, // Image ka quality
            html2canvas:  { scale: 2 }, // HTML ko canvas mein render karne ka scale
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' } // PDF format aur orientation
        };

        // PDF generate karo aur download karo
        html2pdf().set(options).from(element).save();
    }

      </script>
    <script>
            var state_tf = "{{$onboarding_profile->state != null ? true : false }}";
            $( window ).on("load", function() {
                if($("#yes01").prop('checked') == true){
                      $('#yes01').trigger('click');
                        $('#factoring_company_files').show();
                        $('#factoring_company_files').removeAttr('required');
                        $('#factoring_company_files').hide();
                }
                else{
                      $('#no1').trigger('click');
                }
                console.log(state_tf);
                if(state_tf == true){
                    $('#state').trigger("change");
                }


                if($("#Minorityowned").prop('checked') == true){
                        $('.displayfield').show();
                }else{
                      $('.displayfield').hide();
                }
            });
        $(document).ready(function() {
            $('.checkoptions .radioBtns input[type="radio"]').change(function() {
                var isChecked = $(this).prop('checked');
                $('.items .displayfield').slideUp();
                if (isChecked) {
                    $(this).closest('.items').find('.displayfield').slideToggle();
                }
            });
        });



        $('.accordion-list > li > .answer').show();
        $('.accordion-list > li.active .answer').show();


        $('.accordhead .check').click(function(e) {
            e.stopPropagation();
        });

        function updateAllZonesCheckbox() {
            if ($('#canada_areas input[type="checkbox"]').not('#AllZones').length === $('#canada_areas input[type="checkbox"]:checked').not('#AllZones').length) {
                $('#AllZones').prop('checked', true);
            } else {
                $('#AllZones').prop('checked', false);
            }
        }

        function updateAllZones1() {
            if ($('#unitedstates_areas input[type="checkbox"]').not('#AllZones1').length === $('#unitedstates_areas input[type="checkbox"]:checked').not('#AllZones1').length) {
                $('#AllZones1').prop('checked', true);
            } else {
                $('#AllZones1').prop('checked', false);
            }
        }

        $(document).ready(function() {

            var checkedValuescanada = @json($onboarding_canada_areas->pluck('all_areas_of_canada'));
            var checkedValuesunitedstates = @json($onboarding_unitedstates_areas->pluck('all_areas_of_usa'));

            if (checkedValuescanada.length > 0) {
                $('#canada_areas').find('input[type=checkbox]').each(function() {
                    if (checkedValuescanada.includes($(this).val())) {
                         $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                });
            }

            if (checkedValuesunitedstates.length > 0) {
                $('#unitedstates_areas').find('input[type=checkbox]').each(function() {
                    if (checkedValuesunitedstates.includes($(this).val())) {
                         $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                });
            }

              updateAllZonesCheckbox();
              updateAllZones1();
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showHideSections = document.querySelectorAll('.showHide');
            showHideSections.forEach(section => {
                const formFields = section.querySelectorAll('input, select');
                formFields.forEach(field => {
                    field.disabled = true; // Disable fields initially
                });
            });
        });

        function toggleDiv(show) {
            const factoryDetails = document.getElementById('hide_PaymentRemit');
            if (show) {
                factoryDetails.style.display = 'block'; // Show the div
                $('#factoring_company_files').attr('required', {{ $ff != null ? 'false' : 'true' }} );
                $('#factoring_company_files').hide();
                $('#factory_name').attr('required', 'true');
                $('#street').attr('required', 'true');
                $('#company_city').attr('required', 'true');
                $('#state').attr('required', 'true');
                $('#postal_code').attr('required', 'true');
                $('#phone_num').attr('required', 'true');
            } else {
               $('#factoring_company_files').show();
               $('#factoring_company_files').removeAttr('required');
                $('#factory_name').removeAttr('required');
                $('#street').removeAttr('required');
                $('#company_city').removeAttr('required');
                $('#state').removeAttr('required');
                $('#postal_code').removeAttr('required');
                $('#phone_num').removeAttr('required');
                factoryDetails.style.display = 'none'; // Hide the div
            }
        }
    </script>
@endpush
@endif
@endif
