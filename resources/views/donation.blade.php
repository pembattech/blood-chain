@extends('layouts.app')

@section('title', 'Donate Blood')

@section('content')

    <div class="gradient-header h-48 w-full p-8 text-white">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Blood Donation</h2>
        </div>
    </div>

    <div class="max-w-4xl mx-auto -mt-16 px-6">
        <div id="donationCard" class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-center text-gray-500">Loading donation details...</p>
        </div>
    </div>

    <script>
        const matchId = {{ $matchId }};

        function loadRequestDetails() {

            const apiToken = localStorage.getItem('access_token');


            $.ajax({
                url: `/api/v1/blood-requests/${matchId}`,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + apiToken
                },
                success: function(res) {
                    console.log(res)
                    if (!res.success) {
                        $('#donationCard').html(`<p class="text-red-500 text-center">${res.message}</p>`);
                        return;
                    }

                    const req = res.request;
                    "fulfilled"

                    if (req.status == "fulfilled") {
                        window.location.href = "/";
                    } else {


                        $('#donationCard').html(`
                <h3 class="text-xl font-bold text-gray-700 mb-6">
                    Donation Request Details
                </h3>

                <p id="nextEligible" class="text-lg font-bold text-red-500 mt-2 mb-2 hidden"></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <p class="text-xs text-gray-500">Request ID</p>
                        <p class="font-semibold text-gray-800">#${req.id}</p>
                    </div>

                    <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                        <p class="text-xs text-gray-500">Required Blood Type</p>
                        <p class="font-semibold text-red-600">${req.blood_type_needed}</p>
                    </div>
                </div>

                <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500 mb-6">
                    <p class="text-xs text-gray-500">Recipient Name</p>
                    <p class="font-semibold text-gray-800">${req.recipient.name}</p>

                    <p class="text-xs text-gray-500 mt-2">Recipient Contact</p>
                    <p class="font-semibold text-gray-800">${req.recipient.phone}</p>

                    <p class="text-xs text-gray-500 mt-2">Location</p>
                    <p class="font-semibold text-gray-800">City Hospital</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 border mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">Are you ready to donate?</h4>
                    <p class="text-sm text-gray-500">
                        By confirming, the recipient will be notified and your availability
                        will be shared with the hospital or patient.
                    </p>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/dashboard"
                       class="px-5 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Cancel
                    </a>

                    <button id="confirmBtn" type="button"
                            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">
                        Confirm Donation
                    </button>
                </div>
            `);
                    }


                    // Bind confirm button click
                    $('#confirmBtn').click(function() {
                        confirmDonation(req.id);
                    });
                },
                error: function(xhr) {
                    $('#donationCard').html(`<p class="text-red-500 text-center">Failed to load request.</p>`);
                }
            });
        }

        function confirmDonation(requestId = null) {
            $.ajax({
                url: '/api/v1/donate',
                type: 'POST',
                data: {
                    blood_request_id: requestId,
                    location: 'City Hospital',
                    units: 0.5
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '/';
                    }
                },
                error: function(xhr) {
                    const nextDate = xhr.responseJSON?.next_eligible_date;
                    if (xhr.status === 422 && nextDate) {
                        // Show next eligible date on page
                        $('#nextEligible')
                            .text(`You are not eligible to donate yet. Next eligible date: ${nextDate}`)
                            .removeClass('hidden');
                        $('#confirmBtn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    } else {
                        alert(xhr.responseJSON?.message || 'Something went wrong.');
                    }
                }
            });
        }

        // Load request details on page load
        loadRequestDetails();
    </script>

@endsection
