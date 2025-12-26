@extends('layouts.auth_layout')

@section('title', 'Register as Donor')

@section('content')
<div class="col-span-4 space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-blue-600">
        <h3 class="font-bold text-lg mb-6">Register as Donor</h3>

        <!-- Alert -->
        <div id="alert" class="hidden p-3 rounded-lg text-white mb-4"></div>

        <form id="donor-register-form" class="space-y-4">
            <input type="text" name="name" placeholder="Full Name"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <input type="email" name="email" placeholder="Email"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <input type="password" name="password" placeholder="Password"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <input type="text" name="phone" placeholder="Phone Number"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <select name="blood_type"
                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                required>
                <option value="" disabled selected>Select Blood Type</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition">
                Sign Up
            </button>
        </form>

        <!-- Login Link -->
        <p class="mt-4 text-sm text-gray-500 text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login here</a>
        </p>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#donor-register-form').submit(function(e){
        e.preventDefault();

        const formData = {
            name: $('input[name="name"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            password_confirmation: $('input[name="password_confirmation"]').val(),
            phone: $('input[name="phone"]').val(),
            blood_type: $('select[name="blood_type"]').val(),
        };

        $.ajax({
            url: 'api/v1/register',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(res){
                $('#alert')
                    .removeClass('hidden bg-red-500')
                    .addClass('bg-green-500')
                    .text('Registration successful ✅ Redirecting to login...');

                // Reset form
                $('#donor-register-form')[0].reset();

                // Redirect to login after 1 second
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1000);
            },
            error: function(err){
                const message = err.responseJSON?.message || 'Registration failed ❌';
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
