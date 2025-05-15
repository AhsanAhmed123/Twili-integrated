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
                <h5> <i class="fas fa-angle-left"></i> Home</h5>

                <form method="Post" id="dayParkingForm" action="{{url('parking-attendent-day-store')}}">
                    <!-- Basic Information Section -->
                    @csrf
                    <h1 class="section-header">Daytime Guest Parking (6 AM - 10 PM)</h1>
                    <p>Register with the following info:</p>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- License Plate Field with Car Icon -->
                            <div class="mb-3 icon-input-group">
                                <i class="fas fa-car input-icon"></i>
                                <input type="text" name="license_number" class="form-control" id="licensePlate"
                                    placeholder="License Plate Number" required>
                                <input type="hidden" name="type" value="day">
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 icon-input-group">
                                    <i class="fas fa-home input-icon"></i>
                                   
                                    <select class="form-control" name="aprt_number" id="apartment" style="width: 100%; margin-bottom: 10px;">
                                    <option value="">OFFICE</option>
                                    <script>
                                        for (let i = 1; i <= 348; i++) {
                                            document.write(`<option value="${i}">${i}</option>`);
                                        }
                                    </script>
                                </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3 icon-input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="passcode" class="form-control" id="passcode" placeholder="Passcode"
                                    required>
                            </div>
                        </div>

                        <!-- Parking Information Section -->
                        <div class="row">
                            <h4 class="section-header">Parking In GUEST</h4>
                            <div class="date-section">
                                <!--  <div class="date-title">Starting Tue Apr 15 6:00 AM</div> -->
                            </div>

                            <table>
                                <tr>
                                    <td>Starting</td>
                                    <td>
                                        <div class="change-dropdown starting-dropdown">
                                            <select name="start_time" id="datetime-select">
                                            </select>
                                            
                                        </div>
                                        
                                      
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ending</td>
                                    <td>
                                        <div class="change-dropdown ending-dropdown">
                                            <select name="end_time" id="datetime-select-end"></select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                        <!-- Vehicle Information Section -->
                        <div class="row">
                            <div class="col-md-12 mb-3 mt-5">
                                <input type="text" name="vehicle_details" class="form-control" id="make"
                                    placeholder="Vehicle make, Model, Color" required>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="text" name="name" class="form-control" id="contactName" placeholder="Contact Name"
                                    required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="tel" class="form-control" name="phone" id="contactPhone" placeholder="Contact Phone"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="email" name="email" class="form-control" id="contactEmail" placeholder="Contact Email"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select class="confirmation-select" name="notify" id="confirmationMethod">
                                        <option value="email" title="Email confirmation only">
                                            <i class="fas fa-envelope option-icon"></i> Email confirmation only
                                        </option>
                                        <option value="tel" title="Text confirmation only">
                                            <i class="fas fa-sms option-icon"></i> Text confirmation only
                                        </option>
                                        <option value="email" title="Email & text confirmation">
                                            <i class="fas fa-mail-bulk option-icon"></i> Email & text confirmation
                                        </option>
                                        <option value="" title="Don't send confirmation">
                                            <i class="fas fa-ban option-icon"></i> Don't send confirmation
                                        </option>
                                    </select>
                                    <div class="feedback-message mt-2" id="confirmationFeedback"></div>
                                </div>

                            </div>



                            <!-- Submit Button -->
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-register">Register</button>
                                    <p>Questions?Contact Administration Office at info@goldstarmanor.org or 5624267651.
                                    </p>
                                </div>
                            </div>
                </form>
                
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
  