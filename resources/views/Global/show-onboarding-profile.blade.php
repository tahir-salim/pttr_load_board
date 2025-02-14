@extends('layouts.app')
@section('content')
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

        .tabsData-view .showHide:before {
            content: '';
            position: absolute;
            z-index: 1;
            background: #ffffff00;
            width: 100%;
            height: 100%;
        }

        .tabsData-view .showHide.active:before {
            display: none;
        }
    </style>
    @php
        $states = App\Models\State::where('country_id', 233)->get();
    @endphp

    <div class="col-md-10">
        <div class="mainBody">
            @include('layouts.notifications')
            <div class="main-header">
                <h2>Completing my Carrier OnBoard View profile</h2>
            </div>
            <div class="contBody">
                <div class="alert alert-danger" id="error_alert" style="display: none;">
                    <strong>Whoops!</strong> There was some problem with your input.<br><br>
                    <ul>
                        <li>*Please ensure all required fields are filled out correctly.</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shipmentDetails">
                            <div class="tabsWrap">
                                <!-- Company Tab -->
                                <div class="tabsData-view companyContent">
                                    <div class="mainHead">
                                        <h4><i class="fas fa-building"></i> Company</h4>
                                        <a href="javascript:;" class="themeBtn">Edit</a>
                                    </div>
                                    <div class="showHide">
                                        <p>Items marked with<span class="requiredstar">*</span> are required
                                            to
                                            complete your profile.</p>
                                        <form method="post" enctype="multipart/form-data" id="step_from_1">
                                            <input type="hidden" id="token" value="{{ csrf_token() }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="items">
                                                        <label><span class="requiredstar">*</span>Company
                                                            Type:</label>
                                                        <div class="fields">
                                                            <select name="company_type" id="company_type" required>
                                                                <option value="" selected disabled></option>
                                                                <option value="Corportion"
                                                                    @if ($onboarding_profile->company_type  == 'Corportion') selected @endif>
                                                                    Corportion</option>
                                                                <option value="Limited Liability Company (LLC)"
                                                                    @if ($onboarding_profile->company_type == 'Limited Liability Company (LLC)') selected @endif>
                                                                    Limited Liability Company (LLC)</option>
                                                                <option value="Sole Proprietorship"
                                                                    @if ($onboarding_profile->company_type  == 'Sole Proprietorship') selected @endif>Sole
                                                                    Proprietorship</option>
                                                                <option value="Partnership"
                                                                    @if ($onboarding_profile->company_type == 'Partnership') selected @endif>
                                                                    Partnership</option>
                                                                <option value="Cooprative (Canada)"
                                                                    @if ($onboarding_profile->company_type == 'Cooprative (Canada)') selected @endif>
                                                                    Cooprative (Canada)</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="items">
                                                        <label><span class="requiredstar">*</span>Year
                                                            Founded:</label>
                                                        <div class="fields">
                                                            <input type="month" name="year_founded"
                                                                value="{{ $onboarding_profile->year_founded ?? '' }}"
                                                                id="year_founded" required>
                                                        </div>
                                                    </div>
                                                    <div class="items">
                                                        <label><span class="requiredstar">*</span>SCAC(s):
                                                            Seperate using commas</label>
                                                        <div class="fields">
                                                            <input type="text" name="scac" id="scac"
                                                                placeholder="e.g. ABCD, EFGH" required
                                                                value="{{ $onboarding_profile->scac ?? '' }}">
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
                                                                            <select name="minority_type" id="">
                                                                                <option value="" selected></option>
                                                                                <option value="African American"
                                                                                    @if ($onboarding_profile->minority_type == 'African American') selected @endif>
                                                                                    African American
                                                                                </option>
                                                                                <option value="Asian-Indian-American"
                                                                                    @if ($onboarding_profile->minority_type == 'Asian-Indian-American') selected @endif>
                                                                                    Asian-Indian-American
                                                                                </option>
                                                                                <option value="Asian Pacific"
                                                                                    @if ($onboarding_profile->minority_type == 'Asian Pacific') selected @endif>
                                                                                    Asian Pacific
                                                                                </option>
                                                                                <option value="Hispanic"
                                                                                    @if ($onboarding_profile->minority_type == 'Hispanic') selected @endif>
                                                                                    Hispanic
                                                                                </option>
                                                                                <option value="Native American Indian"
                                                                                    @if ($onboarding_profile->minority_type == 'Native American Indian') selected @endif>
                                                                                    Native American Indian
                                                                                </option>
                                                                            </select>
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
                                                <div id="hide_PaymentRemit" @if($onboarding_profile->has_factory_company == 'yes')style="display: block" @else style="display: none;" @endif>
                                                    <div class="col-md-8">
                                                        <div class="notice">
                                                            <div class="icon"><i class="fas fa-exclamation-circle"></i>
                                                            </div>
                                                            <div class="cont">
                                                                <p>If you use a factoring company, please enter your
                                                                    factoring
                                                                    company's name and address in the Payment
                                                                    Remit To Address fields below.</p>
                                                            </div>
                                                        </div>

                                                        <div class="file-upload-form uploader">
                                                                     @php
                                                                          $file_1 = $onboarding_file;
                                                                       @endphp
                                                            <input class="file-upload" type="file"
                                                               name="factoring_company_files"
                                                               id="factoring_company_files"
                                                               
                                                               accept="image/*" />
                                                            <div class="fileuploadmain file-drag">
                                                                <div class="cont">
                                                                    <p><span class="requiredstar">*</span>(Required) Please
                                                                        upload Notice of Assigment (NOA) document Only pdf
                                                                        docx,
                                                                        doc, tiff, jpg, jpeg png under 10mb allowed</p>
                                                                </div>
                                                                <div class="uploadbtn">
                                                                    <a class="themeBtn file-upload-btn"
                                                                        href="javascript:;" title=""><i
                                                                            class="fas fa-upload"></i> SELECT
                                                                        FILE</a>
                                                                </div>
                                                            </div>
                                                            <div class="file-upload-info" style="margin-top: 10px;">
                                                                <p class="file-name">
                                                                      
                                                                    {{ $file_1->where('file_type','step_1_file')->first()->file_name ?? ''}}</p>
                                                                <img class="file-preview" style="max-width: 100px;"
                                                                    @if ($file_1->where('file_type','step_1_file')->first() != null) src="{{ asset('assets/images/onboarding_files/' . $file_1->where('file_type','step_1_file')->first()->file_name . ' ') }}" @endif />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h3>Payment Remit to Address</h3>
                                                        <div class="items">
                                                            <label><span class="requiredstar">*</span>Factoring Company
                                                                Name:</label>
                                                            <div class="fields">
                                                                <input type="text" name="factory_name"
                                                                    id="factory_name" required
                                                                    value="{{ $onboarding_profile->factory_name ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="items">
                                                            <label><span class="requiredstar">*</span>Street:</label>
                                                            <div class="fields">
                                                                <input type="text" name="street" id="street" class="StreetAddresstField"
                                                                    value="{{ $onboarding_profile->street ?? '' }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="items">
                                                            <label><span class="requiredstar">*</span>City:</label>
                                                            <div class="fields">
                                                                <select name="city" id="company_city" required diabled>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="items">
                                                                    <label><span
                                                                            class="requiredstar">*</span>State/Province:</label>
                                                                    <div class="fields">
                                                                        <select name="state" id="state" required>
                                                                            <option value="" disabled></option>
                                                                             @foreach ($states as $state)
                                                                                <option value="{{ $state->id }}" {{ $state->id == $onboarding_profile->state ? 'selected' : '' }}>
                                                                                    {{ $state->name }}
                                                                                </option>
                                                                            @endforeach
                                                                            @foreach ($states as $state)
                                                                                <option value="{{ $state->id }}">
                                                                                    {{ $state->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="items">
                                                                    <label><span class="requiredstar">*</span>Postal
                                                                        Code:</label>
                                                                    <div class="fields">
                                                                        <input type="text" id="postal_code"
                                                                            name="postal_code" required
                                                                            value="{{ $onboarding_profile->postal_code ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="items">
                                                                    <label><span class="requiredstar">*</span>Phone
                                                                        Number:</label>
                                                                    <div class="fields">
                                                                        <input type="tel" name="phone_num"
                                                                            id="phone_num" required
                                                                            value="{{ $onboarding_profile->phone_num ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="items">
                                                                    <label>Ext:</label>
                                                                    <div class="fields">
                                                                        <input type="text" name="extansion"
                                                                            id="extansion"
                                                                            value="{{ $onboarding_profile->extansion ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btnSubmits">
                                                <button class="themeBtn saveNextBtn" id="company_form_btn"
                                                    type="submit">Save & Next</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Contacts Tab -->
                                <div class="tabsData-view contactsContent ">
                                    <div class="mainHead">
                                        <h4><i class="fas fa-user"></i> Contacts</h4>
                                        <a href="javascript:;" class="themeBtn">Edit</a>
                                    </div>
                                    <div class="showHide">
                                        <p>Please enter at least one contact below.</p>
                                        <form method="post" id="step_from_2">
                                            <input type="hidden" id="token" value="{{ csrf_token() }}">

                                            <div class="listscontacts">
                                                <div class="head">
                                                    <h3>Owner/Officer</h3>
                                                  
                                                </div>
                                                <div class="contactsDet-users bglightgrey" >
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Name:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="officer_name"
                                                                        value="{{ $onboarding_profile->officer_name ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="items">
                                                                        <label>Phone:</label>
                                                                        <div class="fields">
                                                                            <input type="tel" name="officer_phone"
                                                                                value="{{ $onboarding_profile->officer_phone ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="items">
                                                                        <label>Ext:</label>
                                                                        <div class="fields">
                                                                            <input type="text" name="officer_ext"
                                                                                value="{{ $onboarding_profile->officer_ext ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Email:</label>
                                                                <div class="fields">
                                                                    <input type="email" name="officer_email"
                                                                        value="{{ $onboarding_profile->officer_email ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Title:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="officer_title"
                                                                        value="{{ $onboarding_profile->officer_title ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Fax:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="officer_fax"
                                                                        value="{{ $onboarding_profile->officer_fax ?? '' }}">
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
                                                <div class="contactsDet-users bglightgrey" >
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Name:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="accounting_name"
                                                                        value="{{ $onboarding_profile->accounting_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="items">
                                                                        <label>Phone:</label>
                                                                        <div class="fields">
                                                                            <input type="tel" name="accounting_phone"
                                                                                value="{{ $onboarding_profile->accounting_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="items">
                                                                        <label>Ext:</label>
                                                                        <div class="fields">
                                                                            <input type="text" name="accounting_ext"
                                                                                value="{{ $onboarding_profile->accounting_ext }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Email:</label>
                                                                <div class="fields">
                                                                    <input type="email"
                                                                        name="accounting_email"value="{{ $onboarding_profile->accounting_email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Title:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="accounting_title"
                                                                        value="{{ $onboarding_profile->accounting_title }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Fax:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="accounting_fax"
                                                                        value="{{ $onboarding_profile->accounting_fax }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="contactchecks">
                                                                <div class="check">
                                                                    <input type="checkbox" name="accounting_is_primary"
                                                                        id="accounting_is_primary" value="yes"
                                                                        @checked($onboarding_profile->accounting_is_primary == 'yes')>
                                                                    <label for="accounting_is_primary"> Primary</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                                    <input type="text" name="operation_name"
                                                                        value="{{ $onboarding_profile->operation_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="items">
                                                                        <label>Phone:</label>
                                                                        <div class="fields">
                                                                            <input type="tel" name="operation_phone"
                                                                                value="{{ $onboarding_profile->operation_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="items">
                                                                        <label>Ext:</label>
                                                                        <div class="fields">
                                                                            <input type="text"
                                                                                name="operation_ext"value="{{ $onboarding_profile->operation_ext }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Email:</label>
                                                                <div class="fields">
                                                                    <input type="email" name="operation_email"
                                                                        value="{{ $onboarding_profile->operation_email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Title:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="operation_title"
                                                                        value="{{ $onboarding_profile->operation_title }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Fax:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="operation_fax"
                                                                        value="{{ $onboarding_profile->operation_fax }}">
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
                                                                    <input type="text" name="safety_name"
                                                                        value="{{ $onboarding_profile->safety_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="items">
                                                                        <label>Phone:</label>
                                                                        <div class="fields">
                                                                            <input type="tel" name="safety_phone"
                                                                                value="{{ $onboarding_profile->safety_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="items">
                                                                        <label>Ext:</label>
                                                                        <div class="fields">
                                                                            <input type="text"
                                                                                name="safety_ext"value="{{ $onboarding_profile->safety_ext }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Email:</label>
                                                                <div class="fields">
                                                                    <input type="email" name="safety_email"
                                                                        value="{{ $onboarding_profile->safety_email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Title:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="safety_title"
                                                                        value="{{ $onboarding_profile->safety_title }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Fax:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="safety_fax"
                                                                        value="{{ $onboarding_profile->safety_fax }}">
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
                                                                    <input type="text" name="emergency_name"
                                                                        value="{{ $onboarding_profile->emergency_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="items">
                                                                        <label>Phone:</label>
                                                                        <div class="fields">
                                                                            <input type="tel" name="emergency_phone"
                                                                                value="{{ $onboarding_profile->emergency_phone }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="items">
                                                                        <label>Ext:</label>
                                                                        <div class="fields">
                                                                            <input type="text" name="emergency_ext"
                                                                                value="{{ $onboarding_profile->emergency_ext }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Email:</label>
                                                                <div class="fields">
                                                                    <input type="email" name="emergency_email"
                                                                        value="{{ $onboarding_profile->emergency_email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Title:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="emergency_title"
                                                                        value="{{ $onboarding_profile->emergency_title }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="items">
                                                                <label>Fax:</label>
                                                                <div class="fields">
                                                                    <input type="text" name="emergency_title"
                                                                        value="{{ $onboarding_profile->emergency_title }}">
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

                                            <div class="refrencesmain">
                                                <h3>Adding References</h3>
                                                <p>References (optional)</p>
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
                                                                <div
                                                                    class="row active">
                                                                    <div class="col-md-3">
                                                                        <div class="divs fields">
                                                                            <input type="text" name="company"
                                                                                value="{{ $onboarding_refrnces->company ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="divs fields">
                                                                            <input type="text" name="name"
                                                                                value="{{ $onboarding_refrnces->name ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="divs fields">
                                                                            <input type="tel" name="company_phone"
                                                                                value="{{ $onboarding_refrnces->company_phone ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <div class="divs fields">
                                                                            <input type="text" name="company_ext"
                                                                                value="{{ $onboarding_refrnces->company_ext ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                 
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btnSubmits">
                                                <button class="themeBtn saveNextBtn" type="submit"
                                                    id="company_form_btn_2">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Fleet Tab -->
                                <div class="tabsData-view fleetContent">
                                    <div class="mainHead">
                                        <h4><i class="fas fa-truck"></i> Fleet</h4>
                                        <a href="javascript:;" class="themeBtn">Edit</a>
                                    </div>
                                    <div class="showHide"id="div_step_from_3">
                                        <p>Items marked with<span class="requiredstar">*</span> are required
                                            to
                                            complete your profile.</p>
                                        <form method="post" id="step_from_3">
                                            <div class="items">
                                                <h3>Fleet Information</h3>
                                                <div class="fleetList">
                                                    <p><span class="requiredstar">*</span> Number of Power Units.</p>
                                                    <div class="fields">
                                                        <input type="number" name="number_of_power_units"
                                                            value="{{ $onboarding_profile->number_of_power_units ?? '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="fleetList">
                                                    <p><span class="requiredstar">*</span> Number of Owner Operators:
                                                        (using their
                                                        own authority)</p>
                                                    <div class="fields">
                                                        <input type="number" name="number_of_owner_operators"
                                                            value="{{ $onboarding_profile->number_of_owner_operators ?? '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="fleetList">
                                                    <p><span class="requiredstar">*</span> Number of Company Drivers:</p>
                                                    <div class="fields">
                                                        <input type="number" name="number_of_company_drivers"
                                                            value="{{ $onboarding_profile->number_of_company_drivers ?? '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="fleetList">
                                                    <p>Number of Teams:</p>
                                                    <div class="fields">
                                                        <input type="number" name="number_of_teams"
                                                            value="{{ $onboarding_profile->number_of_teams ?? '' }}">
                                                    </div>
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
                                            {{-- <div class="items">
                                                
                                                  <h3>Equipment Information</h3>
                                                  <div class="fleetList">
                                                  <p><span class="requiredstar">*</span> Number of Power Units.</p>
                                                  <div class="fields">
                                                       <input type="number" name="equip_number_of_power_units" value="{{ $onboarding_profile->equip_number_of_power_units ?? '' }}" required>
                                                  </div>
                                                  </div>
                                                  <div class="fleetList">
                                                  <p><span class="requiredstar">*</span> Number of Owner Operators: (using their
                                                       own authority)</p>
                                                  <div class="fields">
                                                       <input type="number" name="equip_number_of_owner_operators" value="{{ $onboarding_profile->equip_number_of_owner_operators ?? '' }}" required>
                                                  </div>
                                                  </div>
                                                  <div class="fleetList">
                                                  <p><span class="requiredstar">*</span> Number of Company Drivers:</p>
                                                  <div class="fields">
                                                       <input type="number" name="equip_number_of_company_drivers" value="{{ $onboarding_profile->equip_number_of_company_drivers ?? '' }}" required>
                                                  </div>
                                                  </div>
                                                  <div class="fleetList">
                                                  <p>Number of Teams:</p>
                                                  <div class="fields">     
                                                       <input type="text" name="equip_number_of_teams" value="{{ $onboarding_profile->equip_number_of_teams ?? '' }}">
                                                  </div>
                                                  </div>
                                                   <div class="fleetList">
                                                  <p>On Board Communications:</p>
                                                       <div class="radioBtns">
                                                            <div class="radios">
                                                                 <input type="radio" id="Cell" name="equip_board_comm" @checked($onboarding_profile->equip_board_comm === 'Cell') value="Cell">
                                                                 <label for="Cell"> Cell</label>
                                                            </div>
                                                            <div class="radios">
                                                                 <input type="radio" id="Satellite" name="equip_board_comm" @checked($onboarding_profile->equip_board_comm === 'Satellite') value="Satellite">
                                                                 <label for="Satellite"> Satellite</label>
                                                            </div>
                                                            <div class="radios">
                                                                 <input type="radio" id="None" name="equip_board_comm" @checked($onboarding_profile->equip_board_comm === 'None') value="None">
                                                                 <label for="None"> None</label>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="items">
                                                  <h3>Certificates Information</h3>
                                                  <div class="fleetList">
                                                  <p>Do you haul dangerous goods?</p>
                                                  <div class="radioBtns">
                                                       <div class="radios">
                                                            <input type="radio" @if ($onboarding_profile->dangerous_goods == 'yes') checked @endif id="Yes" name="dangerous_goods" value="yes">
                                                            <label for="Yes"> Yes</label>
                                                       </div>
                                                       <div class="radios">
                                                            <input type="radio" id="No" @if ($onboarding_profile->dangerous_goods == 'no') checked @endif name="dangerous_goods" value="no">
                                                            <label for="No"> No</label>
                                                       </div>
                                                  </div>
                                                  </div>
                                                  <div class="cflabels">
                                                  <div class="contactchecks">
                                                       <div class="check">
                                                            <input type="checkbox" value="yes" name="have_hazmat_certification" @if ($onboarding_profile->have_hazmat_certification == 'yes') checked @endif id="certified1">
                                                            <label for="certified1"> Hamar Certified</label>
                                                       </div>
                                                       
                                                       <div class="row file-upload-section"@if ($onboarding_profile->have_hazmat_certification == 'yes') style="display: block;" @else style="display: none;" @endif>
                                                            <div class="col-md-8">
                                                                 <div class="file-upload-form uploader">
                                                                      <input class="file-upload" type="file" name="hammar_certificate_file" id="hammar_certificate_file" name="fileUpload"
                                                                      accept="image/*" />
                                                                      <div class="fileuploadmain file-drag">
                                                                      <div class="cont">
                                                                           <p><span class="requiredstar">*</span>(Required) Please
                                                                                upload Notice of Assigment (NOA) document Only pdf
                                                                                docx, doc, tiff, jpg, jpeg png under 10mb allowed
                                                                           </p>
                                                                      </div>
                                                                      <div class="uploadbtn">
                                                                           <a class="themeBtn file-upload-btn"
                                                                                href="javascript:;" title=""><i
                                                                                     class="fas fa-upload"></i> SELECT FILE</a>
                                                                      </div>
                                                                      </div>
                                                                      <div class="file-upload-info" style="margin-top: 10px;">
                                                                      <p class="file-name">{{ $onboarding_file->file_name }}</p>
                                                                      <img class="file-preview" src="{{ asset('assets/images/onboarding_files/'.$onboarding_file->file_name.'') }}"
                                                                           style="max-width: 100px; display: block;" />
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="contactchecks">
                                                       <div class="check">
                                                            <input type="checkbox" id="certified2" name="certified_radio_active" @checked($onboarding_file->certified_radio_active == 'certified_radio_active') value="certified_radio_active">
                                                            <label for="certified2"> Certified Radioactive Freight</label>
                                                       </div>
                                                  </div>
                                                  </div>
                                             </div> --}}
                                            <div class="btnSubmits">
                                                <button class="themeBtn saveNextBtn" id="company_form_btn_3">Save
                                                    changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Lanes Tab -->
                                <div class="tabsData-view laneContent">
                                    <div class="mainHead">
                                        <h4><i class="fas fa-tachometer-slowest"></i> Lanes</h4>
                                        <a href="javascript:;" class="themeBtn">Edit</a>
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
                                                                        <input type="text" name="origin[]" required
                                                                            value="{{isset($onboard_lanes[0]) ? $onboard_lanes[0]->origin : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="divs fields">
                                                                        <input type="text" name="destination[]"
                                                                            required
                                                                            value="{{ isset($onboard_lanes[0]) ?  $onboard_lanes[0]->destination : '' }}">
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
                                                                        {{-- <a class="themeBtn savedet" href="javascript:;"
                                                                           title="">Save</a> --}}
                                                                        <a class="themeBtn" id="addedbtns"
                                                                            href="javascript:;" title=""><i
                                                                                class="far fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($onboard_lanes->count() > 0)
                                                        @foreach ($onboard_lanes as $key => $onboard_lane)
                                                            @php
                                                                $random_id = substr(
                                                                    bin2hex(random_bytes(ceil(7 / 2))),
                                                                    0,
                                                                    7,
                                                                );
                                                            @endphp
                                                            @if ($key == 0)
                                                                @continue
                                                            @endif
                                                            <div class="items">
                                                                <div class="steps firststep">
                                                                    <div class="row active" id="id_{{ $random_id }}">
                                                                        <div class="col-md-3">
                                                                            <div class="divs fields">
                                                                                <input type="text" required
                                                                                            name="origin[]"
                                                                                            value="{{ $onboard_lane->origin }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="divs fields">
                                                                                 <input type="text" required
                                                                                            name="destination[]"
                                                                                            value="{{ $onboard_lane->destination }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="divs fields">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="divs btnmain">
                                                                                <a class="themeBtn savedet" href="javascript:;"
                                                                                    title=""
                                                                                    onclick="remove_prefered_areas('{{ $random_id }}')">Remove</a>
                                                                            </div>
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
                                                  value="{{ $onboarding_profile->id ?? '' }}">
                                                  <div class="btnSubmits">
                                                  <button class="themeBtn saveNextBtn" id="company_form_btn_4">Save
                                                       changes</button>
                                                  </div>
                                             </form>
                                        </div>
                                    </div>
                                </div>


                            <!-- Documents Tab -->
                            <div class="tabsData-view docsContent">
                                <div class="mainHead">
                                    <h4><i class="far fa-file-alt"></i> Documents</h4>
                                    <a href="javascript:;" class="themeBtn">Edit</a>
                                </div>
                                <div class="showHide">
                                    <form method="post" id="step_from_6" enctype="multipart/form-data">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-md-6">
                                                <p class="mb-0">Add any documents you want to include as part of your
                                                    profile, such as an authority, insurance or Hazmat certificate or
                                                    schedule of vehicles.</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="file-upload-form uploader">
                                                    <input class="file-upload" type="file" name="doc_file"
                                                        id="doc_file" accept="image/*" />
                                                    <div class="fileuploadmain file-drag">
                                                        <div class="cont">
                                                            <p><span class="requiredstar">*</span>Required</p>
                                                            <p class="d-flex gap-1 align-items-center"><i
                                                                    class="fas fa-upload"></i> Drag and drop your document
                                                                OR here to upload</p>
                                                        </div>
                                                        <div class="uploadbtn">
                                                            <a class="themeBtn file-upload-btn" href="javascript:;"
                                                                title=""><i class="fas fa-upload"></i> SELECT
                                                                FILE</a>
                                                        </div>
                                                    </div>
                                                    <div class="file-upload-info" style="margin-top: 10px;"
                                                        style="display:none">
                                                        <p class="file-name"></p>
                                                        <img class="file-preview"
                                                            style="max-width: 100px; display: none;" />
                                                    </div>
                                                </div>
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
                                                                    <input type="text" name="doc_name" value="{{ $onboarding_profile->doc_name}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="divs fields">
                                                                    <select name="doc_type" id="" required>
                                                                        <option value="Hazmat cert" {{$onboarding_profile->doc_type == "Hazmat cert" ? 'selected' : ''}}> Hazmat cert</option>
                                                                        <option value="W9" {{$onboarding_profile->doc_type == "W9" ? 'selected' : ''}} >W9</option>
                                                                        <option value="Hazmat Permit"  {{$onboarding_profile->doc_type == "Hazmat Permit" ? 'selected' : ''}}  >Hazmat Permit
                                                                        </option>
                                                                        <option value="MC" {{$onboarding_profile->doc_type == "MC" ? 'selected' : ''}}  >MC</option>
                                                                        <option value="Misc Permits" {{$onboarding_profile->doc_type == "Misc Permits" ? 'selected' : ''}} >Misc Permits</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="divs fields">
                                                                    <input type="text" name="doc_description" required value="{{ $onboarding_profile->doc_description ?? '' }}"
                                                                        placeholder="Description">
                                                                </div>
                                                            </div>
                                                            @php
                                                                 $file_6 = App\Models\OnboardProfileFiles::where('form_id', $onboarding_profile->id)->where('file_type','step_6_file')->first();
                                                              @endphp
                                                            <div class="col-md-2">
                                                                <div class="divs fields filenameput">
                                                                 @if($file_6 != null)  
                                                                      <a href="{{ asset('assets/images/onboarding_files/' . $file_6->file_name ?? '' . '') }}" target="_blank">{{ $file_6->file_name ?? '' }}</a>
                                                                 @endif
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnSubmits">
                                            <button class="themeBtn saveNextBtn" id="company_form_btn_6">Save
                                                changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Insurance Tab -->
                            <div class="tabsData-view insuranceContent ">
                                <div class="mainHead">
                                    <h4><i class="fas fa-shield"></i> Insurance </h4>
                                    <a href="javascript:;" class="themeBtn">Edit</a>
                                </div>
                                <div class="showHide">
                                    <p>Insurance is a requirement to haul loads for brokers and
                                        shippers, so
                                        PTTR will need a valid insurance certificate on file <strong>(Optional)</strong>.
                                        This can be done two different ways:</p>
                                    <br>
                                    <p>1. Upload the certificate yourself</p>
                                        
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
                                                                        <input type="text" name="insurance_agent"
                                                                            value="{{ $onboarding_profile->insurance_agent }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <div class="items">
                                                                            <label>Phone:</label>
                                                                            <div class="fields">
                                                                                <input type="tel"
                                                                                    name="insurance_phone"
                                                                                    value="{{ $onboarding_profile->insurance_phone }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="items">
                                                                            <label>Ext:</label>
                                                                            <div class="fields">
                                                                                <input type="text"
                                                                                    name="insurance_ext"
                                                                                    value="{{ $onboarding_profile->insurance_ext }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="file-upload-form uploader">
                                                                    <input class="file-upload" type="file"
                                                                        name="insurance_certificate" accept="image/*" />
                                                                    <div class="fileuploadmain file-drag">
                                                                        <div class="uploadbtn">
                                                                            <a class="themeBtn file-upload-btn"
                                                                                href="javascript:;" title=""><i
                                                                                    class="fas fa-upload"></i> UPLOAD
                                                                                CERTIFICATE</a>
                                                                        </div>
                                                                    </div>
                                                                      @php
                                                                           $file_7 = App\Models\OnboardProfileFiles::where('form_id', $onboarding_profile->id)->where('file_type','step_7_file')->first(); 
                                                                      @endphp
                                                                    <div class="file-upload-info"
                                                                        style="margin-top: 10px;">
                                                                        <p class="file-name">
                                                                            {{ $file_7->file_name ?? "" }}</p>
                                                                        <img class="file-preview"
                                                                            @if($file_7 != null) src="{{ asset('assets/images/onboarding_files/' . $file_7->file_name . '') }}" @endif
                                                                            style="max-width: 100px;" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="items">
                                                                    <label>Email:</label>
                                                                    <div class="fields">
                                                                        <input type="email" name="insurance_email"
                                                                            value="{{ $onboarding_profile->insurance_email }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="items">
                                                                    <label>Fax:</label>
                                                                    <div class="fields">
                                                                        <input type="text" name="insurance_fax"
                                                                            value="{{ $onboarding_profile->insurance_fax }}">
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
                                        <div class="btnSubmits">
                                            <button class="themeBtn savedet" id="company_form_btn_7">Save
                                                changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Contracts Tab -->
                            {{-- <div class="tabsData-view contractsContent">
                                <div class="mainHead">
                                    <h4><i class="fas fa-pencil"></i> Contracts</h4>
                                    <a href="javascript:;" class="themeBtn">Edit</a>
                                </div>
                                <div class="showHide">
                                    <div class="boxcontractrs">
                                        <h3>Ready to Sign</h3>
                                        <ul>
                                            <li>
                                                <div class="listcompletesign">
                                                    <div class="icons">
                                                        <i class="far fa-check"></i>
                                                    </div>
                                                    <div class="cont">
                                                        <p>Create Account</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="listcompletesign">
                                                    <div class="icons">
                                                        <i class="far fa-check"></i>
                                                    </div>
                                                    <div class="cont">
                                                        <p>Start Profile</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="listcompletesign">
                                                    <div class="icons nextlogo">
                                                        Next <span>3</span>
                                                    </div>
                                                    <div class="cont">
                                                        <p>Sign Contracts</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <p>Your profile is complete and you may now sign contracts. The
                                            information you entered is saved for
                                            future visits to PTTR Onboard.</p>
                                        <div class="contaractsBtn">
                                            <a href="javascript:;" title="">I understand</a>
                                            <a class="themeBtn" href="javascript:;" title=""><i
                                                    class="far fa-file-alt"></i> SIGN CONTRACTS</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('layouts.form_proccess_js')
@endsection
@push('js')
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
            
            $('.file-upload').change(function(e) {
                var file = e.target.files[0];
                var allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/tiff', 'image/jpeg', 'image/png'
                ];
                var maxFileSize = 10 * 1024 * 1024;

                var $uploadForm = $(this).closest('.file-upload-form');
                var $fileName = $uploadForm.find('.file-name');
                var $filePreview = $uploadForm.find('.file-preview');

                if (file) {
                    var fileType = file.type;
                    var fileSize = file.size;

                    // Check file type
                    if ($.inArray(fileType, allowedTypes) === -1) {
                        alert(
                            'Invalid file type. Only PDF, DOC, DOCX, TIFF, JPG, JPEG, and PNG are allowed.'
                        );
                        $(this).val('');
                        $fileName.text('');
                        $filePreview.hide();
                        return false;
                    }

                    // Check file size
                    if (fileSize > maxFileSize) {
                        alert('File size exceeds 10MB. Please upload a smaller file.');
                        $(this).val('');
                        $fileName.text('');
                        $filePreview.hide();
                        return false;
                    }
                    $fileName.text('Selected File: ' + file.name);

                    if (fileType.startsWith('image/')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $filePreview.attr('src', e.target.result).show();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $filePreview.hide();
                    }
                }
            });

            $('.file-upload-btn').click(function() {
                $(this).closest('.file-upload-form').find('.file-upload').click();
            });
        });


        $('.saveNextBtn').click(function(e) {
            e.preventDefault();

            var currentTab = $('.carriersTabs ul li.active');
            var nextTab = currentTab.next('li');

            if (nextTab.length) {

                currentTab.removeClass('active');

                nextTab.addClass('active');

                $('.tabsData.active').removeClass('active').hide();
                $('.tabsData').eq(nextTab.index()).addClass('active').show();
            }
        });

        $('.btnadd a').click(function() {
            $(this).hide();
            $(this).closest('.listscontacts').find('.contactsDet-users').slideToggle();
        });
        $('.contactsDet-users .closeBtns').click(function() {
            $(this).closest('.listscontacts').find('.btnadd a').show();
            $(this).closest('.contactsDet-users').slideUp();
        });


        $('.savedet').click(function() {
            $(this).closest('.contactsDet-users.bglightgrey').slideUp().siblings('.contactsDet-users-show')
                .slideDown();
        });

        $('.contactsDet-users .closeBtns').click(function() {
            $(this).closest('.contactsDet-users.bglightgrey').slideUp();
        });

        $('.editBtns').click(function() {
            $(this).closest('.contactsDet-users-show').slideUp().siblings('.contactsDet-users.bglightgrey')
                .slideDown();
        });

        $('.deleteBtns').click(function() {
            $(".btnadd a").show();
            $(this).closest('.contactsDet-users-show').slideUp();
        });

        //    $(".refrencestable .tablesbody .items .addedbtns").click(function () {
        //      $(this).closest('.row').addClass('active'); 
        //      $(this).addClass('closebtns'); 
        //    });

        //    $(".items .addedbtns.closebtns").click(function () {
        //         $(this).closest('.row').removeClass('active'); 
        //    });




        $(document).ready(function() {

            $('.tablesbody').on('click', '.addedbtns', function() {
                var parentRow = $(this).closest('.row');
                parentRow.addClass('active');
                $(this).addClass('closebtns').removeClass('addedbtns');
            });

            $('.tablesbody').on('click', '.closebtns', function() {
                var $parentRow = $(this).closest('.row');
                $parentRow.removeClass('active');
                $(this).removeClass('closebtns').addClass('addedbtns');
                $parentRow.next('.detailsedits').slideUp();
            });

            $('.tablesbody').on('click', '.savedet', function() {
                var $parentStep = $(this).closest('.steps.firststep');
                var $detailsRow = $parentStep.next('.detailsedits');
                $parentStep.find('.closebtns').removeClass('closebtns').addClass('addedbtns');
                $parentStep.hide();
                $detailsRow.slideDown();
            });

            $('.tablesbody').on('click', '.editBtns', function() {
                var $detailsRow = $(this).closest('.steps.detailsedits');
                var $firstStep = $detailsRow.prev('.steps.firststep');
                $firstStep.find('.addedbtns').removeClass('addedbtns').addClass('closebtns');
                $firstStep.find('.row').addClass('active');
                $firstStep.slideDown();

                // Hide the details row
                $detailsRow.slideUp();
            });

            // Handle delete button functionality
            $('.tablesbody').on('click', '.deleteBtns', function() {
                var $detailsRow = $(this).closest('.steps.detailsedits');
                var $firstStep = $detailsRow.prev('.steps.firststep');

                // Reset the first step and show it
                $firstStep.find('.row').removeClass('active');
                $detailsRow.slideUp();
                $firstStep.slideDown();
            });


            $('#certified1').change(function() {
                var $contactchecks = $(this).closest('.contactchecks');
                if ($(this).is(':checked')) {
                    $contactchecks.find('.file-upload-section').slideDown();
                } else {
                    $contactchecks.find('.file-upload-section').slideUp();
                }
            });

        });


        $('.accordion-list > li > .answer').hide();
        $('.accordion-list > li.active .answer').show();

        $('.accordion-list > li .accordhead').click(function(e) {
            if ($(e.target).closest('.radioBtns').length === 0 && $(e.target).closest('.check').length === 0) {
                if ($(this).parent().hasClass("active")) {
                    $(this).parent().removeClass("active").find(".answer").slideUp();
                } else {
                    $(".accordion-list > li.active .answer").slideUp();
                    $(".accordion-list > li.active").removeClass("active");
                    $(this).parent().addClass("active").find(".answer").slideDown();
                }
            }
            return false;
        });

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
        
        //CANADA AND MEXICO
        
        $('#AllZones').on('click', function() {
            var isChecked = this.checked;
            $('#canada_areas input[type="checkbox"]').prop('checked', isChecked);
        });
    
        $('#canada_areas input[type="checkbox"]').not('#AllZones').on('click', function() {
            if ($('#canada_areas input[type="checkbox"]').not('#AllZones').length === $('#canada_areas input[type="checkbox"]:checked').not('#AllZones').length) {
                $('#AllZones').prop('checked', true);
            } else {
                $('#AllZones').prop('checked', false);
            }
        });
        
        $('#Zonecm0').on('click', function() {
            let chk_status = this.checked;
            $('.zonCm0 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZonesCheckbox(); 
        });
    
        $('.zonCm0 input[type="checkbox"]').not('#Zonecm0').on('click', function() {
            if ($('.zonCm0 input[type="checkbox"]').not('#Zonecm0').length === $('.zonCm0 input[type="checkbox"]:checked').not('#Zonecm0').length) {
                $('#Zonecm0').prop('checked', true);
            } else {
                $('#Zonecm0').prop('checked', false);
            }
            updateAllZonesCheckbox(); 
        });
       
       
        $('#Zonecm1').on('click', function() {
            let chk_status = this.checked;
            $('.zonCm1 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZonesCheckbox(); 
        });
    
        $('.zonCm1 input[type="checkbox"]').not('#Zonecm1').on('click', function() {
            if ($('.zonCm1 input[type="checkbox"]').not('#Zonecm1').length === $('.zonCm1 input[type="checkbox"]:checked').not('#Zonecm1').length) {
                $('#Zonecm1').prop('checked', true);
            } else {
                $('#Zonecm1').prop('checked', false);
            }
            updateAllZonesCheckbox(); 
        });
        
                
        $('#Zonecm2').on('click', function() {
            let chk_status = this.checked;
            $('.zonCm2 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZonesCheckbox(); 
        });
        
        $('.zonCm2 input[type="checkbox"]').not('#Zonecm2').on('click', function() {
            if ($('.zonCm2 input[type="checkbox"]').not('#Zonecm2').length === $('.zonCm2 input[type="checkbox"]:checked').not('#Zonecm2').length) {
                $('#Zonecm2').prop('checked', true);
            } else {
                $('#Zonecm2').prop('checked', false);
            }
            updateAllZonesCheckbox(); 
        });
       
         
        
        $('#Zonecm3').on('click', function() {
            let chk_status = this.checked;
            $('.zonCm3 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZonesCheckbox(); 
        });
        
        $('.zonCm3 input[type="checkbox"]').not('#Zonecm3').on('click', function() {
            if ($('.zonCm3 input[type="checkbox"]').not('#Zonecm3').length === $('.zonCm3 input[type="checkbox"]:checked').not('#Zonecm3').length) {
                $('#Zonecm3').prop('checked', true);
            } else {
                $('#Zonecm3').prop('checked', false);
            }
            updateAllZonesCheckbox(); 
        });
        
        $('#Zonecm4').on('click', function() {
            let chk_status = this.checked;
            $('.zonCm4 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZonesCheckbox(); 
        });
        
        $('.zonCm4 input[type="checkbox"]').not('#Zonecm4').on('click', function() {
            if ($('.zonCm4 input[type="checkbox"]').not('#Zonecm4').length === $('.zonCm4 input[type="checkbox"]:checked').not('#Zonecm4').length) {
                $('#Zonecm4').prop('checked', true);
            } else {
                $('#Zonecm4').prop('checked', false);
            }
            updateAllZonesCheckbox(); 
        });
        
        //CANADA AND MEXICO End
        // UNITED STATE Start
         
        $('#AllZones1').on('click', function() {
            var isChecked = this.checked;
            $('#unitedstates_areas input[type="checkbox"]').prop('checked', isChecked);
        });
    
        $('#unitedstates_areas input[type="checkbox"]').not('#AllZones1').on('click', function() {
            if ($('#unitedstates_areas input[type="checkbox"]').not('#AllZones1').length === $('#unitedstates_areas input[type="checkbox"]:checked').not('#AllZones1').length) {
                $('#AllZones1').prop('checked', true);
            } else {
                $('#AllZones1').prop('checked', false);
            }
        });
        
        $('#Zoneus0').on('click', function() {
            let chk_status = this.checked;
            $('.zonUs0 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZones1(); 
        });
    
        $('.zonUs0 input[type="checkbox"]').not('#Zoneus0').on('click', function() {
            if ($('.zonUs0 input[type="checkbox"]').not('#Zoneus0').length === $('.zonUs0 input[type="checkbox"]:checked').not('#Zoneus0').length) {
                $('#Zoneus0').prop('checked', true);
            } else {
                $('#Zoneus0').prop('checked', false);
            }
            updateAllZones1(); 
        });
        
        $('#Zoneus1').on('click', function() {
            let chk_status = this.checked;
            $('.zonUs1 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZones1(); 
        });
    
        $('.zonUs1 input[type="checkbox"]').not('#Zoneus1').on('click', function() {
            if ($('.zonUs1 input[type="checkbox"]').not('#Zoneus1').length === $('.zonUs1 input[type="checkbox"]:checked').not('#Zoneus1').length) {
                $('#Zoneus1').prop('checked', true);
            } else {
                $('#Zoneus1').prop('checked', false);
            }
            updateAllZones1(); 
        });
        
                
        $('#Zoneus2').on('click', function() {
            let chk_status = this.checked;
            $('.zonUs2 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZones1(); 
        });
        
        $('.zonUs2 input[type="checkbox"]').not('#Zoneus2').on('click', function() {
            if ($('.zonUs2 input[type="checkbox"]').not('#Zoneus2').length === $('.zonUs2 input[type="checkbox"]:checked').not('#Zoneus2').length) {
                $('#Zoneus2').prop('checked', true);
            } else {
                $('#Zoneus2').prop('checked', false);
            }
            updateAllZones1(); 
        });
        
        
       $('#Zoneus3').on('click', function() {
            let chk_status = this.checked;
            $('.zonUs3 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZones1(); 
        });
        
        $('.zonUs3 input[type="checkbox"]').not('#Zoneus3').on('click', function() {
            if ($('.zonUs3 input[type="checkbox"]').not('#Zoneus3').length === $('.zonUs3 input[type="checkbox"]:checked').not('#Zoneus3').length) {
                $('#Zoneus3').prop('checked', true);
            } else {
                $('#Zoneus3').prop('checked', false);
            }
            updateAllZones1(); 
        });
        
        $('#Zoneus4').on('click', function() {
            let chk_status = this.checked;
            $('.zonUs4 input[type="checkbox"]').prop('checked', chk_status);
            updateAllZones1(); 
        });
        
        $('.zonUs4 input[type="checkbox"]').not('#Zoneus4').on('click', function() {
            if ($('.zonUs4 input[type="checkbox"]').not('#Zoneus4').length === $('.zonUs4 input[type="checkbox"]:checked').not('#Zoneus4').length) {
                $('#Zoneus4').prop('checked', true);
            } else {
                $('#Zoneus4').prop('checked', false);
            }
            updateAllZones1(); 
        });

         // UNITED STATE END

        $('.docsContent .file-upload').on('change', function() {
            var fileName = $(this).prop('files')[0].name;
            $(this).closest('.docsContent').find('.filenameput').html(fileName);
            $(this).closest('.docsContent').find('.tablesbody .steps .row').addClass('active');
        });



        $('.insuranceContent .file-upload').on('change', function() {
            var fileInput = $(this).prop('files')[0];
            var fileName = fileInput.name;
            var fileType = fileInput.type;
            var fileURL = URL.createObjectURL(fileInput);

            $(this).closest('.insuranceContent').find('.filenameput').append('<p>' + fileName + '</p>');

            var filePreview = '';

            var filePreview = '';

            // Check the file type
            if (fileType.startsWith('image/')) {
                // If it's an image, show the image preview inside an anchor tag
                filePreview = '<a href="' + fileURL + '" target="_blank" download><img src="' + fileURL +
                    '" alt="' + fileName + '" style="max-width:100px; display:block;" /></a>';
            } else {
                // For non-image files, show an icon wrapped in an anchor tag
                var fileIcon = '';
                if (fileType === 'application/pdf') {
                    fileIcon = '<i class="fas fa-file-pdf" style="font-size:50px;"></i>';
                } else if (fileType === 'application/msword' || fileType ===
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    fileIcon = '<i class="fas fa-file-word" style="font-size:50px;"></i>';
                } else if (fileType === 'application/vnd.ms-excel' || fileType ===
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    fileIcon = '<i class="fas fa-file-excel" style="font-size:50px;"></i>';
                } else {
                    // For other files (you can add more file type icons here)
                    fileIcon = '<i class="fas fa-file-alt" style="font-size:50px;"></i>';
                }

                filePreview = '<a href="' + fileURL + '" target="_blank" download>' + fileIcon + '</a>';
            }

            // Append the file preview (image or icon wrapped in anchor) to filenameput
            $(this).closest('.insuranceContent').find('.filenameput').append(filePreview);
        }); 
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
        
        //Toaster
        $(document).ready(function() {
            if (localStorage.getItem("companyUpdateSuccess") === "true") {
                toastr.success("Company Updated Successfully...");
                localStorage.removeItem("companyUpdateSuccess");
            }
            else if (localStorage.getItem("contactUpdateSuccess") === "true") {
                toastr.success("Contact Updated Successfully...");
                localStorage.removeItem("contactUpdateSuccess");
            }
            else if (localStorage.getItem("fleetUpdateSuccess") === "true") {
                toastr.success("Fleet Inforamation Updated Successfully...");
                localStorage.removeItem("fleetUpdateSuccess");
            }
            else if (localStorage.getItem("lanesUpdateSuccess") === "true") {
                toastr.success("Lanes Inforamation Updated Successfully...");
                localStorage.removeItem("lanesUpdateSuccess");
            }
            else if (localStorage.getItem("documentUpdateSuccess") === "true") {
                toastr.success("Document Inforamation Updated Successfully...");
                localStorage.removeItem("documentUpdateSuccess");
            }
            else if (localStorage.getItem("insuranceUpdateSuccess") === "true") {
                toastr.success("Insurance Inforamation Updated Successfully...");
                localStorage.removeItem("insuranceUpdateSuccess");
            }
        });
        
        $('#company_form_btn').click(function(e) {
            
             e.preventDefault();
            var isValid = false;
            $('#step_from_1').find('input[required], select[required]').each(function() {
                if ($(this).val() === '' || $(this).val() == null) {
                console.log($(this));
                    isValid = false;
                    $(this).addClass('is-invalid'); // Optional: Add a class for styling invalid fields
                    $('#error_alert').css("display", "block");
                    return false;
                } else {
                    $(this).removeClass('is-invalid');
                    $('#error_alert').css("display", "none");
                }

            });
            
            console.log((isValid));
            
            if ($("#yes01").is(':checked') === true) {
               @if($file_1->where('file_type','step_1_file')->first() == null)
                    if (document.getElementById('factoring_company_files').value == '' || document.getElementById('factoring_company_files').value == null) {
                         isValid = false;
                         $('.fileuploadmain').addClass('is-invalid');
                        return false;
                    }else{
                          $('.fileuploadmain').removeClass('is-invalid');
                    }
                
               @endif
            }
            isValid = true;
            if (isValid) {
                $('#company_form_btn').attr('disabled', 'true');
                // $('#step_from_1').submit(function(e) {
                // e.preventDefault();

                var form = new FormData(document.getElementById('step_from_1'));

                var company_type = $('#company_type').val();
                var year_founded = $('#year_founded').val();
                var scac = $('#scac').val();
                var token = $('#token').val();
                form.append('_token', token);
                $.ajax({
                    url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_1") }}',
                    type: 'post',
                    data: form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        $(document).ajaxStop(function() {
                            localStorage.setItem("companyUpdateSuccess", "true");
                            window.location.reload();
                        });
                    }
                });
                // });

            } else {
                $('#error_alert').css("display", "block"); 
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error(" <strong>Whoops!</strong> There was some problem with your input.<br><br> <ul> <li>*Please ensure all required fields are filled out correctly.</li></ul>");
                // alert("Please fill all required fields before proceeding.");
            }
        });


        $('#company_form_btn_2').click(function(e) {

            e.preventDefault();   
            var isAnyFieldFilled = false;
            // Loop through each of the 5 sections and check if at least one input field has a value
            // $('#step_from_2').each(function() {

            $('#step_from_2').find('input[type="text"],input[type="tel"],input[type="email"]').each(function() {
                if ($(this).val() === '' || $(this).val() == null) {
                   $(this).addClass('is-invalid');
                   isAnyFieldFilled = false;
                } else {
                      $(this).removeClass('is-invalid');
                     isAnyFieldFilled = true;
                     return false;
                }
            });
        
            if (isAnyFieldFilled) {
            $('#company_form_btn_2').attr('disabled', 'true');
                $('#error_alert').css("display", "none");
                // Continue with your next step or form submission

                //  $('#step_from_2').submit(function(e) {

                var form = new FormData(document.getElementById('step_from_2'));

                var token = $('#token').val();
                form.append('_token', token);
                // var x = document.getElementById("myAudio");
                $.ajax({
                    url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_2") }}',
                    type: 'post',
                    data: form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        
                        $(document).ajaxStop(function() {
                            localStorage.setItem("contactUpdateSuccess", "true");
                            window.location.reload();
                        });
                    }
                });
                //   });

            } else {
                $('#company_form_btn_2').removeAttr('disabled', 'true');
                $('#error_alert').css("display", "block");
                $('#error_alert').html("At least 1 section should be filled.");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("Atleast 1 section should be filled...");
                return false; // Prevent form submission or next step
                // return go_to_next_step(true);
                // Add your code to go to the next tab or submit form
            }
        });

        $('#company_form_btn_3').click(function(e) {
            e.preventDefault();
            var isValid = false;
            $('#div_step_from_3').find('input[required]').each(function() {

                if ($(this).val() === '' || $(this).val() == null) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $('#error_alert').css("display", "block");
                } else {
                    $(this).removeClass('is-invalid');
                    isValid = true;
                    $('#error_alert').css("display", "none");
                }
            });
            // Proceed to the next tab only if all fields are valid
            if (isValid) {
                //      $('#step_from_3').submit(function(e) {
                //  e.preventDefault();
                var form = new FormData(document.getElementById('step_from_3'));

                var token = $('#token').val();
                form.append('_token', token);
                // var x = document.getElementById("myAudio");
                $.ajax({
                    url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_3") }}',
                    type: 'post',
                    data: form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        
                          $(document).ajaxStop(function() {
                            localStorage.setItem("fleetUpdateSuccess", "true");
                            window.location.reload();
                        });
                        
                    }
                });
                //   });
            } else {
                $('#company_form_btn_3').removeAttr('disabled', 'true');
                $('#error_alert').css("display", "block");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("Fill all the required fields...");
                return false;

                // alert("Please fill all required fields before proceeding.");
            }
        });

        $('#company_form_btn_4').click(function(e) {
            e.preventDefault();
            // $('#company_form_btn_4').attr('disabled','true');
            // Validate all fields in the current tab
            var isValid = false
             // Check for non-empty text fields if no checkboxes are checked
               
                 $('#step_from_4').find('input[type="text"], input[type="checkbox"]').each(function() {
                    if ($(this).is('input[type="text"]') && $(this).val().trim() === '' || $(this).is('input[type="text"]') && $(this).val().trim() === null ) {
                          $(this).addClass('is-invalid');
                    } else if ($(this).is('input[type="checkbox"]') && !$(this).is(':checked')) {
                       $(this).addClass('is-invalid');
                     
                    } else {
                      $(this).removeClass('is-invalid');
                        isValid = true;
                        return false;// Valid text input found
                    }
                });
                
                
                $('#append_areas').find('input[type="text"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        $(this).removeClass('is-invalid');
                        isValid = true; // Valid input found
                    } else {
                        $(this).addClass('is-invalid'); // Mark as invalid if empty
                    }
                })
                
                
                if (isValid) {
                    // Proceed with form submission or next steps
                    console.log("Form is valid.");
                     $('#error_alert').css("display", "none");
                        e.preventDefault();
                        var form = new FormData(document.getElementById('step_from_4'));
                        var token = $('#token').val();
                        form.append('_token', token);
                        $.ajax({
                            url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_4") }}',
                            type: 'post',
                            data: form,
                            cache: false,
                            contentType: false, //must, tell jQuery not to process the data
                            processData: false,
                            success: function(response) {
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true
                                }
                                
                                  $(document).ajaxStop(function() {
                                    localStorage.setItem("lanesUpdateSuccess", "true");
                                    window.location.reload();
                                });
                            }
                        });
                     
                } else {
                    $('#error_alert').css("display", "block");
                    $('#error_alert').html("Atleast 1 Section should be filled.");
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error("At least one section should be filled...");
                    return false;
                }
                

               
            //  $('#append_areas').find('input[type="text"]').each(function() {
                
            //     if ($(this).val().trim() !== '') {
            //          $(this).removeClass('is-invalid');
            //         isValid = true;
            //         return false;
            //     } else {
            //         $(this).addClass('is-invalid');
            //         isValid = false;
            //     }
            // });
                
                
                
            // var isValid = false
            //   $('#step_from_4').find('input[type="checkbox"]').each(function() {
            //         if ($(this).is(':checked')) {
            //              $(this).removeClass('is-invalid');
            //              isValid = true;
            //             //  return false; // Stop once a checked checkbox is found
            //         }else{
            //               $(this).addClass('is-invalid');
            //         }
            //   });

              
            // if(!isValid){
            //         toastr.options = {
            //              "closeButton": true,
            //              "progressBar": true
            //         }
            //         toastr.error("At least one section should be filledsd...");
            //         return false;
            //   }
          
                
            // Proceed to the next tab only if all fields are valid
            // if (isValid) {
            //     // $('#step_from_4').submit(function(e) {
            //     e.preventDefault();
            //     var form = new FormData(document.getElementById('step_from_4'));
            //      var token = $('#token').val();
            //     form.append('_token', token);
            //     // var x = document.getElementById("myAudio");
            //     $.ajax({
            //         url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_4") }}',
            //         type: 'post',
            //         data: form,
            //         cache: false,
            //         contentType: false, //must, tell jQuery not to process the data
            //         processData: false,
            //         success: function(response) {
            //             toastr.options = {
            //                 "closeButton": true,
            //                 "progressBar": true
            //             }
                        
            //               $(document).ajaxStop(function() {
            //                 localStorage.setItem("lanesUpdateSuccess", "true");
            //                 window.location.reload();
            //             });
                        


            //         }
            //     });
            //     return false;
            //     //   });
            // } else {
            //     $('#company_form_btn_4').removeAttr('disabled', 'true');
            //     $('#error_alert').css("display", "block");
            //     $('#error_alert').html("Atleast 1 Section should be filled.");
            //     toastr.options = {
            //         "closeButton": true,
            //         "progressBar": true
            //     }
            //     toastr.error("At least one section should be filled...");
            //     return false;
            //     // alert("Please fill all required fields before proceeding.");
            // }
        });
 
        $('#company_form_btn_6').click(function(e) {
            e.preventDefault();
            var isValid = false;
            $('#step_from_6').find('input[required]').each(function() {
              
                if ($(this).val() === '' || $(this).val() == null) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $('#error_alert').css("display", "block");
                     return false;
                } 
                @if ($file_6 == null)
                if (document.getElementById('doc_file').value == '' || document.getElementById(
                         'doc_file').value == null) {
                         isValid = false;
                         $('.fileuploadmain').addClass('is-invalid');
                         return false;
                     }else{
                         $('.fileuploadmain').removeClass('is-invalid');
                    }
                @endif
                console.log(isValid);

            });
            
            isValid = true;
            // Proceed to the next tab only if all fields are valid
            if (isValid) {
                // $('#step_from_6').submit(function(e) {

                var form = new FormData(document.getElementById('step_from_6'));

                var token = $('#token').val();
                form.append('_token', token);
                // var x = .gdocumentetElementById("myAudio");
                $.ajax({
                    url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_6") }}',
                    type: 'post',
                    data: form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                         $(document).ajaxStop(function() {
                            localStorage.setItem("documentUpdateSuccess", "true");
                            window.location.reload();
                        });
                    }
                });
                return false;
                // });
            } else {
                $('#company_form_btn_6').removeAttr('disabled', 'true');
                $('#error_alert').css("display", "block");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("Provide valid document and document details...");
                return false;
                // alert("Please fill all required fields before proceeding.");
            }
        });
 
        $('#company_form_btn_7').click(function(e) {
            e.preventDefault();
            var isValid = true;
            // Proceed to the next tab only if all fields are valid
            @if($file_7 != null)
               isValid = true;
            @endif
            //   return;
            if (isValid) {
                // $('#step_from_7').submit(function(e) {
                e.preventDefault();
                var form = new FormData(document.getElementById('step_from_7'));
                var token = $('#token').val();
                form.append('_token', token);
                // var x = document.getElementById("myAudio");
                $.ajax({
                    url: '{{ route(auth()->user()->type.".update_onboarding_profile_step_7") }}',
                    type: 'post',
                    data: form,
                    cache: false,
                    contentType: false, //must, tell jQuery not to process the data
                    processData: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        
                          $(document).ajaxStop(function() {
                            localStorage.setItem("insuranceUpdateSuccess", "true");
                            window.location.reload();
                        });
                    }
                });
                //   });

            } else {
                $('#company_form_btn_7').removeAttr('disabled', 'true');
                $('#error_alert').css("display", "block");
                $('#error_alert').html("Please provide valid insurance information.");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("Please provide valid insurance information...");
                return false;
                // alert("Please fill all required fields before proceeding.");
            }
        });

        //    $(".refrencestable .tablesbody .items .addedbtns").click(function () {
        //      $(this).closest('.row').addClass('active'); 
        //      $(this).addClass('closebtns'); 
        //    });

        //    $(".items .addedbtns.closebtns").click(function () {
        //         $(this).closest('.row').removeClass('active'); 
        //    });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showHideSections = document.querySelectorAll('.showHide');
            showHideSections.forEach(section => {
                const formFields = section.querySelectorAll('input, select');
                formFields.forEach(field => {
                    field.disabled = true; // Disable fields initially
                });
                section.classList.remove('active');
                section.style.opacity = '0.5';
            });

            function toggleEdit(button) {
                // Get the closest mainHead and find the corresponding .showHide section
                const showHideSection = button.closest('.tabsData-view').querySelector('.showHide');
                const formFields = showHideSection.querySelectorAll('input, select');
                if (formFields.length > 0) {
                    const isEditing = !formFields[0].disabled;
                    formFields.forEach(field => {
                        field.disabled = isEditing; // Toggle disabled state
                    });
                    showHideSection.classList.toggle('active');
                    showHideSection.style.opacity = isEditing ? '0.5' : '1';
                }
            }

            const editButtons = document.querySelectorAll('.mainHead .themeBtn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    toggleEdit(button);
                });
            });
        });
    </script>
@endpush
