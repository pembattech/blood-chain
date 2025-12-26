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

<body class="min-h-screen">

    {{-- Main Content --}}
    <main class="flex justify-center items-center min-h-screen">
        @yield('content')
    </main>

    @stack('scripts')

</body>

</html>
