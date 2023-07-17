<?php

namespace App\Imports;

use App\Models\Lottery\Grade;
use App\Models\Lottery\LotteryCollege;
use App\Models\Lottery\LotteryDegree;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryMinistry;
use App\Models\Lottery\LotteryPosition;
use App\Models\Lottery\LotteryUniversity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class GradeImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
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
    private $positions_set;
    private $ministries_set;


    public function __construct()
    {
        $this->degrees_set = collect([]);
        $this->universities_set = collect([]);
        $this->colleges_set = collect([]);
        $this->departments_set = collect([]);
        $this->positions_set = collect([]);
        $this->ministries_set = collect([]);
    }

    public function model(array $row)
    {
        $degree = strtolower($row['degree']);
        $university = strtolower($row['university']);
        $college = strtolower($row['college']);
        $department = strtolower($row['department']);
        $total_required = intval($row['total_required']);
        $position = strtolower($row['position']);
        $grade_required = intval($row['grade_required']);
        $ministry = strtolower($row['ministry']);


        !is_null($degree) ? $selected_degree = $this->degrees_set->where('name', $degree)->first(): $selected_degree = null;

        if (is_null($selected_degree)) {
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

         is_null($university) ? $selected_university = $this->universities_set->where('name', $university)->first(): $selected_university = null;
        if (is_null($selected_university)) {
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

         is_null($college) ? $selected_college = $this->colleges_set->where('name', $college)->first(): $selected_college = null;
        if (is_null($selected_college)) {
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

         is_null($department) ? $selected_department = $this->departments_set->where('name', $department)->first(): $selected_department = null;
        if (is_null($selected_department)) {
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

         is_null($position) ? $selected_position = $this->positions_set->where('name', $position)->first(): $selected_position = null;
        if (is_null($selected_position)) {
            $selected_position = LotteryPosition::query()->where('name', $position)->first();
            if ($selected_position)
            {
                $this->positions_set->push(['id' => $selected_position->id, 'name' => $selected_position->name]);
            }else {
                $selected_position = new LotteryPosition();
                $selected_position->name = $position;
                $selected_position->save();
                $this->positions_set->push(['id' => $selected_position->id, 'name' => $selected_position->name]);
            }
        }

         is_null($ministry) ? $selected_ministry = $this->ministries_set->where('name', $ministry)->first(): $selected_ministry = null;
        if (is_null($selected_ministry)) {
            $selected_ministry = LotteryMinistry::query()->where('name', $ministry)->first();
            if ($selected_ministry)
            {
                $this->ministries_set->push(['id' => $selected_ministry->id, 'name' => $selected_ministry->name]);
            }else {
                $selected_ministry = new LotteryMinistry();
                $selected_ministry->name = $ministry;
                $selected_ministry->save();
                $this->ministries_set->push(['id' => $selected_ministry->id, 'name' => $selected_ministry->name]);
            }
        }

        $grade = new Grade();

        $grade->lottery_degree_id = !is_null($selected_degree) ? $selected_degree->id:null;
        $grade->lottery_university_id = !is_null($selected_university) ? $selected_university->id:null;
        $grade->lottery_college_id = !is_null($selected_college) ? $selected_college->id:null;
        $grade->lottery_department_id = !is_null($selected_department) ? $selected_department->id:null;
        $grade->lottery_position_id = !is_null($selected_position) ? $selected_position->id:null;
        $grade->lottery_ministry_id = !is_null($selected_ministry) ? $selected_ministry->id:null;
        $grade->total_required = $total_required;
        $grade->grade_required = $grade_required;
        $grade->save();

        $this->created_rows ++;

        return $grade;

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
            'degree' => 'required',
            'university' => 'nullable',
            'college' => 'nullable',
            'department' => 'nullable',
            'total_required' => 'required',
            'position' => 'required',
            'grade_required' => 'required',
            'ministry' => 'required',
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

