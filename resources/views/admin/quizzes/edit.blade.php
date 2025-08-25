<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Sửa bộ đề</h1>
  <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Tiêu đề</label>
      <input name="title" class="border rounded w-full p-2" value="{{ $quiz->title }}" required>
    </div>
    <div>
      <label class="block text-sm">Mô tả</label>
      <textarea name="description" class="border rounded w-full p-2">{{ $quiz->description }}</textarea>
    </div>
    <div>
      <label class="block text-sm">Thời lượng (phút)</label>
      <input type="number" name="duration_minutes" class="border rounded p-2" value="{{ $quiz->duration_minutes }}" min="5" max="180">
    </div>
    <div class="space-y-2">
      <div class="flex items-center gap-2">
        <input type="checkbox" name="allow_seek" id="allow_seek" {{ $quiz->allow_seek ? 'checked' : '' }}>
        <label for="allow_seek">Listening: Cho tua</label>
      </div>
      <div>
        <label class="block text-sm">Listening: Số lần nghe</label>
        <input type="number" name="listens_allowed" class="border rounded p-2" value="{{ $quiz->listens_allowed }}" min="1" max="3">
      </div>
    </div>
    <div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Lưu</button>
    </div>
  </form>
</x-layouts.base>
