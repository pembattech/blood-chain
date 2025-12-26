@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="gradient-header h-64 w-full p-8 text-white relative">
            <div class="flex justify-between items-center max-w-6xl mx-auto">
                <h2 class="text-2xl font-semibold">Blood Requests</h2>
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/40" class="rounded-full border-2 border-white shadow-sm" alt="User">
                    <i class="fa-solid fa-bell text-xl"></i>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 max-w-6xl mx-auto mt-10 relative z-10">
                <div class="bg-white rounded-xl p-5 text-gray-800 shadow-lg card-hover">
                    <h3 class="font-bold text-gray-600 mb-4">Your Impact</h3>
                    <div class="flex items-center gap-6">
                        <div class="relative w-20 h-20 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="40" cy="40" r="35" stroke="#eee" stroke-width="6" fill="transparent" />
                                <circle cx="40" cy="40" r="35" stroke="#E63946" stroke-width="6" fill="transparent" stroke-dasharray="220" stroke-dashoffset="60" />
                            </svg>
                            <i class="fa-solid fa-droplet absolute text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">3 <span class="text-sm font-normal text-gray-400">Donations</span></p>
                            <p class="text-md font-bold text-blue-900">10 <span class="text-sm font-normal text-gray-400">Lives Helped</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover">
                    <div class="bg-gray-200 h-32 flex items-center justify-center relative">
                        <span class="text-gray-400 font-medium italic">Interactive Map View</span>
                        <i class="fa-solid fa-location-dot absolute top-4 left-10 text-red-500"></i>
                        <i class="fa-solid fa-location-dot absolute bottom-6 right-12 text-red-500"></i>
                    </div>
                    <div class="p-3 bg-white flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-gray-500">Nearby Requests</p>
                            <p class="text-sm font-bold text-blue-900">O+ urgent needed</p>
                        </div>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Response</button>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 text-gray-800 shadow-lg card-hover">
                    <h3 class="font-bold text-gray-600 mb-2">Your Next Donation</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                        <p class="text-xs text-blue-700">Appointment: July 15, 2024 at 10:00 AM</p>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-xs text-gray-400">1600 AM</p>
                        <a href="#" class="text-blue-600 text-xs font-bold underline">Reschedule</a>
                    </div>
                </div>
            </div>
        </div>

    {{-- Requests Section --}}
    <div class="max-w-6xl mx-auto mt-24 px-8 grid gap-8">
        <div class="col-span-8 bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-6">Compatible Blood Requests</h3>

            <div id="matchesContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- AJAX will populate cards here --}}
            </div>

            <p id="noMatches" class="col-span-1 text-gray-500 hidden">No compatible requests found.</p>


        </div>

    </div>



    <script>
        $(document).ready(function() {

            // Function to fetch compatible matches
            function fetchMatches() {
                $.ajax({
                    url: '/api/v1/matches/compatible',
                    type: 'GET',
                    success: function(response) {
                        const container = $('#matchesContainer');
                        container.empty(); // Clear existing cards
                        $('#noMatches').addClass('hidden');

                        if (!response.matches || response.matches.length === 0) {
                            $('#noMatches').removeClass('hidden');
                            return;
                        }

                        response.matches.forEach(function(match) {

                            // Status badge
                            const statusClass = match.status === 'pending' ?
                                'bg-yellow-100 text-yellow-800' :
                                match.status === 'accepted' ?
                                'bg-blue-100 text-blue-700' :
                                'bg-green-100 text-green-700';

                            // Urgency badge & animation
                            let urgencyBadge = '';
                            let urgencyCardClass = ''; // For border & shadow
                            if (match.urgency === 'high') {
                                urgencyBadge =
                                    `<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded animate-pulse">HIGH URGENCY</span>`;
                                urgencyCardClass =
                                    'border border-red-500 shadow-lg'; // Pop-out effect
                            } else if (match.urgency === 'medium') {
                                urgencyBadge =
                                    `<span class="bg-yellow-400 text-white text-xs px-2 py-0.5 rounded">MEDIUM</span>`;
                                urgencyCardClass = 'border border-yellow-400 shadow-md';
                            } else {
                                urgencyBadge =
                                    `<span class="bg-green-500 text-white text-xs px-2 py-0.5 rounded">LOW</span>`;
                                urgencyCardClass = 'border border-green-400 shadow-sm';
                            }

                            // Card HTML
                            const card = `
        <div class="bg-white p-5 rounded-lg transition relative hover:shadow-xl ${urgencyCardClass}">
            <!-- Status Badge -->
            <div class="absolute top-1 right-3">
                
                ${urgencyBadge}
            </div>

            <!-- Request Info -->
            
            <p class="text-red-500 font-semibold mb-1 mt-2">
                Blood Type: ${match.blood_type_needed}
            </p>

            <p class="text-gray-500 text-sm mb-3">
                Posted: ${new Date(match.created_at).toLocaleString()}
            </p>

            <!-- Donate Button -->
            <a href="/donate/${match.id}" class="block bg-blue-600 text-white text-center px-3 py-2 rounded hover:bg-blue-700 transition">
                Donate Now
            </a>
        </div>
    `;

                            // Append card
                            container.append(card);

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching matches:', error);
                    }
                });
            }

            // Initial fetch on page load
            fetchMatches();

            // Optional: refresh every 60 seconds
            setInterval(fetchMatches, 60000);
        });
    </script>


@endsection
