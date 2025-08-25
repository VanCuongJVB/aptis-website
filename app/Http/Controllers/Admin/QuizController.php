<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Quiz, Question, Option};

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderBy('created_at','desc')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'skill' => 'required|in:reading,listening',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'allow_seek' => 'nullable|boolean',
            'listens_allowed' => 'nullable|integer|min:1|max:3',
        ]);
        $data['is_published'] = false;
        $data['allow_seek'] = $request->boolean('allow_seek', false);
        $data['listens_allowed'] = $request->input('listens_allowed', 1);
        $quiz = Quiz::create($data);
        return redirect()->route('admin.questions.index', $quiz)->with('ok','Tạo đề thành công, hãy thêm câu hỏi');
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'allow_seek' => 'nullable|boolean',
            'listens_allowed' => 'nullable|integer|min:1|max:3',
        ]);
        $data['allow_seek'] = $request->boolean('allow_seek', false);
        $quiz->update($data);
        return back()->with('ok','Cập nhật thành công');
    }

    public function togglePublish(Quiz $quiz)
    {
        $quiz->is_published = !$quiz->is_published;
        $quiz->save();
        return back()->with('ok', $quiz->is_published ? 'Đã publish' : 'Đã unpublish');
    }
}
