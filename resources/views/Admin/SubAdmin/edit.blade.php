@extends('Admin.layouts.app') 
@section('content')
    <div class="col-md-10 ">
        <div class="mainBody"> 
            @include('layouts.notifications') 
            <div class="main-header">
                <h2>Edit SubAdmin</h2>
                   <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.subadmin.list') }}" class="themeBtn skyblue"><i
                            class="fa fa-eye" style="margin-right:5px;"></i>List SubAdmin</a>
                </div>
            </div> 
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form method="post" action="{{route(auth()->user()->type . '.subadmin.update', $id)}}">
                        @csrf
                        <div class="col-12">
                            <label>Name</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control" required palceholder="Name"/>
                        </div>
                        
                        <div class="col-12 py-4">
                            <label>Email</label>
                            <input type="email" name="email" value="{{$user->email}}" class="form-control" required palceholder="Email"/>
                        </div>
                        
                        <div class="col-12 py-4">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="{{$user->phone}}"  class="form-control" required palceholder="Phone"/>
                        </div>
                        
                         <div class="col-12 py-4">
                            <input type="checkbox" name="update_password" id="update_password" class="form-check-input"/>
                            <label class="form-check-label" for="update_password">Update Password</label>

                        </div>
                        
                        <div id="password_fields" style="display:none;"> 
                        
                            <div class="col-12 py-4">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control" palceholder="Password"/>
                            </div>
                            
                            <div class="col-12 py-4">
                                <label>Confirm Password</label>
                                <input type="password" name="cnfrm_password" class="form-control" palceholder="Confirm Password"/>
                            </div> 
                        </div>
                        
                        <div class="col-12 py-4"> 
                            <button class="themeBtn skyblue">Update SubAdmin</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div> 
@endsection

@push('js')
    <script>
    $(document).ready(function () {
        $('#update_password').change(function () {
            if ($(this).is(':checked')) {
                $('#password_fields').slideDown(); // Show the password fields
                $('input[type="password"]').attr('required');
            } else {
                $('#password_fields').slideUp(); // Hide the password fields
                 $('input[type="password"]').removeAttr('required');
            }
        });
    });
    </script>
    <script>
    $(document).on('input', 'input[type="tel"]', function (e) {
        var x = $(this).val().replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        $(this).val(!x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : ''));
    });
</script>
    @endpush