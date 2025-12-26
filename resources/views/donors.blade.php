@extends('layouts.app')

@section('title', 'Donor Directory')

@section('content')

<div class="gradient-header h-40 w-full p-8 text-white relative">
    <div class="max-w-6xl mx-auto flex justify-between items-end h-full pb-4">
        <div>
            <h2 class="text-3xl font-bold">Donor Directory</h2>
            <p class="text-blue-100 text-sm">Browse and connect with compatible blood donors</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-map-location-dot mr-2"></i>Map View
            </button>
            <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg transition">
                <i class="fa-solid fa-download mr-2"></i>Export List
            </button>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="donors-container">
        <p class="text-gray-500 text-center w-full">Loading donors...</p>
    </div>

    <div id="pagination" class="flex justify-center mt-10 gap-2"></div>
</div>

<script>
$(document).ready(function () {
    let userBloodType = '{{ auth()->user()->blood_type ?? "" }}'; // Optional: logged-in user blood type

    // Blood type colors
    const bloodColors = {
        'O+': 'text-red-600',
        'O-': 'text-red-700',
        'A+': 'text-blue-600',
        'A-': 'text-blue-700',
        'B+': 'text-green-600',
        'B-': 'text-green-700',
        'AB+': 'text-purple-600',
        'AB-': 'text-purple-700'
    };

    function fetchDonors(page = 1){
        $.ajax({
            url: '/api/v1/donors',
            method: 'GET',
            data: { page: page },
            success: function(res){
                renderDonors(res.data);
                renderPagination(res.meta);
            },
            error: function(){
                $('#donors-container').html('<p class="text-gray-500 text-center w-full">Failed to load donors.</p>');
            }
        });
    }

    function renderDonors(donors){
        let container = $('#donors-container');
        container.empty();

        if(donors.length === 0){
            container.html('<p class="text-gray-500 text-center w-full">No donors found.</p>');
            return;
        }

        donors.forEach(function(donor){
            // Determine availability
            let available = donor.available;
            // let statusText = available ? 'AVAILABLE' : `Cool-down (${donor.cooldown_days}d)`;
            let statusText = available ? 'AVAILABLE' : 'UNAVAILABLE';
            let statusBg = available ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600';
            let buttonClass = available ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed';
            let buttonText = available ? 'Request Blood' : 'Unavailable';

            console.log(donor.data);

            // Blood type color
            let bloodColorClass = bloodColors[donor.blood_type] || 'text-gray-600';

            let card = `
            <div class="bg-white rounded-2xl p-6 border-2 border-transparent donor-card shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-3">
                    <span class="${statusBg} text-[10px] font-bold px-2 py-1 rounded uppercase">${statusText}</span>
                </div>
                <div class="flex items-center gap-4 mb-6">
                    <img src="${donor.avatar || 'https://i.pravatar.cc/150?u='+donor.id}"
                        class="w-16 h-16 rounded-full object-cover border-2 border-gray-100">
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg">${donor.user.name}</h4>
                    </div>
                </div>
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl mb-6">
                    <div class="text-center flex-1 border-r">
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Group</p>
                        <p class="text-lg font-bold ${bloodColorClass}">${donor.user.blood_type}</p>
                    </div>
                    <div class="text-center flex-1">
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Last Donations</p>
                        <p class="text-lg font-bold text-blue-900">${donor.last_donation_date}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 ${buttonClass} py-2 rounded-lg text-sm font-bold transition">${buttonText}</button>
                </div>
            </div>
            `;
            container.append(card);
        });
    }

    function renderPagination(meta){
        let pagination = $('#pagination');
        pagination.empty();
        if(!meta) return;

        for(let i=1;i<=meta.last_page;i++){
            let activeClass = i === meta.current_page ? 'bg-blue-600 text-white font-bold' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50';
            let button = `<button onclick="fetchDonors(${i})" class="w-10 h-10 flex items-center justify-center rounded-lg ${activeClass}">${i}</button>`;
            pagination.append(button);
        }
    }

    fetchDonors();
});
</script>

@endsection
