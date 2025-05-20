@extends('frontend.layout')
@section('content')
    <div id="map-container">
        <!-- Always visible popup -->
        <div class="custom-popup">
            <h3 class="mb-1" style="text-align: center">American Gold Star Manor</h3>
            <div style="text-align: center">Long Beach, CA</div>
        <hr>
        <div style="text-align: center;text-decoration: none">
            <a href="https://maps.apple.com/search?query=3021%20N%20Gold%20Star%20Drive%2C%20Long%20Beach%2C%20CA%2090810" class="mt-2" style="text-align: center;color: cornsilk;">Map & directions...</a>
        </div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        <!-- Background Map Image -->
        <div class="map-bg">
            <img src="{{asset('assets/img/background-map.png')}}" alt="Background Map">
        </div>  
   
        <!-- Sidebar Content Overlay -->
        <div class="container">
            <div class="sidebar-map">
                <h4> Daytime Guest Parking (6 AM - 10 PM)</h4>
                <p>Residents must register their guest vehicles 24/7. No limits on daytime guest parking.
                Digital Permit required. Resident vehicles may not register. </p>
                <a href="{{ route('parking-attendent-day') }}" style="color: white;text-decoration: none"><button type="button" class="btn btn-register" data-toggle="modal" data-target="#dayParkingModal" style="width: 100%" > Register </button></a>
                 <a href="{{ route('pre.authorize') }}" style="color: white;text-decoration: none"><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#dayParkingModal" style="width: 100%;color: black,border-color: black">Pre Authorizated</button></a>
                </br>
                  </br>
                <h4><b>Overnight Guest Parking</b></h4>
                <p>Residents must register their guest vehicles 24/7. Overnight limits apply per vehicle.Digital Permit required. Resident vehicles may not register. Vehicles limited to 14 per calendar month, 60 per calendar year.</p>
                <a href="{{ route('parking-attendent-night') }}" style="color: white;text-decoration: none"><button type="button" class="btn btn-register" data-toggle="modal" data-target="#dayParkingModal" style="width: 100%">Register</button> </a>            
                 <a href="{{ route('pre.authorize') }}" style="color: white;text-decoration: none"><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#dayParkingModal" style="width: 100%;color: black,border-color: black">Pre Authorizated</button></a>      
                </br>
                </br>
                <p>Questions?Contact Administration Office at info@goldstarmanor.org or 5624267651.</p>
            </div>
        </div>
        <!-- Footer -->
       

    </div>
      

    <script>
        $('#dayParkingForm').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
    
            // Clear previous errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
    
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Check that end is after or equal to start
                const startTime = new Date($('#datetime-select').val());
                const endTime = new Date($('#datetime-select-end').val());

                if (endTime < startTime) {
                    toastr.error('Ending time must be after or equal to the starting time.');
                    return;
                }

                    toastr.success('Registration submitted successfully!');
                    form[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            const input = $('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                }
            });
        });
    </script>
    
    
   

<script>
    function getUpcomingDays(daysOfWeek) {
        const today = new Date();
        const results = [];

        for (let i = 0; i < 7; i++) {
            const date = new Date();
            date.setDate(today.getDate() + i);
            if (daysOfWeek.includes(date.getDay())) {
                results.push(date);
            }
            if (results.length === daysOfWeek.length) break;
        }

        return results;
    }

    function generateOption(date) {
        const dayStr = date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: '2-digit'
        });
        const formattedDate = `${dayStr} 6:00 PM`;

        // Set fixed 10:00 PM time
        date.setHours(22, 0, 0, 0); // 22:00:00

        const isoValue = date.toISOString().split('.')[0]; // keep format: yyyy-mm-ddThh:mm:ss

        const option = document.createElement('option');
        option.value = isoValue;
        option.textContent = formattedDate;
        option.setAttribute('label', formattedDate);
        return option;
    }


    function generateOptionnight(date) {
        const dayStr = date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: '2-digit'
        });
        const formattedDate = `${dayStr} 10:00 PM`;


        date.setHours(22, 0, 0, 0); // 22:00:00

        const isoValue = date.toISOString().split('.')[0]; // keep format: yyyy-mm-ddThh:mm:ss

        const option = document.createElement('option');
        option.value = isoValue;
        option.textContent = formattedDate;
        option.setAttribute('label', formattedDate);
        return option;
    }

    const select = document.getElementById('datetime-select');
    const weekdays = getUpcomingDays([3, 4, 5]); // Wed = 3, Thu = 4, Fri = 5

    weekdays.forEach(date => {
        const option = generateOption(date);
        select.appendChild(option);
    });


    const endSelect = document.getElementById('datetime-select-end');
    const endDates = getUpcomingDays([4, 5], 2); // Thu = 4, Fri = 5
    endDates.forEach(date => {
        endSelect.appendChild(generateOptionnight(date));
    });
</script>
<!-- Place this AFTER toastr.min.js and AFTER jQuery if used -->

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };
</script>

@if (session('success'))
    <script>toastr.success('{{ session('success') }}');</script>
@endif

@if (session('error'))
    <script>toastr.error('{{ session('error') }}');</script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>toastr.error("{{ $error }}");</script>
    @endforeach
@endif


@endsection
  