<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Bảng điều khiển Admin</h1>
  <div class="grid md:grid-cols-2 gap-4">
    <a class="block bg-white p-4 rounded shadow" href="{{ route('admin.quizzes.index') }}">Quản lý bộ đề</a>
    <a class="block bg-white p-4 rounded shadow" href="{{ route('admin.import.show') }}">Import học sinh (CSV)</a>
  </div>
</x-layouts.base>
