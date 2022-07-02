<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\NewsRequest;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('title', false);
            $rows = News::query()
                ->when($search, function (Builder $query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('actions', function ($row) {
                    $edit_url = route('manager.news.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الأخبار';
        return view('manager.news.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة خبر';
        return view('manager.news.edit', compact('title'));
    }

    public function store(NewsRequest $request)
    {
        $data = $request->validated();

        $data['special'] = $request->get('special', false);
        $news = News::query()->create($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $news
                ->addMediaFromRequest('image')
//                ->withResponsiveImages()
                ->toMediaCollection('news');
        }

        return $this->redirectWith(false, 'manager.news.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل خبر';
        $news = News::query()->findOrFail($id);
        return view('manager.news.edit', compact('news', 'title'));
    }

    public function update(NewsRequest $request, $id)
    {
        $data = $request->validated();
        $news = News::query()->findOrFail($id);
        $data['special'] = $request->get('special', false);
        $news->update($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $news
                ->addMediaFromRequest('image')
//                ->withResponsiveImages()
                ->toMediaCollection('news');
        }

        return $this->redirectWith(false, 'manager.news.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $news = News::query()->findOrFail($id);
        $news->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
