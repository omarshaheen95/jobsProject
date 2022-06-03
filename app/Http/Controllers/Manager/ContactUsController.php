<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Governorate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('search', false);
            $governorate_id = $request->get('governorate_id', false);
            $rows = ContactUs::query()
                ->with(['governorate'])
                ->when($search, function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('mobile', 'like', '%' . $search . '%');
                })
                ->when($governorate_id, function (Builder $query) use ($governorate_id) {
                    $query->where('governorate_id', $governorate_id);
                })->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->toDateTimeString();
                })
                ->addColumn('status', function ($row) {
                    return $row->seen ? 'مقروء' : 'غير مقروء';
                })
                ->addColumn('governorate', function ($row) {
                    return $row->governorate->name;
                })
                ->addColumn('actions', function ($row) {
                    $show_url = route('manager.contact_us.show', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'show_url'));
                })
                ->make();
        }
        $title = 'عرض اتصل بنا';
        $governorates = Governorate::query()->get();
        return view('manager.contact_us.index', compact('title', 'governorates'));
    }

    public function show($id)
    {
        $contact = ContactUs::query()->findOrFail($id);
        $title = 'عرض اتصل بنا';
        if (!$contact->seen) {
            $contact->update([
                'seen' => 1
            ]);
        }
        return view('manager.contact_us.show', compact('contact', 'title'));
    }

    public function destroy($id)
    {
        $contact = ContactUs::query()->findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', 'تم الحذف بنجاح');
    }
}
