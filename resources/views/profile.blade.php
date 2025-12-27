@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="gradient-header h-48 w-full p-8 text-white relative">
        <div class="flex justify-between items-center max-w-5xl mx-auto">
            <h2 class="text-2xl font-semibold">User Profile</h2>
            <div class="flex items-center gap-4">
                <button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm transition">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Edit Profile
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto -mt-16 px-8 pb-12 relative z-10">
        <div class="grid grid-cols-12 gap-8">

            <div class="col-span-4 space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4 profile-pic-container">
                        <img src="https://i.pravatar.cc/128"
                            class="rounded-full border-4 border-white shadow-md w-full h-full object-cover" alt="Profile">
                        <div
                            class="edit-overlay absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 transition cursor-pointer">
                            <i class="fa-solid fa-camera text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 id="user-name" class="user-name text-xl font-bold text-gray-800"></h3>
                    <p id="member-since" class="text-gray-500 text-sm mb-4">Member since Jan 2024</p>
                    <div id="blood-group" class="inline-block bg-red-100 text-red-600 font-bold px-4 py-1 rounded-full text-lg">
                        Blood Group: O+
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4 border-t pt-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Donations</p>
                            <p id="donations-count" class="text-xl font-bold text-blue-900">12</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Rank</p>
                            <p class="text-xl font-bold text-blue-900">Gold</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <h4 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-blue-500"></i> Quick Info
                    </h4>
                    <ul class="space-y-3 text-sm">
                        {{-- <li class="flex justify-between">
                            <span class="text-gray-500">Age:</span>
                            <span class="font-medium">28 Years</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Weight:</span>
                            <span class="font-medium">75 kg</span>
                        </li> --}}
                        <li class="flex justify-between">
                            <span class="text-gray-500">Last Donation:</span>
                            <span  class="last-donation-date font-medium text-red-500">12 June 2024</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-span-8 space-y-6">
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Personal Details</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Full Name</label>
                            <p id="user-name" class="user-name text-gray-800 font-medium border-b border-gray-100 py-2"></p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Email Address</label>
                            <p id="user-email" class="user-email text-gray-800 font-medium border-b border-gray-100 py-2"></p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Phone Number</label>
                            <p id="user-phone" class="text-gray-800 font-medium border-b border-gray-100 py-2"></p>
                        </div>
                        {{-- <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Location</label>
                            <p class="text-gray-800 font-medium border-b border-gray-100 py-2">Downtown, New York</p>
                        </div> --}}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Donation History</h3>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Download Report</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase border-b">
                                    <th class="pb-3 font-semibold">Location</th>
                                    <th class="pb-3 font-semibold">Date</th>
                                    <th class="pb-3 font-semibold">Units</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                                    <td class="py-4 font-medium">City General Hospital</td>
                                    <td class="py-4 text-gray-500">June 12, 2024</td>
                                    <td class="py-4 text-gray-500">1 Unit</td>
                                    <td class="py-4">
                                        <span
                                            class="bg-green-100 text-green-600 px-2 py-1 rounded text-[10px] font-bold">COMPLETED</span>
                                    </td>
                                </tr>
                                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                                    <td class="py-4 font-medium">Red Cross Center</td>
                                    <td class="py-4 text-gray-500">March 05, 2024</td>
                                    <td class="py-4 text-gray-500">1 Unit</td>
                                    <td class="py-4">
                                        <span
                                            class="bg-green-100 text-green-600 px-2 py-1 rounded text-[10px] font-bold">COMPLETED</span>
                                    </td>
                                </tr>
                                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                                    <td class="py-4 font-medium">St. Jude Hospital</td>
                                    <td class="py-4 text-gray-500">Nov 18, 2023</td>
                                    <td class="py-4 text-gray-500">2 Units</td>
                                    <td class="py-4">
                                        <span
                                            class="bg-green-100 text-green-600 px-2 py-1 rounded text-[10px] font-bold">COMPLETED</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/api/v1/user/profile',
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                xhrFields: {
                    withCredentials: true
                },
                success: function(res) {
                    if (!res.user) return;

                    const user = res.user;

                    // --- Basic Info ---
                    $('.user-name').text(user.name);
                    $('.user-email').text(user.email);
                    $('#user-phone').text(user.phone ?? 'N/A');

                    // Display donor location if available
                    let locationText = 'N/A';
                    if (user.donor && user.donor.location_lat && user.donor.location_lng) {
                        locationText = `${user.donor.location_lat}, ${user.donor.location_lng}`;
                    }
                    $('#user-location').text(locationText);

                    $('#blood-group').text('Blood Group: ' + (user.blood_type ?? 'N/A'));

                    const created = new Date(user.created_at);
                    $('#member-since').text(
                        'Member since ' + created.toLocaleDateString('en-US', {
                            month: 'short',
                            year: 'numeric'
                        })
                    );

                    // --- Donation Info ---
                    const donationsCount = res.donations_count ?? 0;
                    const lastDonation = res.last_donation;
                    const donationHistory = res.donations ?? [];

                    // Update quick info / stats
                    $('#donations-count').text(donationsCount);
                    $('.last-donation-date').text(lastDonation ? new Date(lastDonation.date)
                        .toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        }) : 'N/A');

                    // --- Populate donation table ---
                    const tbody = $('table tbody');
                    tbody.empty();

                    if (donationHistory.length === 0) {
                        tbody.append(
                            '<tr><td colspan="4" class="text-center py-4 text-gray-500">No donations yet</td></tr>'
                            );
                    } else {
                        donationHistory.forEach(d => {
                            const statusClass = d.status === 'completed' ?
                                'bg-green-100 text-green-600' :
                                d.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                'bg-gray-100 text-gray-600';

                            tbody.append(`
                        <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                            <td class="py-4 font-medium">${d.location}</td>
                            <td class="py-4 text-gray-500">${new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                            <td class="py-4 text-gray-500">${d.units} Unit${d.units > 1 ? 's' : ''}</td>
                            <td class="py-4">
                                <span class="${statusClass} px-2 py-1 rounded text-[10px] font-bold uppercase">${d.status}</span>
                            </td>
                        </tr>
                    `);
                        });
                    }

                },
                error: function(err) {
                    console.error('Failed to fetch user profile', err);
                    // window.location.href = '/login';
                }
            });

        });
    </script>

@endsection
