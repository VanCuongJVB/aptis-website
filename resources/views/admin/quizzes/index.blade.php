<x-layouts.base>
  <div class="flex justify-between mb-4 items-center">
    <h1 class="text-xl font-semibold">Bộ đề</h1>
    <a href="{{ route('admin.quizzes.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Tạo bộ đề</a>
  </div>
  <div class="bg-white rounded shadow divide-y">
    @foreach($quizzes as $q)
      <div class="p-4 flex justify-between items-center">
        <div>
          <div class="text-sm text-gray-500 uppercase">{{ strtoupper($q->skill) }}</div>
          <div class="font-medium">{{ $q->title }}</div>
          <div class="text-sm text-gray-600">Thời lượng: {{ $q->duration_minutes }} phút</div>
        </div>
        <div class="flex gap-2">
          <a class="text-sm text-blue-600" href="{{ route('admin.questions.index', $q) }}">Câu hỏi</a>
          <a class="text-sm" href="{{ route('admin.quizzes.edit', $q) }}">Sửa</a>
          <form method="POST" action="{{ route('admin.quizzes.toggle', $q) }}">
            @csrf
            <button class="text-sm {{ $q->is_published ? 'text-green-600' : 'text-gray-600' }}">
              {{ $q->is_published ? 'Đang publish' : 'Chưa publish' }}
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</x-layouts.base>
