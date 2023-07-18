<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserCourseRequest;
use App\Http\Requests\UserDisabilityRequest;
use App\Http\Requests\UserExperienceRequest;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserLanguageRequest;
use App\Http\Requests\UserQualificationRequest;
use App\Http\Requests\UserSkillRequest;
use App\Models\Appreciation;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Disability;
use App\Models\Governorate;
use App\Models\Language;
use App\Models\Qualification;
use App\Models\UserCourse;
use App\Models\UserDisability;
use App\Models\UserExperience;
use App\Models\UserLanguage;
use App\Models\UserQualification;
use App\Models\UserSkill;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(Request $request, $step)
    {
        $user = Auth::user();
        switch ($step) {
            case 'general':
                $governorates = Governorate::query()->active()->get();
                $profile_title = 'البيانات الشخصية';
                return view('website.profile.step_1', compact('profile_title', 'step', 'governorates', 'user'));
            case 'qualifications':
                $profile_title = 'الموهلات';

                $countries = Country::query()->active()->get();
                $qualifications = Qualification::query()->active()->get();
                $degrees = Degree::query()->active()->get();
                $appreciations = Appreciation::query()->active()->get();
                $user_qualifications = UserQualification::query()->where('user_id', Auth::guard('web')->id())
                    ->has('appreciation')
                    ->has('qualification')
                    ->has('degree')
                    ->has('sub_degree')
                    ->has('country')
                    ->with(['qualification', 'degree', 'sub_degree', 'country', 'appreciation'])->latest()->get();

                return view('website.profile.step_2', compact('profile_title', 'step', 'user', 'countries', 'qualifications', 'degrees', 'appreciations',
                    'user_qualifications'));
            case 'skills':
                $profile_title = 'الخبرات';
                $user_skills = UserSkill::query()
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                return view('website.profile.step_3', compact('profile_title', 'step', 'user', 'user_skills'));
            case 'courses':
                $profile_title = 'الدورات';
                $user_courses = UserCourse::query()
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                return view('website.profile.step_4', compact('profile_title', 'step', 'user', 'user_courses'));
            case 'experiences':
                $profile_title = 'المهارات';
                $user_experiences = UserExperience::query()
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                return view('website.profile.step_5', compact('profile_title', 'step', 'user', 'user_experiences'));
            case 'languages':
                $profile_title = 'اللغات';
                $user_languages = UserLanguage::query()->with('language')
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                $languages = Language::query()->active()->get();
                return view('website.profile.step_6', compact('profile_title', 'step', 'user', 'user_languages', 'languages'));
            case 'disabilities':
                $profile_title = 'الوضع الصحي';
                $user_disabilities = UserDisability::query()->with('disability')
                    ->where('user_id', Auth::guard('web')->id())
                    ->get();
                $disabilities = Disability::query()->active()->get();
                return view('website.profile.step_7', compact('profile_title', 'step', 'user', 'user_disabilities', 'disabilities'));
            default:
                $profile_title = '';
                return view('website.profile.step_1', compact('profile_title'));
        }
    }

    public function updateProfile(UserInfoRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();
//        dd($data);

        $userInfo = $user->userInfo()->updateOrCreate(['user_id' => $user->id],$data)->save();
        if ($request->hasFile('avatar')) {
            $user->userInfo->addMediaFromRequest('avatar')->toMediaCollection('users');
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

    public function userCourse(UserCourseRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();

        if ($request->get('id', false))
        {
            $u_c = UserCourse::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_c->update($data);
            $u_c->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_c = UserCourse::query()->create($data);
        }
        $row = view('website.profile.rows.user_course', compact('u_c'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل الدورة بنجاح');
    }

    public function userCourseDelete($id)
    {
        $user = Auth::guard('web')->user();
        UserCourse::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف الدورة بنجاح');
    }

    public function userLanguage(UserLanguageRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();

        if ($request->get('id', false))
        {
            $u_l = UserLanguage::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_l->update($data);
            $u_l->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_l = UserLanguage::query()->create($data);
        }
        $row = view('website.profile.rows.user_language', compact('u_l'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل اللغة بنجاح');
    }

    public function userLanguageDelete($id)
    {
        $user = Auth::guard('web')->user();
        UserLanguage::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف اللغة بنجاح');
    }

    public function userDisability(UserDisabilityRequest $request)
    {
        $data = $request->validated();
        $user = Auth::guard('web')->user();

        if ($request->get('id', false))
        {
            $u_d = UserDisability::query()->where('user_id',$user->id)->findOrFail($request->get('id'));
            $u_d->update($data);
            $u_d->fresh();
        }else{
            $data['user_id'] = $user->id;
            $u_d = UserDisability::query()->create($data);
        }
        $row = view('website.profile.rows.user_disability', compact('u_d'))->render();
        return $this->sendResponse(['row' => $row], 'تم تسجيل الوضع الصحي بنجاح');
    }

    public function userDisabilityDelete($id)
    {
        $user = Auth::guard('web')->user();
        UserDisability::query()->where('user_id', $user->id)->where('id', $id)->delete();
        return $this->sendResponse(null, 'تم حذف الوضع الصحي بنجاح');
    }

    public function changePassword()
    {
        $title = 'تغيير كلمة المرور';
        return view('website.profile.password', compact('title'));
    }

    public function password(PasswordRequest $request)
    {
        $user = Auth::guard('web')->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        if(Hash::check($request->get('current_password'), $user->password)) {
            $data['password'] = bcrypt($request->get('password'));
            $user->update($data);
        }else{
            return $this->sendError( 'كلمة المرور الحالية خاطئة', 422);
        }
        return $this->sendResponse(null, 'تم تغيير كلمة المرور بنجاح');
    }
}
