<?php

namespace App\Imports;

use App\Models\Lottery\Applicant;
use App\Models\Lottery\Grade;
use App\Models\Lottery\LotteryCollege;
use App\Models\Lottery\LotteryDegree;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryGovernorate;
use App\Models\Lottery\LotteryMinistry;
use App\Models\Lottery\LotteryPosition;
use App\Models\Lottery\LotteryUniversity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ApplicantImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;

    private $created_rows = 0;
    private $updated_rows = 0;
    private $log_errors = [];

    private $degrees_set;
    private $universities_set;
    private $colleges_set;
    private $departments_set;
    private $governorates_set;


    public function __construct()
    {
        $this->degrees_set = collect([]); //LotteryDegree::query()->select(['name','id'])->get();
        $this->universities_set = collect([]); //LotteryUniversity::query()->select(['name','id'])->get();
        $this->colleges_set = collect([]); //LotteryCollege::query()->select(['name','id'])->get();
        $this->departments_set = collect([]); //LotteryDepartment::query()->select(['name','id'])->get();
        $this->governorates_set = LotteryGovernorate::query()->select(['name','id'])->get();
    }

    public function model(array $row)
    {
        $degree = strtolower(trim($row['degree']));
        $university = strtolower(trim($row['university']));
        $college = strtolower(trim($row['college']));
        $department = strtolower(trim($row['department']));
        $governorate = strtolower(trim($row['governorate']));
        $grade_required = isset($row['selected_grade']) ? intval($row['selected_grade']) : null;


        !is_null($degree) ? $selected_degree = $this->degrees_set->where('name', $degree)->first() : $selected_degree = null;

        if (is_null($selected_degree) && !is_null($degree)) {
            $selected_degree = LotteryDegree::query()->where('name', $degree)->first();
            if ($selected_degree) {
                $this->degrees_set->push((object)['id' => $selected_degree->id, 'name' => $selected_degree->name]);

            } else {
                $selected_degree = new LotteryDegree();
                $selected_degree->name = $degree;
                $selected_degree->save();

                $this->degrees_set->push((object)['id' => $selected_degree->id, 'name' => $selected_degree->name]);
            }
        }

        !is_null($university) ? $selected_university = $this->universities_set->where('name', $university)->first() : $selected_university = null;
        if (is_null($selected_university) && !is_null($university)) {
            $selected_university = LotteryUniversity::query()->where('name', $university)->first();
            if ($selected_university) {
                $this->universities_set->push(['id' => $selected_university->id, 'name' => $selected_university->name]);
            } else {
                $selected_university = new LotteryUniversity();
                $selected_university->name = $university;
                $selected_university->save();
                $this->universities_set->push(['id' => $selected_university->id, 'name' => $selected_university->name]);
            }
        }


        !is_null($college) ? $selected_college = $this->colleges_set->where('name', $college)->first() : $selected_college = null;
        if (is_null($selected_college) && !is_null($college)) {
            $selected_college = LotteryCollege::query()
                ->where('name', $college)
                ->first();
            if ($selected_college) {
                $this->colleges_set->push([
                    'id' => $selected_college->id,
                    'name' => $selected_college->name,
                ]);
            } else {
                $selected_college = new LotteryCollege();
                $selected_college->name = $college;
                $selected_college->save();
                $this->colleges_set->push([
                    'id' => $selected_college->id,
                    'name' => $selected_college->name,
                ]);
            }
        }

        !is_null($department) ? $selected_department = $this->departments_set->where('name', $department)->first() : $selected_department = null;
        if (is_null($selected_department) && !is_null($department)) {
            $selected_department = LotteryDepartment::query()->where('name', $department)->first();
            if ($selected_department)
            {
                $this->departments_set->push(['id' => $selected_department->id, 'name' => $selected_department->name]);
            }else {
                $selected_department = new LotteryDepartment();
                $selected_department->name = $department;
                $selected_department->save();
                $this->departments_set->push(['id' => $selected_department->id, 'name' => $selected_department->name]);
            }
        }

        !is_null($governorate) ? $selected_governorate = $this->governorates_set->where('name', $governorate)->first() : $selected_governorate = null;
        if (is_null($selected_governorate) && !is_null($governorate)) {
            $selected_governorate = new LotteryGovernorate();
            $selected_governorate->name = $governorate;
            $selected_governorate->save();
            $this->governorates_set->push(['id' => $selected_governorate->id, 'name' => $selected_governorate->name]);
        }


        $applicant = new Applicant();

        $applicant->lottery_degree_id = !is_null($selected_degree) ? (is_array($selected_degree) ? $selected_degree['id'] : $selected_degree->id) : null;
        $applicant->lottery_university_id = !is_null($selected_university) ? (is_array($selected_university) ? $selected_university['id'] : $selected_university->id) : null;
        $applicant->lottery_college_id = !is_null($selected_college) ? (is_array($selected_college) ? $selected_college['id'] : $selected_college->id) : null;
        $applicant->lottery_department_id = !is_null($selected_department) ? (is_array($selected_department) ? $selected_department['id'] : $selected_department->id) : null;
        $applicant->lottery_governorate_id = !is_null($selected_governorate) ? (is_array($selected_governorate) ? $selected_governorate['id'] : $selected_governorate->id) : null;
        $applicant->selected_grade = $grade_required;

        $applicant->name = $row['name'];
        $applicant->average = $row['average'];
        $applicant->sequencing = $row['sequencing'];
        $applicant->code = $row['code'];
        $applicant->password = bcrypt($row['password']);
        $applicant->graduation_year = intval($row['graduation_year']);
        $applicant->study_type = $row['study_type'];
        $applicant->mobile = $row['mobile'];
        $applicant->gender = $row['gender'] == 'ذكر' ? 1 : 2;
        $applicant->save();

        $this->created_rows++;

        return $applicant;

    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->log_errors[] = "Row " . $failure->row() . ' : ' . $failure->errors()[0];
        }
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'sequencing' => 'nullable',
            'code' => 'nullable',
            'password' => 'nullable',
            'graduation_year' => 'nullable',
            'university' => 'nullable',
            'college' => 'nullable',
            'department' => 'nullable',
            'degree' => 'nullable',
            'selected_grade' => 'nullable',
            'study_type' => 'nullable',
            'mobile' => 'nullable',
            'gender' => 'nullable',
            'governorate' => 'required',
        ];
    }

    public function getLogErrors(): array
    {
        return $this->log_errors;
    }

    public function getCreatedRows(): int
    {
        return $this->created_rows;
    }

    public function getUpdatedRows(): int
    {
        return $this->updated_rows;
    }
}
