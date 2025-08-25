<x-layouts.base>
  <h1 class="text-2xl font-bold mb-4">Bộ đề khả dụng</h1>
  <div class="grid gap-4 md:grid-cols-2">
    @foreach($quizzes as $q)
      <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-500 uppercase">{{ strtoupper($q->skill) }}</div>
        <div class="text-lg font-semibold">{{ $q->title }}</div>
        <div class="text-gray-600 mb-2">{{ $q->description }}</div>
        <div class="text-sm">Thời lượng: {{ $q->duration_minutes }} phút</div>
        <form method="POST" action="{{ route('quiz.start', $q) }}" class="mt-3">
          @csrf
          <a href="{{ route('quiz.show', $q) }}" class="inline-block text-blue-600 text-sm">Xem</a>
          <button class="ml-3 inline-block bg-blue-600 text-white text-sm px-3 py-1 rounded">Bắt đầu</button>
        </form>
      </div>
    @endforeach
  </div>
</x-layouts.base>
