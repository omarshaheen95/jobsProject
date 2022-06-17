<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request,$step)
    {
        $user = Auth::user();
        $user_info = $user->userInfo;
        switch ($step)
        {
            case 1:
                $governorates = Governorate::query()->get();
                $profile_title = 'البيانات الشخصية';
                return view('website.profile.step_'.$step, compact('profile_title', 'step', 'governorates'));
            case 2:
                $profile_title = 'الموهلات';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            case 3:
                $profile_title = 'الخبرات';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            case 4:
                $profile_title = 'الدورات';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            case 5:
                $profile_title = 'المهارات';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            case 6:
                $profile_title = 'اللغات';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            case 7:
                $profile_title = 'الوضع الصحي';
                return view('website.profile.step_'.$step, compact('profile_title', 'step'));
            default:
                $profile_title = '';
                return view('website.profile.step_1', compact('profile_title'));
        }
    }
}
