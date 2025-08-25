<x-layouts.base>
    <h1 class="text-xl font-semibold mb-3">Kết quả</h1>
    <div class="bg-white rounded p-4 shadow">
        <div class="mb-2">Bài: {{ $attempt->quiz->title }}</div>
        <div class="mb-2">Điểm: <b>{{ $attempt->score_raw }}</b> ({{ $attempt->score_percent }}%)</div>
        <div class="text-sm text-gray-600">Bắt đầu: {{ $attempt->started_at }}, Nộp: {{ $attempt->submitted_at }}</div>
    </div>

    <div class="mt-6 space-y-4">
        @foreach ($attempt->quiz->questions as $q)
            @php
                $it = $attempt->items->firstWhere('question_id', $q->id);
                $selected = collect($it?->selected_option_ids ?? []);
            @endphp
            <div class="bg-white rounded p-4 shadow">
                <div class="font-medium">Câu {{ $loop->iteration }} — {!! $it && $it->is_correct
                    ? '<span class="text-green-600">Đúng</span>'
                    : '<span class="text-red-600">Sai</span>' !!}</div>
                <div class="mt-1 text-gray-700">{!! nl2br(e($q->stem)) !!}</div>
                <ul class="mt-2 list-disc ml-5">
                    @foreach ($q->options as $opt)
                        <li class="{{ $opt->is_correct ? 'font-bold' : '' }}">
                            {{ $opt->label }}
                            @if ($selected->contains($opt->id))
                                <span class="text-blue-600">(bạn chọn)</span>
                            @endif
                            @if ($opt->is_correct)
                                <span class="text-green-600">(đáp án)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-layouts.base>
