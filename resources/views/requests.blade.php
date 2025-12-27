@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="gradient-header h-40 w-full p-8 text-white relative">
        <div class="max-w-5xl mx-auto flex justify-between items-end h-full pb-4">
            <div>
                <h2 class="text-3xl font-bold">Active Blood Requests</h2>
                <p class="text-blue-100 text-sm">Find people who need your help nearby</p>
            </div>
            <button
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-sm"></i>
                <a href="{{ route('create-request') }}" class="text-white">Create Request</a>
            </button>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-8 py-8">
        <!-- Requests Container -->
        <div id="requests-container" class="space-y-4">
            <p class="text-gray-500 text-center">Loading requests...</p>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex justify-center mt-10 gap-2"></div>
    </div>

    <script>
        $(document).ready(function() {
            let userLat = null;
            let userLng = null;

            // Blood type color map
            const bloodTypeColors = {
                'O+': 'bg-red-100 text-red-600',
                'O-': 'bg-red-200 text-red-700',
                'A+': 'bg-blue-100 text-blue-600',
                'A-': 'bg-blue-200 text-blue-700',
                'B+': 'bg-green-100 text-green-600',
                'B-': 'bg-green-200 text-green-700',
                'AB+': 'bg-purple-100 text-purple-600',
                'AB-': 'bg-purple-200 text-purple-700'
            };

            // Get user location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    userLat = pos.coords.latitude;
                    userLng = pos.coords.longitude;
                    fetchRequests();
                }, function(err) {
                    console.warn('Location denied, loading requests without distance.');
                    fetchRequests();
                });
            } else {
                fetchRequests();
            }

            // Fetch requests from API
            window.fetchRequests = function(page = 1) {
                $.ajax({
                    url: '/api/v1/blood-requests',
                    method: 'GET',
                    data: {
                        page: page,
                        user_lat: userLat,
                        user_lng: userLng
                    },
                    success: function(res) {
                        // Sort by distance (ascending)
                        res.data.sort((a, b) => {
                            if (a.distance === null) return 1;
                            if (b.distance === null) return -1;
                            return a.distance - b.distance;
                        });

                        renderRequests(res.data);
                        renderPagination(res.meta);
                    },
                    error: function() {
                        $('#requests-container').html(
                            '<p class="text-gray-500 text-center">Failed to load requests.</p>');
                    }
                });
            }

            // Render request cards
            function renderRequests(requests) {
                let container = $('#requests-container');
                container.empty();
                if (requests.length === 0) {
                    container.html('<p class="text-gray-500 text-center">No blood requests found.</p>');
                    return;
                }

                requests.forEach(function(req) {
                    let urgencyColor = ['HIGH', 'MEDIUM'].includes(req.urgency?.toUpperCase()) ? 'red' :
                        'blue';
                    let urgencyText = req.urgency?.toUpperCase() ?? '';
                    let distance = req.distance ?? '—';
                    let donorsNeeded = req.donors_needed ?? 1;
                    let compatibleDonors = req.compatible_donors_count ?? 0;
                    let posted = req.posted ?? 'just now';

                    // Blood type color
                    let bloodColorClass = bloodTypeColors[req.blood_type_needed] ||
                        'bg-gray-100 text-gray-600';

                    let card = `
            <div class="bg-white border-2 border-transparent request-card rounded-xl p-6 shadow-sm flex items-center justify-between border-l-8 border-l-${urgencyColor}-500 hover:shadow-lg transition">
                <div class="flex gap-6 items-center">
                    <div class="${bloodColorClass} w-16 h-16 rounded-full flex flex-col items-center justify-center font-bold">
                        <span class="text-lg">${req.blood_type_needed}</span>
                        <span class="text-[10px] uppercase">Group</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="bg-${urgencyColor}-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">${urgencyText}</span>
                        </div>
                        <p class="text-sm text-gray-500 flex flex-wrap gap-4 mt-1">
                            <span><i class="fa-solid fa-location-dot mr-1"></i> ${distance} km away</span>
                            <span><i class="fa-solid fa-clock mr-1"></i> Posted ${posted}</span>
                            <span><i class="fa-solid fa-user-group mr-1"></i> ${donorsNeeded} Donors needed</span>
                            <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Compatible: ${compatibleDonors}</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition shadow-md">
                        <a href="/donate/${req.id}" class="block bg-blue-600 text-white text-center px-3 py-2 rounded hover:bg-blue-700 transition">
                                        I'm Available

            </a>
                    </button>
                    
                </div>
            </div>`;
                    container.append(card);
                });
            }

            // Render pagination
            function renderPagination(meta) {
                let pagination = $('#pagination');
                pagination.empty();
                if (!meta) return;

                for (let i = 1; i <= meta.last_page; i++) {
                    let activeClass = i === meta.current_page ? 'bg-blue-600 text-white font-bold' :
                        'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50';
                    let button =
                        `<button onclick="fetchRequests(${i})" class="w-10 h-10 flex items-center justify-center rounded-lg ${activeClass}">${i}</button>`;
                    pagination.append(button);
                }
            }
        });
    </script>
@endsection
