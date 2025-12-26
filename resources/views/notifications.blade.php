@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

        <div class="gradient-header h-40 w-full p-8 text-white relative">
            <div class="max-w-4xl mx-auto flex justify-between items-end h-full pb-4">
                <div>
                    <h2 class="text-3xl font-bold">Notifications</h2>
                    <p class="text-blue-100 text-sm">Stay updated with matches and community news</p>
                </div>
                <button class="text-sm bg-white/10 hover:bg-white/20 border border-white/30 px-4 py-2 rounded-lg transition">
                    Mark all as read
                </button>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-8 py-8">
            
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex border-b px-6">
                    <button class="px-4 py-4 text-sm font-bold text-blue-600 border-b-2 border-blue-600">All Alerts</button>
                    <button class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">Urgent</button>
                    <button class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">Activities</button>
                </div>

                <div class="divide-y divide-gray-100">
                    
                    <div class="notification-item urgent unread p-6 flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-800">Critical Match Found!</h4>
                                <span class="text-xs text-gray-400">2 mins ago</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">An urgent request for <strong>O+ Blood</strong> has been posted at City General Hospital (1.2km away). Your help is needed immediately.</p>
                            <div class="mt-3 flex gap-2">
                                <button class="bg-red-500 text-white px-4 py-1.5 rounded-md text-xs font-bold hover:bg-red-600 transition">Respond Now</button>
                                <button class="text-gray-400 text-xs px-4 py-1.5 border rounded-md hover:bg-gray-50">Dismiss</button>
                            </div>
                        </div>
                    </div>

                    <div class="notification-item p-6 flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-800">Donation Successful</h4>
                                <span class="text-xs text-gray-400">Yesterday</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Thank you, John! Your donation at St. Jude Hospital has been processed. You just helped save a life.</p>
                            <a href="#" class="text-blue-600 text-xs font-bold mt-2 inline-block hover:underline">View Impact Report</a>
                        </div>
                    </div>

                    <div class="notification-item unread p-6 flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-800">Upcoming Appointment</h4>
                                <span class="text-xs text-gray-400">2 days ago</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Don't forget your scheduled donation appointment on <strong>July 15th</strong> at 10:00 AM.</p>
                            <div class="mt-3">
                                <button class="text-blue-600 text-xs font-bold border border-blue-600 px-3 py-1 rounded hover:bg-blue-50">Set Reminder</button>
                            </div>
                        </div>
                    </div>

                    <div class="notification-item p-6 flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-800">Profile Verified</h4>
                                <span class="text-xs text-gray-400">1 week ago</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Your medical documents have been verified. You are now a <strong>Verified Hero Donor</strong>.</p>
                        </div>
                    </div>

                </div>
                
                <div class="bg-gray-50 p-4 text-center">
                    <button class="text-gray-500 text-sm font-medium hover:text-blue-600 transition">View Notification History</button>
                </div>
            </div>

        </div>
@endsection
