<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Aptis Lite' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
<nav class="bg-white border-b">
  <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
    <a href="{{ route('student.home') }}" class="font-semibold">Aptis Lite</a>
    <div class="flex gap-4 items-center">
      @auth
        @if(auth()->user()->is_admin)
          <a class="text-sm" href="{{ route('admin.home') }}">Admin</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="text-sm text-red-600">Đăng xuất</button>
        </form>
      @endauth
      @guest
        <a href="{{ route('login') }}">Đăng nhập</a>
      @endguest
    </div>
  </div>
</nav>
<main class="max-w-5xl mx-auto px-4 py-6">
    @if(session('ok'))
      <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
    @endif
    @if(session('err'))
      <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">{{ session('err') }}</div>
    @endif
    {{ $slot }}
</main>
</body>
</html>
