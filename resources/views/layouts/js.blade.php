<script src="{{ asset('assets/js/all.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>


<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-firestore.js"></script>

<!-- jQuery (use only one version) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables (only include latest version) -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Other Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    // $(window).on('load', function () {
    //     $("#preloaders").fadeOut(2000);
    //  });
</script>
<script>
    $(document).on('input', 'input[type="phone"]', function() {
            if($(this).val().length > 25) {
            $(this).val($(this).val().slice(0, 25));
        }
    });
    $(document).on('input', 'input[type="tel"]', function (e) {
        var x = $(this).val().replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        $(this).val(!x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : ''));
    });
     // Prevent non-numeric keypresses except for backspace and arrow keys
    $(document).on('keydown', 'input[type="tel"]', function (e) {
        // Allow backspace, tab, delete, arrows, home, end
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
        }
        // Prevent non-numeric input (0-9)
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
            (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
        }
    });

</script>
@if(auth()->check())
<script>
    function formatOption(option) {
        if (!option.id) {
            return option.text; // Return plain text for the search box
        }
        const prefix = $(option.element).data('prefix'); // Fetch the prefix from the data attribute
        console.log(`<span>${option.text} <span style="color: grey;">(${prefix})</span></span>`);
        return `<span>${option.text} <span style="color: grey;">(${prefix})</span></span>`;
    }
    
    // Function to render selected items
    function formatSelection(option) {
        if (!option.id) {
            return option.text;
        }
        const prefix = $(option.element).data('prefix');
        return `${option.text} <span style="color: grey;">(${prefix})</span>`;
    }
    
    $(document).on('input', "input[name='length']", function() {
        if($(this).val().length > 3) {
            $(this).val($(this).val().slice(0, 3));
        }
    });

    $(document).on('input', "input[name='weight']", function() {
        if($(this).val().length > 7) {
            $(this).val($(this).val().slice(0, 7));
        }
    });

    $(document).on('input', "input[name='reference_id']", function() {
        if($(this).val().length > 75) {
            $(this).val($(this).val().slice(0, 75));
        }
    });

    $(document).on('input',"input[name='commodity']", function() {
        if($(this).val().length > 75) {
            $(this).val($(this).val().slice(0, 75));
        }
    });

    $(document).on('input',"input[name='dat_rate']", function() {
        if($(this).val().length > 9) {
            $(this).val($(this).val().slice(0, 9));
        }
    });
    $(document).on('input', "input[name='private_rate']", function() {
        if($(this).val().length > 9) {
            $(this).val($(this).val().slice(0, 9));
        }
    });
    $(document).on('input', "input[name='max_bid_rate']", function() {
        if($(this).val().length > 9) {
            $(this).val($(this).val().slice(0, 9));
        }
    });

    $(document).on('input',"input[name='alt_phone']", function() {
            if($(this).val().length > 25) {
            $(this).val($(this).val().slice(0, 25));
        }
    });



    $(document).on('input', "input[name='phone']", function() {
            if($(this).val().length > 25) {
            $(this).val($(this).val().slice(0, 25));
        }
    });


      function refreshPage() {
        location.reload();  
      }



    function getAjaxStateAndCity() {
        return {
            url: "{{ route(auth()->user()->type . '.state_city') }}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            },
            cache: true
        };
    }

    function getAjaxOnlyCity() {

        return {
            url: "{{ route(auth()->user()->type . '.state_city') }}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function (params) {
                return {
                    q: params.term,
                    c: 'city'
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            },
            cache: true
        };
    }

    function populateSelect2WithPreselected(selectElement, preselectedValues) {
        if (preselectedValues && preselectedValues.length > 0) {
            $.ajax({
                url: "{{ route(auth()->user()->type . '.state_city') }}", // same endpoint as used for AJAX search
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    sel: preselectedValues
                },
                success: function(data) {
                    console.log(data.items);
                    $.each(data.items, function(index, item) {
                        console.log('id '+item.id + 'text '+ item.text );
                        var newOption = new Option(item.text, item.id, true, true);
                        selectElement.append(newOption);
                    });
                    selectElement.trigger('change')
                }
            });
        }
    }
</script>
@endif
@stack('js')
