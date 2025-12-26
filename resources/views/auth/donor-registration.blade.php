@extends('layouts.auth_layout')

@section('title', 'Complete Donor Profile')

@section('content')
    <div class="col-span-4 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-blue-600">
            <h3 class="font-bold text-lg mb-6">Complete Your Donor Profile</h3>

            <div id="alert" class="hidden p-3 rounded-lg text-white mb-4"></div>

            <form id="donor-profile-form" class="space-y-4">

                <input type="text" name="health_condition" placeholder="Health Condition"
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                    required>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition">
                    Save Profile
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let userLat = null;
            let userLng = null;

            // Try to detect user location automatically
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    userLat = pos.coords.latitude;
                    userLng = pos.coords.longitude;
                    $('#location-status').text('Location detected ✅')
                        .removeClass('text-gray-500 text-red-600')
                        .addClass('text-green-600');
                }, function() {
                    $('#location-status').text('Failed to detect location ❌')
                        .removeClass('text-green-600')
                        .addClass('text-red-600');
                });
            } else {
                $('#location-status').text('Geolocation not supported ❌').addClass('text-red-600');
            }

            $('#donor-profile-form').submit(function(e) {
                e.preventDefault();

                const token = localStorage.getItem('access_token');

                if (!userLat || !userLng) {
                    $('#alert')
                        .removeClass('hidden bg-green-500')
                        .addClass('bg-red-500')
                        .text('Please allow location access to continue ❌');
                    return;
                }

                const data = {
                    location_lat: userLat,
                    location_lng: userLng,
                    available: true,
                    health_condition: $('input[name="health_condition"]').val()
                };

                $.ajax({
                    url: '/api/v1/donors',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(res) {
                        localStorage.setItem('donor-reg', true);
                        $('#alert')
                            .removeClass('hidden bg-red-500')
                            .addClass('bg-green-500')
                            .text('✅ Profile updated successfully. Redirecting...');
                        setTimeout(() => window.location.href = '/', 1200);
                    },
                    error: function(err) {
                        const message = err.responseJSON?.message || 'Failed to save profile ❌';
                        $('#alert')
                            .removeClass('hidden bg-green-500')
                            .addClass('bg-red-500')
                            .text(message);
                    }
                });
            });
        });
    </script>
@endsection
