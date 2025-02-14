 <?php
    if(isset($file_1)){
        $ff = $file_1->where('file_type', 'step_1_file')->first();
    }else{
        $ff = null;
    }
    ?>  
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places"></script>
    <script>
        $('#state').change(function() {
            var state = $('#state').val();
            var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/get_cities/" + state;
            $.ajax({
                'type': 'get',
                'url': url,
                success: function(response) {
                    $('#company_city').empty();
                    $('#company_city').append('<option value="">Select City</option>');
                    // response.cities.forEach(function(city) {
                    //     $('#company_city').append('<option value="' + city.name + '">' + city.name +
                    //         '</option>');
                    // });
                    
                     response.cities.forEach(function(city) {
                         @php
                        $onbdCity =    isset($onboarding_profile) ? $onboarding_profile->city : '';
                         @endphp
                        $('#company_city').append(
                            '<option value="' + city.name + '"' + 
                            (city.name === "{{ $onbdCity }}" ? ' selected' : '') + '>' +
                            city.name + 
                            '</option>'
                        );
                    });
                },
            });
        })

        $('#exemption_state').change(function() {
            var state = $('#exemption_state').val();
              var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/get_cities/" + state;
            $.ajax({
                'type': 'get',
                'url': url,
                success: function(response) {
                    $('#exemption_city').empty();
                    $('#exemption_city').append('<option value="">Select City</option>');
                    response.cities.forEach(function(city) {
                        $('#exemption_city').append('<option value="' + city.name + '">' + city.name +
                            '</option>');
                    });
                },
            });
        })
        var area_count = 1;
        $('#addedbtns').click(function() {
            var random_id = (Math.random() + 1).toString(36).substring(7);

            var html = '';
            html += '<div class="items" id="id_' + random_id + '">';
            html += '<div class="steps firststep">';
            html += '<div class="row active">';
            html += '<div class="col-md-3">';
            html += '<div class="divs fields">';
            html += '<input type="text" required name="origin[]">';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div class="divs fields">';
            html += '<input type="text" name="destination[]" required>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-1">';
            html += '<div class="divs fields">';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-2">';
            html += '<div class="divs btnmain">';
            html += '<a class="themeBtn savedet" href="javascript:;" title="" onclick="remove_prefered_areas(\'' +
                random_id + '\')">Remove</a>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#append_areas').append(html);
        });

        function remove_prefered_areas(id) {
            $('#id_' + id + '').remove();
        }

        function toggleDiv(show) {
            const factoryDetails = document.getElementById('hide_PaymentRemit');
            if (show) {
                factoryDetails.style.display = 'block'; // Show the div
                initializeStreet();
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
                 initializeStreet();
                factoryDetails.style.display = 'none'; // Hide the div
            }
        }
        
        
        function initializeStreet() {
             const center = { lat: 50.064192, lng: -130.605469 };
             const defaultBounds = {
                north: center.lat + 0.1,
                south: center.lat - 0.1,
                east: center.lng + 0.1,
                west: center.lng - 0.1,
              };
          
          
            var options1 = {
                bounds: defaultBounds,
                componentRestrictions: {country: ["us","cn","ca"]},
                fields: ["address_components", "geometry", "icon", "name"],
                strictBounds: false,
                types: ["address"]
            };
        
            // Pickup
            $('.StreetAddresstField').each(function() {
                var autocomplete1 = new google.maps.places.Autocomplete(this, options1);
                var thisss = $(this);
                google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                    var place1 = autocomplete1.getPlace();
                    $(this).val(place1.formatted_address);
                });
            });

        }
        initializeStreet();
    </script>
@endpush
