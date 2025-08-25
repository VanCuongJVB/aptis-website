<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Câu hỏi — {{ $quiz->title }}</h1>

  <div class="bg-white rounded shadow p-4 mb-6">
    <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" enctype="multipart/form-data" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm">Thứ tự</label>
        <input name="order" type="number" class="border rounded p-2" value="{{ ($quiz->questions->max('order') ?? 0)+1 }}">
      </div>
      <div>
        <label class="block text-sm">Loại</label>
        <select name="type" class="border rounded p-2">
          <option value="single">Trắc nghiệm 1 đáp án</option>
          <option value="multi">Trắc nghiệm nhiều đáp án</option>
        </select>
      </div>
      @if($quiz->skill === 'listening')
      <div>
        <label class="block text-sm">Audio (mp3/wav/m4a/ogg)</label>
        <input type="file" name="audio" class="border rounded p-2">
      </div>
      @endif
      <div>
        <label class="block text-sm">Nội dung câu hỏi</label>
        <textarea name="stem" class="border rounded w-full p-2" required></textarea>
      </div>
      <div class="grid md:grid-cols-2 gap-2">
        <div class="border rounded p-2">
          <div class="text-sm text-gray-600 mb-1">Phương án 1</div>
          <input name="options[0][label]" class="border rounded w-full p-2">
          <label class="flex items-center gap-2 mt-1 text-sm"><input type="checkbox" name="options[0][is_correct]"> Đáp án đúng</label>
        </div>
        <div class="border rounded p-2">
          <div class="text-sm text-gray-600 mb-1">Phương án 2</div>
          <input name="options[1][label]" class="border rounded w-full p-2">
          <label class="flex items-center gap-2 mt-1 text-sm"><input type="checkbox" name="options[1][is_correct]"> Đáp án đúng</label>
        </div>
      </div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Thêm câu hỏi</button>
    </form>
  </div>

  <div class="bg-white rounded shadow divide-y">
    @foreach($quiz->questions as $q)
      <div class="p-4">
        <div class="flex justify-between">
          <div>
            <div class="text-sm text-gray-500">#{{ $q->order }} • {{ $q->type }}</div>
            <div class="font-medium">{{ Str::limit($q->stem, 120) }}</div>
            @if($q->audio_path)
              <audio class="mt-2" controls src="{{ Storage::url($q->audio_path) }}"></audio>
            @endif
          </div>
          <div class="flex items-start gap-3">
            <a href="{{ route('admin.questions.edit', $q) }}" class="text-sm">Sửa</a>
            <form method="POST" action="{{ route('admin.questions.delete', $q) }}">
              @csrf
              <button class="text-sm text-red-600">Xóa</button>
            </form>
          </div>
        </div>

        <ul class="mt-2 list-disc ml-5">
          @foreach($q->options as $opt)
            <li class="{{ $opt->is_correct ? 'font-bold' : '' }}">{{ $opt->label }}</li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
</x-layouts.base>
