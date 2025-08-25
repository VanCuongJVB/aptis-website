<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Quiz, Attempt, AttemptItem, Question, Option};

class QuizPlayController extends Controller
{
    public function show(Quiz $quiz)
    {
        abort_unless($quiz->is_published, 404);
        return view('student.quiz.show', compact('quiz'));
    }

    public function start(Request $request, Quiz $quiz)
    {
        $attempt = Attempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
        ]);
        return redirect()->route('quiz.show', $quiz)->with('attempt_id', $attempt->id);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $attemptId = $request->input('attempt_id');
        $attempt = Attempt::where('id', $attemptId)->where('user_id', Auth::id())->firstOrFail();

        $total = 0; $correct = 0;
        foreach ($quiz->questions as $q) {
            $total++;
            $selected = $request->input('q_'.$q->id, []);
            if (!is_array($selected)) $selected = [$selected];

            $correctSet = $q->options()->where('is_correct', true)->pluck('id')->sort()->values()->all();
            $selectedSet = collect($selected)->map(fn($x)=>(int)$x)->sort()->values()->all();

            $isCorrect = ($selectedSet === $correctSet);
            if ($isCorrect) $correct++;

            AttemptItem::create([
                'attempt_id' => $attempt->id,
                'question_id'=> $q->id,
                'selected_option_ids' => $selectedSet,
                'is_correct' => $isCorrect,
                'time_spent_sec' => 0,
            ]);
        }
        $attempt->score_raw = $correct;
        $attempt->score_percent = $total > 0 ? round($correct*100.0/$total,2) : 0;
        $attempt->submitted_at = now();
        $attempt->save();

        return redirect()->route('quiz.result', $attempt);
    }

    public function result(Attempt $attempt)
    {
        // $this->authorize('view', $attempt); // will use default policy via user id check inline
        if ($attempt->user_id !== auth()->id()) abort(403);
        $attempt->load(['quiz.questions.options','items']);
        return view('student.quiz.result', compact('attempt'));
    }
}
