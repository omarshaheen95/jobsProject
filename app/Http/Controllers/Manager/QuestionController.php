<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionOption;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:questions list', ['only' => ['index']]);
//        $this->middleware('permission:add question', ['only' => ['create','store']]);
//        $this->middleware('permission:edit question', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete question', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $type = $request->get('question_type', false);
            $rows = Question::query()->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->toDateTimeString();
                })
                ->addColumn('type', function ($row) {
                    return $row->type_name;
                })
                ->addColumn('actions', function ($row) {
                    $edit_url = route('manager.question.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })
                ->make();
        }
        $title = 'قائمة الأسئلة';
        return view('manager.question.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة سؤال';
        return view('manager.question.edit', compact('title'));
    }

    public function store(QuestionRequest $request)
    {
        $data = $request->validated();
        $question = Question::query()->create($data);
        $result = $request->get('result', []);
        foreach ($request->get('option',[]) as $key => $option) {
            if (!is_null($option)) {
                QuestionOption::query()->create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'result' => $result[$key] ?? '0',
                ]);
            }
        }
        return redirect()->route('manager.question.index')->with('message', 'تم الإضافة بنجاح');
    }

    public function edit(Question $question)
    {
        $title = 'تعديل السؤال';
        return view('manager.question.edit', compact('question', 'title'));
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->validated();
        $result = $request->get('result', []);
        $old_result = $request->get('old_result', []);
        $question->update($data);
        foreach ($request->get('option',[]) as $key => $option) {
            if (!is_null($option)) {
                QuestionOption::query()->create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'result' => $result[$key] ?? '0',
                ]);
            }
        }

        foreach ($request->get('old_option',[]) as $key => $new_option) {
                if (!is_null($new_option)) {
                    $old_option = QuestionOption::query()->find($key);
                    if ($old_option) {
                        $old_option->update([
                            'question_id' => $question->id,
                            'option' => $new_option,
                            'result' => $old_result[$key] ?? '0',
                        ]);
                    }
                }
            }
        return redirect()->route('manager.question.index')->with('message', 'تم التحديث بنجاح');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('manager.question.index')->with('message', 'تم الحذف بنجاح');
    }

    public function deleteOption($id)
    {
        $option = QuestionOption::query()->findOrFail($id);
        $option->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
