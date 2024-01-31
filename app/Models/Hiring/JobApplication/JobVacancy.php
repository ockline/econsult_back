<?php

namespace App\Models\Hiring\JobApplication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
 use SoftDeletes;

    protected  $table = 'job_vacancies';
    protected $guarded = [];
    public $timestamps = true;

   protected $fillable = [
                    'employer_id','job_title_id','department_id','type_vacancy_id','position_vacant','date_application','deadline_date','hr_interview_date','tech_interview_date','apointment_date','work_station','replacement_reason','age','accademic','professional','salary_range','others','additional_comment','status'
                      ];
}
