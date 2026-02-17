<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - P2H Sawit System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border-t-8 border-green-700">
        
        <div class="p-8 text-center bg-gray-50 border-b">
            <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
                <i class="fas fa-tractor fa-3x text-green-700"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight">P2H SYSTEM</h1>
            <p class="text-sm text-gray-500 font-medium">Monitoring Alat Berat & Kendaraan</p>
        </div>

        <div class="p-8">
            <form action="{{route('auth.process')}}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Nomor Identitas</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input type="text" name="username" placeholder="Masukkan ID Anda" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-xs text-gray-600">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-green-700 hover:underline">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-black py-4 rounded-lg shadow-lg shadow-yellow-200 transition transform active:scale-95 flex items-center justify-center space-x-2">
                    <span>MASUK KE SISTEM</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

            </form>
        </div>

        <div class="p-4 bg-gray-50 text-center border-t">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                &copy; 2026 PT. Perkebunan Mandiri v2.0
            </p>
        </div>
    </div>

</body>
</html>