<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - FastLan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .w-full {
            width: 100%;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .p-8 {
            padding: 2rem;
        }

        .text-center {
            text-align: center;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .w-20 {
            width: 5rem;
        }

        .h-20 {
            height: 5rem;
        }

        .bg-green-100 {
            background-color: #dcfce7;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .text-green-600 {
            color: #16a34a;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-gray-900 {
            color: #1a202c;
        }

        .text-gray-600 {
            color: #718096;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .bg-red-600 {
            background-color: #e53e3e;
        }

        .text-white {
            color: #ffffff;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: #e2e8f0;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .hover\:bg-red-700:hover {
            background-color: #c53030;
        }

        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .font-semibold {
            font-weight: 600;
        }

        .block {
            display: block;
        }

        a {
            text-decoration: none;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-green-600 text-3xl"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Thank You!</h1>
        
        <p class="text-gray-600 mb-6">
            Your feedback has been received. We truly appreciate you taking the time to help us improve FastLan.
        </p>

        <div class="space-y-4">
            @if(Auth::guard('passenger')->check())
                <a href="{{ route('passenger.dashboard') }}" class="block w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    Return to Dashboard
                </a>
            @elseif(Auth::guard('driver')->check())
                <a href="{{ route('driver.dashboard') }}" class="block w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    Return to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    Return to Login
                </a>
            @endif
            
            <a href="{{ url('/') }}" class="block w-full border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                Go to Homepage
            </a>
        </div>
    </div>
</body>
</html>