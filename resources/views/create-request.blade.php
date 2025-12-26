@extends('layouts.app')

@section('title', 'Create Blood Request')

@section('content')
<div class="max-w-3xl mx-auto px-8 py-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create New Blood Request</h2>

    <div id="alert" class="mb-4 hidden p-4 rounded-lg text-white"></div>

    <form id="blood-request-form" class="bg-white p-6 rounded-xl shadow-sm space-y-4">

        <!-- Blood Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Blood Type Needed</label>
            <select name="blood_type_needed" class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none" required>
                <option value="">Select Blood Type</option>
                <option>O+</option>
                <option>O-</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
            </select>
        </div>

        <!-- Urgency -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
            <select name="urgency" class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none" required>
                <option value="">Select Urgency</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <!-- Number of Donors Needed -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Number of Donors Needed</label>
            <input type="number" name="donors_needed" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-400 outline-none" min="1" value="1" required>
        </div>

        <!-- Hospital Geolocation -->
        <div class="flex gap-2 items-center">
            <span id="location-status" class="text-sm text-gray-500">Detecting location...</span>
        </div>

        <input type="hidden" name="location_lat">
        <input type="hidden" name="location_lng">

        <!-- Submit -->
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-bold shadow-md transition">Submit Request</button>
    </form>
</div>

<script>
$(document).ready(function(){
    const locationStatus = $('#location-status');

    // Function to detect location
    function detectLocation(){
        if(navigator.geolocation){
            locationStatus.text('Detecting location...').removeClass('text-green-600 text-red-600').addClass('text-gray-500');
            navigator.geolocation.getCurrentPosition(function(pos){
                $('input[name="location_lat"]').val(pos.coords.latitude);
                $('input[name="location_lng"]').val(pos.coords.longitude);
                locationStatus.text('Location detected ✅').removeClass('text-gray-500 text-red-600').addClass('text-green-600');
            }, function(){
                locationStatus.text('Location not detected ❌').removeClass('text-gray-500 text-green-600').addClass('text-red-600');
            });
        } else {
            locationStatus.text('Geolocation not supported ❌').removeClass('text-gray-500 text-green-600').addClass('text-red-600');
        }
    }

    // Auto-detect on page load
    detectLocation();

    // Detect on button click
    $('#detect-location').click(detectLocation);

    // Submit Form via AJAX JSON
    $('#blood-request-form').submit(function(e){
        e.preventDefault();

        const data = {
            blood_type_needed: $('select[name="blood_type_needed"]').val(),
            urgency: $('select[name="urgency"]').val(),
            donors_needed: $('input[name="donors_needed"]').val(),
            location_lat: $('input[name="location_lat"]').val(),
            location_lng: $('input[name="location_lng"]').val()
        };

        $.ajax({
            url: '/api/v1/blood-requests',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(res){
                $('#alert').removeClass('hidden bg-red-500').addClass('bg-green-500').text('Blood request created successfully ✅');
                $('#blood-request-form')[0].reset();
                locationStatus.text('');
                detectLocation(); // Optionally re-detect after submission
            },
            error: function(err){
                let message = err.responseJSON?.message || 'Failed to create request ❌';
                $('#alert').removeClass('hidden bg-green-500').addClass('bg-red-500').text(message);
            }
        });
    });
});
</script>
@endsection
