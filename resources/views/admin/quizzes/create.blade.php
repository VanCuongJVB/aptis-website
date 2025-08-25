<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Tạo bộ đề</h1>
  <form method="POST" action="{{ route('admin.quizzes.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Tiêu đề</label>
      <input name="title" class="border rounded w-full p-2" required>
    </div>
    <div>
      <label class="block text-sm">Kỹ năng</label>
      <select name="skill" class="border rounded p-2">
        <option value="reading">Reading</option>
        <option value="listening">Listening</option>
      </select>
    </div>
    <div>
      <label class="block text-sm">Mô tả</label>
      <textarea name="description" class="border rounded w-full p-2"></textarea>
    </div>
    <div>
      <label class="block text-sm">Thời lượng (phút)</label>
      <input type="number" name="duration_minutes" class="border rounded p-2" value="45" min="5" max="180">
    </div>
    <div x-data="{skill:'reading'}" class="space-y-2">
      <div class="flex items-center gap-2">
        <input type="checkbox" name="allow_seek" id="allow_seek">
        <label for="allow_seek">Listening: Cho tua (nếu để trống là khóa tua)</label>
      </div>
      <div>
        <label class="block text-sm">Listening: Số lần nghe</label>
        <input type="number" name="listens_allowed" class="border rounded p-2" value="1" min="1" max="3">
      </div>
    </div>
    <div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Lưu</button>
    </div>
  </form>
</x-layouts.base>
