<?php

namespace App\Imports;

use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FeesImport implements ToModel, WithValidation
{
    protected $group;
    protected static $processedFirstRow = false;
    protected $feesTypeIds = [];

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function rules(): array
    {
        return [
            '1' => 'required'
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'The first column field is required'
        ];
    }

    public function model(array $row)
    {
        // Skip processing the first row for the due date but process it for fees_types
        if (!self::$processedFirstRow) {
            foreach (array_slice($row, 3) as $columnIndex => $columnValue) {
                if (!empty($columnValue)) {
                    // Insert into fees_types table
                    $feesTypeId = DB::table('fees_types')->insertGetId([
                        'name' => $columnValue,
                        'status' => 1
                    ]);

                    // Store the fees_type_id for later use
                    $this->feesTypeIds[$columnIndex] = $feesTypeId;
                }
            }
            self::$processedFirstRow = true;
        } else {
           
            $dueDate = !empty($row[1]) ? Date::excelToDateTimeObject($row[1]) : null;
            $admissionNo = !empty($row[2]) ? $row[2] : null;

            foreach (array_slice($row, 3) as $columnIndex => $columnValue) {
                if (!empty($columnValue) && isset($this->feesTypeIds[$columnIndex])) {
                    // Insert or update fees_master table
                    $student = Student::where('admission_no', $admissionNo)->first();

                    if (($student)  && ($columnValue) && ($columnValue > 0)) {
                        DB::table('fees_masters')->updateOrInsert(
                            [
                                'session_id' => $student->session_class_student->session_id,
                                'fees_group_id' => $this->group,
                                'fees_type_id' => $this->feesTypeIds[$columnIndex],
                                'amount' => $columnValue,
                                'due_date' => $dueDate
                            ],
                            ['status' => 1]
                        );
                        // Verify if the fees_master record was created
                        $feesMasterId = DB::table('fees_masters')->where([
                            'session_id' => $student->session_class_student->session_id,
                            'fees_group_id' => $this->group,
                            'fees_type_id' => $this->feesTypeIds[$columnIndex],
                            'amount' => $columnValue,
                            'due_date' => $dueDate
                        ])->value('id');

                        \Log::info('Fees Master ID: ' . $feesMasterId);

                        if ($feesMasterId) {
                            // Insert or update into fees_assigns table
                            $assignId = DB::table('fees_assigns')->updateOrInsert(
                                [
                                    'session_id' => $student->session_class_student->session_id,
                                    'fees_group_id' => $this->group,
                                    'classes_id' => $student->session_class_student->classes_id,
                                    'section_id' => $student->session_class_student->section_id,
                                ],
                                [
                                    'category_id' => $student->student_category_id,
                                    'gender_id' => $student->gender_id
                                ]
                            );

                            // Retrieve the fees_assign_id
                            $assignId = DB::table('fees_assigns')->where([
                                'session_id' => $student->session_class_student->session_id,
                                'fees_group_id' => $this->group,
                                'classes_id' => $student->session_class_student->classes_id,
                                'section_id' => $student->session_class_student->section_id
                            ])->value('id');

                            \Log::info('Fees Assign ID: ' . $assignId);

                            if ($assignId) {
                                // Insert or update into fees_assign_childrens table
                                DB::table('fees_assign_childrens')->updateOrInsert(
                                    [
                                        'fees_assign_id' => $assignId,
                                        'fees_master_id' => $feesMasterId,
                                        'student_id' => $student->id
                                    ]
                                );
                            } else {
                                \Log::warning('Failed to retrieve Fees Assign ID');
                            }
                        } else {
                            \Log::warning('Failed to retrieve Fees Master ID');
                        }
                    } else {
                        \Log::warning('Student not found for admission number: ' . $admissionNo);
                    }
                }
            }
        }

        return null;  // No models to return here
    }


}
