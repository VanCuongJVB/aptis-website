<x-layouts.base :title="$quiz->title">
    @php
        $attemptId = session('attempt_id');
    @endphp

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ $quiz->title }} ({{ strtoupper($quiz->skill) }})</h1>
        <div id="timer" class="text-lg font-mono"></div>
    </div>

    @if (!$attemptId)
        <div class="bg-white rounded p-4 shadow">
            <p class="mb-3 text-gray-700">Thời lượng: {{ $quiz->duration_minutes }} phút.</p>
            <form method="POST" action="{{ route('quiz.start', $quiz) }}">
                @csrf
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Bắt đầu làm</button>
            </form>
        </div>
    @else
        <form method="POST" action="{{ route('quiz.submit', $quiz) }}">
            @csrf
            <input type="hidden" name="attempt_id" value="{{ $attemptId }}">
            <div class="space-y-6">
                @foreach ($quiz->questions as $q)
                    <div class="bg-white rounded p-4 shadow">
                        <div class="mb-2 font-medium">Câu {{ $loop->iteration }}.</div>
                        @if ($quiz->skill === 'listening' && $q->audio_path)
                            <audio controls {{ $quiz->allow_seek ? '' : 'controlsList=noplaybackrate' }}
                                data-listens="{{ $quiz->listens_allowed ?? 1 }}" class="mb-3 w-full">
                                <source src="{{ Storage::url($q->audio_path) }}">
                            </audio>
                        @endif
                        <div class="mb-2">{!! nl2br(e($q->stem)) !!}</div>
                        @if ($q->type === 'single')
                            @foreach ($q->options as $opt)
                                <label class="block">
                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->id }}">
                                    <span>{{ $opt->label }}</span>
                                </label>
                            @endforeach
                        @else
                            @foreach ($q->options as $opt)
                                <label class="block">
                                    <input type="checkbox" name="q_{{ $q->id }}[]" value="{{ $opt->id }}">
                                    <span>{{ $opt->label }}</span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Nộp bài</button>
            </div>
        </form>

        <script>
            // Simple timer (client-side only)
            (function() {
                const minutes = {{ (int) $quiz->duration_minutes }};
                const end = Date.now() + minutes * 60 * 1000;
                const el = document.getElementById('timer');
                const tick = () => {
                    const left = Math.max(0, end - Date.now());
                    const m = Math.floor(left / 60000);
                    const s = Math.floor((left % 60000) / 1000);
                    el.textContent = m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                    if (left <= 0) {
                        document.forms[0].submit();
                    } else {
                        setTimeout(tick, 250);
                    }
                };
                tick();
            })();

            // Limit listens (basic)
            document.querySelectorAll('audio[data-listens]').forEach(a => {
                let remains = parseInt(a.dataset.listens || '1', 10);
                a.addEventListener('play', () => {
                    if (a._playedOnce) {
                        remains--;
                    }
                    a._playedOnce = true;
                    if (remains <= 0) {
                        a.pause();
                        a.controls = false;
                    }
                });
            });
        </script>
    @endif
</x-layouts.base>
