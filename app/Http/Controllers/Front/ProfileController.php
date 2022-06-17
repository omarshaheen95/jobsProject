<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserExperienceRequest;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserQualificationRequest;
use App\Http\Requests\UserSkillRequest;
use App\Models\Appreciation;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Governorate;
use App\Models\Qualification;
use App\Models\UserExperience;
use App\Models\UserQualification;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request, $step)
    {
        $user = Auth::user();
        switch ($step) {
            case 1:
                $governorates = Governorate::query()->get();
                $profile_title = 'البيانات الشخصية';
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'governorates', 'user'));
            case 2:
                $profile_title = 'الموهلات';

                $countries = Country::query()->get();
                $qualifications = Qualification::query()->get();
                $degrees = Degree::query()->get();
                $appreciations = Appreciation::query()->get();
                $user_qualifications = UserQualification::query()->where('user_id', Auth::guard('web')->id())
                    ->has('appreciation')
                    ->has('qualification')
                    ->has('degree')
                    ->has('sub_degree')
                    ->has('country')
                    ->with(['qualification', 'degree', 'sub_degree', 'country', 'appreciation'])->latest()->get();

                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user', 'countries', 'qualifications', 'degrees', 'appreciations',
                    'user_qualifications'));
            case 3:
                $profile_title = 'الخبرات';
                $user_skills = UserSkill::query()
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user', 'user_skills'));
            case 4:
                $profile_title = 'الدورات';
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user'));
            case 5:
                $profile_title = 'المهارات';
                $user_experiences = UserExperience::query()
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user', 'user_experiences'));
            case 6:
                $profile_title = 'اللغات';
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user'));
            case 7:
                $profile_title = 'الوضع الصحي';
                return view('website.profile.step_' . $step, compact('profile_title', 'step', 'user'));
            default:
                $profile_title = '';
                return view('website.profile.step_1', compact('profile_title'));
        }
    }

    public function updateProfile(UserInfoRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();

        $userInfo = $user->userInfo()->updateOrCreate($data);
        if ($request->hasFile('avatar')) {
            $userInfo->addMediaFromRequest('avatar')->toMediaCollection('users');
        }
        return $this->sendResponse(null, 'تم تحديث تسجيل البيانات بنجاح');
    }

    public function userQualification(UserQualificationRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();
        if ($request->get('id', false))
        {
            $u_q = UserQualification::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_q->update($data);
            $u_q->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_q = UserQualification::query()->create($data);
        }
        $row = view('website.profile.rows.user_qualification', compact('u_q'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل المؤهل بنجاح');
    }

    public function userQualificationDelete($id)
    {
        $user = Auth::guard('web')->user();
        $u_q = UserQualification::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف المؤهل بنجاح');
    }

    public function userExperience(UserExperienceRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();
        if ($request->get('id', false))
        {
            $u_e = UserExperience::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_e->update($data);
            $u_e->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_e = UserExperience::query()->create($data);
        }
        $row = view('website.profile.rows.user_experience', compact('u_e'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل المهارة بنجاح');
    }

    public function userExperienceDelete($id)
    {
        $user = Auth::guard('web')->user();
        UserExperience::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف المهارة بنجاح');
    }

    public function userSkill(UserSkillRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();

        if ($request->get('id', false))
        {
            $u_s = UserSkill::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_s->update($data);
            $u_s->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_s = UserSkill::query()->create($data);
        }
        $row = view('website.profile.rows.user_skill', compact('u_s'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل الخبرة بنجاح');
    }

    public function userSkillDelete($id)
    {
        $user = Auth::guard('web')->user();
        UserSkill::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف الخبرة بنجاح');
    }
}
