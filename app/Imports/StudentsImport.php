<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\StudentInfo\ParentGuardian;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\StudentInfo\SessionClassStudent;

class StudentsImport implements ToModel, WithStartRow, WithValidation
{

    protected $class;
    protected $section;

    public function __construct($class, $section)
    {
        $this->class = $class;
        $this->section = $section;
    }

    /**
     * Start import from row 2 (skip the first row)
     */
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '39' => 'required|unique:users,username',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '39.required' => ___('validation.The Students Username is required'),
            '39.unique'   => ___('validation.The Students Username has already been taken'),
        ];
    }


    public function model(array $row)
    {
        $role2              = Role::find(7);
        $excelDOB           = $row[19];
        $excelAdmissionDate = $row[25];
        $dateOfBirth        = Date::excelToDateTimeObject($excelDOB);
        $admissionDate      = Date::excelToDateTimeObject($excelAdmissionDate);

        $userParent                    = new User();
        $userParent->name              = $row[0]??$row[39].' guardian';
        $userParent->email             = $row[1]??$row[39].'guardian@gmail.com';
        $userParent->phone             = $row[4];
        $userParent->password          = Hash::make($row[2]??123456);
        $userParent->email_verified_at = now();
        $userParent->role_id           = $role2->id;
        $userParent->permissions       = $role2->permissions;
        $userParent->username          = $row[38];
        $userParent->uuid               = Str::uuid();
        $userParent->save();

        $guardian                      = new ParentGuardian();
        $guardian->user_id             = $userParent->id;
        $guardian->father_name         = $row[3]??$row[39].' guardian';
        $guardian->father_mobile       = $row[4];
        $guardian->father_profession   = $row[5];
        $guardian->father_nationality  = $row[6];
        $guardian->mother_name         = $row[7];
        $guardian->mother_mobile       = $row[8];
        $guardian->mother_profession   = $row[9];
        $guardian->guardian_profession = $row[10];
        $guardian->guardian_address    = $row[11];
        $guardian->guardian_relation   = $row[12];
        $guardian->guardian_name       = $row[0]??$row[39].' guardian';
        $guardian->guardian_email      = $row[1]??$row[39].'guardian@gmail.com';
        $guardian->guardian_mobile     = $row[2];
        $guardian->father_id           = $row[36];
        $guardian->mother_id           = $row[37];
        $guardian->status              = 1;
        $guardian->save();


        $userStd                    = new User();
        $userStd->name              = $row[13] . ' ' . $row[14];
        $userStd->email             = $row[15]??$row[39].'@gmail.com';
        $userStd->phone             = $row[16];
        $userStd->admission_no      = $row[17];
        $userStd->password          = Hash::make($row[18]??123456);
        $userStd->email_verified_at = now();
        $role                       = Role::find(6);
        $userStd->role_id           = $role->id;
        $userStd->permissions       = $role->permissions;
        $userStd->date_of_birth     = $dateOfBirth;
        $userStd->username          = $row[39];
        $userStd->uuid              = Str::uuid();
        $userStd->save();

        // Create a new Student instance
        $student                         = new Student();
        $student->user_id                = $userStd->id;
        $student->first_name             = $row[13];
        $student->last_name              = $row[14];
        $student->admission_no           = $row[17];
        $student->roll_no                = $row[20];
        $student->mobile                 = $row[16];
        $student->email                  = $row[15]??$row[39].'@gmail.com';
        $student->dob                    = $dateOfBirth;
        $student->religion_id            = $row[21];
        $student->gender_id              = $row[22];
        $student->blood_group_id         = $row[23];
        $student->admission_date         = $admissionDate;
        $student->parent_guardian_id     = $guardian->id;
        $student->student_category_id    = $row[24];
        $student->previous_school        = $row[26]??0;
        $student->previous_school_info   = $row[27];
        $student->place_of_birth         = $row[28];
        $student->nationality            = $row[29];
        $student->cpr_no                 = $row[30];
        $student->spoken_lang_at_home    = $row[31];
        $student->residance_address      = $row[32];
        $student->student_ar_name        = $row[33];
        $student->student_id_certificate = $row[34];
        $student->emergency_contact      = $row[35];
        $student->student_code           = $row[40];
        $student->status                 = 1;
        $student->save();

        $session_class             = new SessionClassStudent();
        $session_class->session_id = setting('session');
        $session_class->classes_id = $this->class;
        $session_class->section_id = $this->section;
        $session_class->shift_id   = NULL;
        $session_class->student_id = $student->id;
        $session_class->roll       = $row[20];
        $session_class->save();

        return $student;
    }
}
