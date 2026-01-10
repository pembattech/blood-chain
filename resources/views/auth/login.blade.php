@extends('layouts.auth_layout')

@section('title', 'Login')

@section('content')
    <div class="col-span-4 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-blue-600">
            <h3 class="font-bold text-lg mb-6">Login to Your Account</h3>

            <!-- Alert -->
            <div id="alert" class="hidden p-3 rounded-lg text-white mb-4"></div>

            <form id="login-form" class="space-y-4">
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                    required>

                <input type="password" name="password" placeholder="Password"
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-400"
                    required>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition">
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <p class="mt-4 text-sm text-gray-500 text-center">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Register here</a>
            </p>
        </div>
    </div>

    <div class="flex absolute right-10 top-10 flex-col gap-4">
        <div class="bg-white text-gray-600 p-4 rounded-md">

            <div class="id-pass-hint flex gap-2">
                <p>p@gmail.com</p>
                <p>password</p>
            </div>

            <div class="id-pass-hint flex gap-2">
                <p>n@gmail.com</p>
                <p>password</p>
            </div>

            <div class="id-pass-hint flex gap-2">
                <p>test@example.com</p>
                <p>password</p>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(e) {
                e.preventDefault();

                const credentials = {
                    email: $('input[name="email"]').val(),
                    password: $('input[name="password"]').val(),
                };

                $.ajax({
                    url: '/api/v1/login',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(credentials),
                    success: function(res) {
                        console.log(res);
                        // Store token
                        localStorage.setItem('access_token', res.token);

                        // ✅ ADMIN CHECK
                        if (res.is_admin === true) {
                            $('#alert')
                                .removeClass('hidden bg-red-500')
                                .addClass('bg-green-500')
                                .text('✅ Admin login successful. Redirecting...');

                            setTimeout(() => {
                                window.location.href = '/';
                            }, 800);

                            return; // ⛔ stop further execution
                        }

                        // Check profile status
                        $.ajax({
                            url: '/api/v1/user/profile-status',
                            method: 'GET',
                            headers: {
                                'Authorization': 'Bearer ' + res.token
                            },
                            success: function(profileRes) {
                                if (!profileRes.status) {
                                    $('#alert')
                                        .removeClass('hidden bg-red-500')
                                        .addClass('bg-yellow-500')
                                        .text(
                                            '⛔ Please complete your donor profile. Redirecting...'
                                        );
                                    setTimeout(() => {
                                        window.location.href =
                                            '/donor-registration';
                                    }, 1200);
                                } else {
                                    localStorage.setItem('donor-reg', true);
                                    $('#alert')
                                        .removeClass('hidden bg-red-500')
                                        .addClass('bg-green-500')
                                        .text('✅ Login successful. Redirecting...');
                                    setTimeout(() => {
                                        window.location.href = '/';
                                    }, 1000);
                                }
                            },
                            error: function() {
                                alert('Failed to verify profile status.');
                            }
                        });
                    },
                    error: function(err) {
                        const message = err.responseJSON?.message || 'Login failed ❌';
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
