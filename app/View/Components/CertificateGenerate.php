<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\StudentInfo\Student;
use App\Models\StudentInfo\SessionClassStudent;

class CertificateGenerate extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;
    public $certificate;

    public function __construct($student, $certificate)
    {
        $this->student     = $student;
        $this->certificate = $certificate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $sessionStudent = SessionClassStudent::find($this->student);

        // [student_name], [class_name], [section_name], [school_name], [session], [school_address]

        $data['description'] = $this->certificate;
        $data['description'] = str_replace('[student_name]', $sessionStudent->student->first_name.' '.$sessionStudent->student->last_name, $data['description']);
        $data['description'] = str_replace('[class_name]',   $sessionStudent->class->name, $data['description']);
        $data['description'] = str_replace('[section_name]', $sessionStudent->section->name, $data['description']);
        $data['description'] = str_replace('[school_name]', setting('application_name'), $data['description']);
        $data['description'] = str_replace('[session]', setting('session'), $data['description']);
        $data['description']= str_replace('[school_address]', setting('address'), $data['description']);
        
        return view('components.certificate-generate', compact('data'));
    }
}
