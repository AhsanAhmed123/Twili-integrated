@extends('frontend.layout')
@section('content')
    <div id="map-container">
        <!-- Always visible popup -->
        <div class="custom-popup">
            <h3 class="mb-1" style="text-align: center">American Gold Star Manor</h3>
            <div style="text-align: center">Long Beach, CA</div>
            <hr>
            <div style="text-align: center;text-decoration: none">
                <a href="https://maps.apple.com/search?query=3021%20N%20Gold%20Star%20Drive%2C%20Long%20Beach%2C%20CA%2090810"
                    class="mt-2" style="text-align: center;color: cornsilk;">Map & directions...</a>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        <!-- Background Map Image -->
        <div class="map-bg">
            <img src="{{ asset('assets/img/background-map.png') }}" alt="Background Map">
        </div>

        <!-- Sidebar Content Overlay -->
        <div class="container">
            <div class="sidebar-map">
                <h4>Preauthorize Daytime Guest Parking (6 AM - 10 PM)</h4>
                <p>Allow registration with a private link instead of sharing your passcode. To start, enter your info:</p>
                <form id="preauthorizeForm" action="{{ url('parking-preauthorize-store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">🏠</span>
                            </div>
                            <select class="form-control" name="aprt_number" required id="apartment" style="margin-bottom: 10px;">
                            <option value="" disabled selected>Apartment...</option>
                            <option value="OFFICE">OFFICE</option>
                            </select>
                        </div>
                        </div>

                        <script>
                        const apartmentSelect = document.getElementById('apartment');
                        for (let i = 1; i <= 348; i++) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = i;
                            apartmentSelect.insertBefore(option, apartmentSelect.lastElementChild);
                        }
                        </script>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">🔒</span>
                            </div>
                            <input type="text" name="passcode" class="form-control" id="passcode" placeholder="Passcode">
                        </div>
                    </div>
                    </br>
                    <div class="form-group">
                        <div class="input-group">
                    <select name="lifetime" class="form-control" required>
                        <option value="" disabled selected style="text-align: right">change</option>
                        <option value="PT4H" title="Link expires in 4 hours">
                            4 hours
                        </option>
                        <option value="PT12H" title="Link expires in 12 hours">
                            12 hours
                        </option>
                        <option value="PT24H"  title="Link expires in 24 hours">
                            24 hours
                        </option>
                        <option value="PT48H" title="Link expires in 48 hours">
                            48 hours
                        </option>
                        <option value="PT72H" title="Link expires in 72 hours">
                            72 hours
                        </option>
                        <option value="PT168H" title="Link expires in 7 days">
                            7 days
                        </option>
                        </select>
                        </div>
                    </div>
                </br></br>
                    <button type="submit" class="btn btn-primary" style="width: 100%">Continue</button>
                </form>
                <p>Questions?Contact Administration Office at info@goldstarmanor.org or 5624267651.</p>
            </div>
        </div>
        <!-- Footer -->


    </div>


    <script>
        $('#dayParkingForm').on('submit', function(e) {
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
                success: function(response) {
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
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
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
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error("{{ $error }}");
            </script>
        @endforeach
    @endif


@endsection
