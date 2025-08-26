<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Sửa câu hỏi</h1>
  <form method="POST" action="{{ route('admin.questions.update', $question) }}" enctype="multipart/form-data" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Thứ tự</label>
      <input name="order" type="number" class="border rounded p-2" value="{{ $question->order }}">
    </div>
    <div>
      <label class="block text-sm">Part</label>
      @php $partCount = $question->quiz->partCount(); @endphp
      <select name="part" class="border rounded p-2">
        @for($i=1;$i<=$partCount;$i++)
          <option value="{{ $i }}" @selected($question->part==$i)>Part {{ $i }}</option>
        @endfor
      </select>
    </div>
    <div>
      <label class="block text-sm">Loại</label>
      <select name="type" class="border rounded p-2">
        <option value="single" @selected($question->type==='single')>Trắc nghiệm 1 đáp án</option>
        <option value="multi" @selected($question->type==='multi')>Trắc nghiệm nhiều đáp án</option>
      </select>
    </div>
    @if($question->quiz->skill === 'listening')
    <div>
      <label class="block text-sm">Audio (mp3/wav/m4a/ogg)</label>
      <input type="file" name="audio" class="border rounded p-2">
    </div>
    @endif
    <div>
      <label class="block text-sm">Nội dung câu hỏi</label>
      <textarea name="stem" class="border rounded w-full p-2" required>{{ $question->stem }}</textarea>
    </div>

    <div id="options-container" class="grid md:grid-cols-2 gap-2">
      @foreach($question->options as $i => $opt)
        <div class="border rounded p-2">
          <div class="text-sm text-gray-600 mb-1">Phương án {{ $i+1 }}</div>
          <input type="hidden" name="options[{{ $i }}][id]" value="{{ $opt->id }}">
          <input name="options[{{ $i }}][label]" class="border rounded w-full p-2" value="{{ $opt->label }}">
          <label class="flex items-center gap-2 mt-1 text-sm"><input type="checkbox" name="options[{{ $i }}][is_correct]" @checked($opt->is_correct)> Đáp án đúng</label>
        </div>
      @endforeach
    </div>

    <div class="flex gap-2">
      <button type="button" id="add-option" class="px-3 py-1 border rounded">Thêm phương án</button>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Lưu</button>
    </div>
  </form>
  <script>
    document.getElementById('add-option').addEventListener('click', function () {
      const container = document.getElementById('options-container');
      const index = container.children.length;
      const wrapper = document.createElement('div');
      wrapper.className = 'border rounded p-2';
      wrapper.innerHTML = `<div class="text-sm text-gray-600 mb-1">Phương án ${index + 1}</div>` +
        `<input name="options[${index}][label]" class="border rounded w-full p-2">` +
        `<label class="flex items-center gap-2 mt-1 text-sm"><input type="checkbox" name="options[${index}][is_correct]"> Đáp án đúng</label>`;
      container.appendChild(wrapper);
    });
  </script>
</x-layouts.base>
