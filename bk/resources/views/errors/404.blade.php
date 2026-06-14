@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-indigo-100 px-4">

    <div class="text-center backdrop-blur-lg bg-white/70 shadow-2xl rounded-2xl p-10 max-w-xl w-full border border-gray-200">

        <!-- Animated Icon -->
        <div class="flex justify-center mb-6">
            <div class="animate-bounce">
                <svg width="300" height="300" class=" text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.172 9.172a4 4 0 115.656 5.656M15 15l4 4m-6-6l-4 4" />
                </svg>
            </div>
        </div>
        <!-- 404 Text -->
        <h1 class="text-7xl font-extrabold text-gray-800 tracking-tight">404</h1>
        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-700 mt-2">
            Oops! Page not found
        </h2>
        <!-- Description -->
        <p class="text-gray-500 mt-4 leading-relaxed">
            The page you're looking for doesn’t exist or has been moved.
            Try searching or go back to homepage.
        </p>
        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8 mb-3">
            <a href="{{ front_route('home.index') ?? '/' }}"
               class="px-6 py-3 bg-indigo-600">
                 Back Home
            </a> | 
            <a href="{{ front_route('products.index') ?? '/shop' }}"
               class="px-6 py-3">
                 Continue Shopping
            </a>
        </div>

    </div>

</div>
@endsection