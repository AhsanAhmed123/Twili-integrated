@extends('frontend.layout')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
   <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-highlight {
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }
        .input-highlight:focus {
            border-bottom: 2px solid #667eea;
            box-shadow: none;
        }
        .social-btn {
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-3px);
        }
        .floating-label {
            transition: all 0.3s ease;
            transform: translateY(0);
            opacity: 1;
        }
        .floating-label.hidden {
            transform: translateY(-20px);
            opacity: 0;
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="font-sans bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="gradient-bg text-white rounded-t-2xl p-8 text-center shadow-lg">
                <h1 class="text-3xl font-bold mb-2">Welcome Back</h1>
                <p class="opacity-90">Sign in to access your account</p>
                {{-- <div class="mt-6 flex justify-center space-x-4">
                    <button class="social-btn bg-white text-blue-600 p-3 rounded-full hover:shadow-md">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="social-btn bg-white text-red-500 p-3 rounded-full hover:shadow-md">
                        <i class="fab fa-google"></i>
                    </button>
                    <button class="social-btn bg-white text-blue-400 p-3 rounded-full hover:shadow-md">
                        <i class="fab fa-twitter"></i>
                    </button>
                </div> --}}
            </div>
            
            <div class="bg-white rounded-b-2xl shadow-lg px-8 pt-6 pb-8">
                <form id="loginForm" action="{{ route('Auth.login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="relative">
                        <label for="email" class="floating-label text-gray-600 text-sm font-medium absolute left-0 -top-5">User Name</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                            <input id="email" name="email" type="email"  class="input-highlight w-full pl-10 pr-4 py-3 border-b border-gray-300 focus:outline-none" placeholder="Enter your User name" required>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <label for="password" class="floating-label text-gray-600 text-sm font-medium absolute left-0 -top-5">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                            <input id="password" name="password" type="password" class="input-highlight w-full pl-10 pr-4 py-3 border-b border-gray-300 focus:outline-none" placeholder="Enter your password" required>
                            <button type="button" id="togglePassword" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        {{-- <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a> --}}
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-medium hover:opacity-90 transition duration-300 shadow-md hover:shadow-lg">
                            Sign In
                        </button>
                    </div>
                </form>
                
                {{-- <div class="mt-6 text-center">
                    <p class="text-gray-600">Don't have an account? <a href="#" class="text-indigo-600 font-medium hover:text-indigo-500">Sign up</a></p>
                </div> --}}
            </div>
        </div>
    </div>
@endsection


</body>
</html>