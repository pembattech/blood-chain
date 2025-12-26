<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blood Chain')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Inter', sans-serif;
        }

        .gradient-header {
            background: linear-gradient(135deg, #1d3557 0%, #457b9d 100%);
        }

        .sidebar-shadow {
            box-shadow: 4px 0px 15px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>

    @stack('styles')
</head>

<body class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white sidebar-shadow fixed h-full z-20">
        <div class="p-6 relative h-full flex flex-col">
            <div class="flex items-center gap-2 text-red-600 font-bold text-xl mb-10">
                <i class="fa-solid fa-droplet text-2xl"></i>
                <span>Blood Chain</span>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-solid fa-table-columns"></i> Dashboard
                </a>

                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-solid fa-user"></i> Profile
                </a>

                <a href="{{ route('requests') }}"
                    class="flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg justify-between">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-list-check"></i> Requests
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>

                <a href="{{ route('donors') }}"
                    class="flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-solid fa-users"></i> Donors
                </a>

                <a href="{{ route('notifications') }}"
                    class="flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg">
                    <i class="fa-solid fa-bell"></i> Notifications
                </a>


            </nav>
            <div class="absolute bottom-4">
                <button id="logout-btn"
                    class="w-auto flex items-center gap-3 text-gray-500 hover:bg-gray-100 p-3 rounded-lg transition">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </button>
            </div>


        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 ml-64">
        @yield('content')
    </main>

    @stack('scripts')


    <script>
        // const apiToken = "{{ env('API_TOKEN') }}";
        const apiToken = localStorage.getItem('access_token');

        // Set up global AJAX defaults
        $.ajaxSetup({
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + apiToken
            }
        });

            document.getElementById('logout-btn').addEventListener('click', function() {
                // Remove token from localStorage
                localStorage.removeItem('access_token');

                // Optional: redirect to login page
                window.location.href = "{{ route('login') }}";
            });
    </script>
</body>

</html>
