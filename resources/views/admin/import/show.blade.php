<x-layouts.base>
  <h1 class="text-xl font-semibold mb-4">Import học sinh (CSV)</h1>
  <div class="bg-white rounded p-4 shadow">
    <p class="text-sm text-gray-700 mb-3">CSV mẫu (có header):</p>
<pre class="bg-gray-50 p-2 rounded text-sm overflow-auto">email,name,access_start,access_end
hs1@example.com,Nguyen A,2025-09-01,2025-11-30</pre>

    <form method="POST" action="{{ route('admin.import.do') }}" enctype="multipart/form-data" class="mt-4">
      @csrf
      <input type="file" name="csv" accept=".csv" class="border rounded p-2">
      <button class="ml-2 bg-blue-600 text-white px-3 py-1 rounded">Tải lên</button>
    </form>
  </div>
</x-layouts.base>
