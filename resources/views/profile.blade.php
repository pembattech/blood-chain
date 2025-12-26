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
                    <h3 class="text-xl font-bold text-gray-800">John Doe</h3>
                    <p class="text-gray-500 text-sm mb-4">Member since Jan 2024</p>
                    <div class="inline-block bg-red-100 text-red-600 font-bold px-4 py-1 rounded-full text-lg">
                        Blood Group: O+
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4 border-t pt-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Donations</p>
                            <p class="text-xl font-bold text-blue-900">12</p>
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
                        <li class="flex justify-between">
                            <span class="text-gray-500">Age:</span>
                            <span class="font-medium">28 Years</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Weight:</span>
                            <span class="font-medium">75 kg</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Last Donation:</span>
                            <span class="font-medium text-red-500">12 June 2024</span>
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
                            <p class="text-gray-800 font-medium border-b border-gray-100 py-2">Johnathon Doe</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Email Address</label>
                            <p class="text-gray-800 font-medium border-b border-gray-100 py-2">j.doe@example.com</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Phone Number</label>
                            <p class="text-gray-800 font-medium border-b border-gray-100 py-2">+1 (555) 000-1234</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Location</label>
                            <p class="text-gray-800 font-medium border-b border-gray-100 py-2">Downtown, New York</p>
                        </div>
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
@endsection
