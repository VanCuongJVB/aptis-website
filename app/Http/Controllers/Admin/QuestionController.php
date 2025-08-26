<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Quiz, Question, Option};

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('admin.questions.index', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $maxPart = $quiz->partCount();
        $data = $request->validate([
            'stem'  => 'required|string',
            'type'  => 'required|in:single,multi',
            'order' => 'required|integer|min:1',
            'part'  => "required|integer|min:1|max:$maxPart",
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:10240',
            'options' => 'required|array|min:2',
            'options.*.label' => 'required|string',
            'options.*.is_correct' => 'nullable|boolean',
        ]);

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('public/audio');
        }

        $q = Question::create([
            'quiz_id' => $quiz->id,
            'stem'    => $data['stem'],
            'type'    => $data['type'],
            'order'   => $data['order'],
            'part'    => $data['part'],
            'audio_path' => $audioPath,
        ]);

        foreach ($data['options'] as $i => $opt) {
            Option::create([
                'question_id' => $q->id,
                'label' => $opt['label'],
                'is_correct' => isset($opt['is_correct']) ? (bool)$opt['is_correct'] : false,
                'order' => $i+1,
            ]);
        }

        return back()->with('ok','Đã thêm câu hỏi');
    }

    public function edit(Question $question)
    {
        $question->load('quiz','options');
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $maxPart = $question->quiz->partCount();
        $data = $request->validate([
            'stem'  => 'required|string',
            'type'  => 'required|in:single,multi',
            'order' => 'required|integer|min:1',
            'part'  => "required|integer|min:1|max:$maxPart",
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:10240',
            'options' => 'required|array|min:2',
            'options.*.id' => 'nullable|integer',
            'options.*.label' => 'required|string',
            'options.*.is_correct' => 'nullable|boolean',
        ]);

        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('public/audio');
            $question->audio_path = $audioPath;
        }
        $question->stem  = $data['stem'];
        $question->type  = $data['type'];
        $question->order = $data['order'];
        $question->part  = $data['part'];
        $question->save();

        // sync options (simplified: delete then re-create)
        $question->options()->delete();
        foreach ($data['options'] as $i => $opt) {
            $question->options()->create([
                'label' => $opt['label'],
                'is_correct' => isset($opt['is_correct']) ? (bool)$opt['is_correct'] : false,
                'order' => $i+1,
            ]);
        }

        return back()->with('ok','Cập nhật câu hỏi');
    }

    public function destroy(Question $question)
    {
        $quiz = $question->quiz;
        $question->options()->delete();
        $question->delete();
        return redirect()->route('admin.questions.index', $quiz)->with('ok','Đã xóa câu hỏi');
    }
}
