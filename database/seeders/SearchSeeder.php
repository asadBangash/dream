<?php

namespace Database\Seeders;

use App\Models\Search;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminSearchArr = [
            ['route_name' => 'dashboard',                           'title' => 'Dashboard'],
            ['route_name' => 'roles.index',                         'title' => 'Roles'],
            ['route_name' => 'genders.index',                       'title' => 'Genders'],
            ['route_name' => 'religions.index',                     'title' => 'Religions'],
            ['route_name' => 'blood-groups.index',                  'title' => 'Blood Groups'],
            ['route_name' => 'sessions.index',                      'title' => 'Sessions'],
            ['route_name' => 'users.index',                         'title' => 'Users'],
            ['route_name' => 'my.profile',                          'title' => 'Profile'],
            ['route_name' => 'languages.index',                     'title' => 'Languages'],
            ['route_name' => 'settings.general-settings',           'title' => 'General Settings'],
            ['route_name' => 'department.index',                    'title' => 'Department'],
            ['route_name' => 'designation.index',                   'title' => 'Designation'],
            ['route_name' => 'student.index',                       'title' => 'Student'],
            ['route_name' => 'student_category.index',              'title' => 'Student Category'],
            ['route_name' => 'promote_students.index',              'title' => 'Promote Students'],
            ['route_name' => 'disabled_students.index',             'title' => 'Disabled Student'],
            ['route_name' => 'parent.index',                        'title' =>  'Parent'],
            ['route_name' => 'online-admissions.index',             'title' => 'Online Admissions'],
            ['route_name' => 'book-category.index',                 'title' => 'Book Category'],
            ['route_name' => 'book.index',                          'title' => 'Book'],
            ['route_name' => 'member.index',                        'title' => 'Member'],
            ['route_name' => 'issue-book.index',                    'title' => 'Issue Book'],
            ['route_name' => 'member-category.index',               'title' => 'Member Category'],
            ['route_name' => 'fees-group.index',                    'title' => 'Fees Group'],
            ['route_name' => 'fees-type.index',                     'title' => 'Fees Type'],
            ['route_name' => 'fees-master.index',                   'title' => 'Fees Master'],
            ['route_name' => 'fees-assign.index',                   'title' => 'Fees Assign'],
            ['route_name' => 'fees-collect.index',                  'title' => 'Fees Collect'],
            ['route_name' => 'exam-type.index',                     'title' => 'Exam Type'],
            ['route_name' => 'marks-grade.index',                   'title' => 'Marks Grade'],
            ['route_name' => 'marks-register.index',                'title' => 'Marks Register'],
            ['route_name' => 'exam-routine.index',                  'title' => 'Exam Routine'],
            ['route_name' => 'exam-assign.index',                   'title' => 'Exam Assign'],
            ['route_name' => 'examination-settings.index',          'title' => 'Examination Settings'],
            ['route_name' => 'attendance.index',                    'title' => 'Attendance'],
            ['route_name' => 'account_head.index',                  'title' => 'Account Head'],
            ['route_name' => 'income.index',                        'title' => 'Income'],
            ['route_name' => 'expense.index',                       'title' => 'Expense'],
            ['route_name' => 'classes.index',                       'title' => 'Classes'],
            ['route_name' => 'section.index',                       'title' => 'Sections'],
            ['route_name' => 'subject.index',                       'title' => 'Subjects'],
            ['route_name' => 'shift.index',                         'title' => 'Shifts'],
            ['route_name' => 'class-room.index',                    'title' => 'Class Room'],
            ['route_name' => 'class-setup.index',                   'title' => 'Class Setup'],
            ['route_name' => 'assign-subject.index',                'title' => 'Assign Subject'],
            ['route_name' => 'class-routine.index',                 'title' => 'Class Routine'],
            ['route_name' => 'time_schedule.index',                 'title' => 'Time Schedule'],
            ['route_name' => 'report-marksheet.index',              'title' => 'Marksheet Report'],
            ['route_name' => 'report-merit-list.index',             'title' => 'Merit list Report'],
            ['route_name' => 'report-progress-card.index',          'title' => 'Progress Card Report'],
            ['route_name' => 'report-due-fees.index',               'title' => 'Due Fees Report'],
            ['route_name' => 'report-fees-collection.index',        'title' => 'Fees Collection Report'],
            ['route_name' => 'report-account.index',                'title' => 'Account Report'],
            ['route_name' => 'report-attendance.report',            'title' => 'Attendance Report'],
            ['route_name' => 'report-class-routine.index',          'title' => 'Class Routine Report'],
            ['route_name' => 'report-exam-routine.index',           'title' => 'Exam Routine Report'],
        ];

        foreach ($adminSearchArr as $search) {
            Search::firstOrCreate([
                'route_name'    => $search['route_name'],
                'title'         => $search['title'],
                'user_type'     => 'Admin'
            ]);
        }
        




        $studentSearchArr = [
            ['route_name' => 'student-panel-dashboard.index',                   'title' => 'Dashboard'],
            ['route_name' => 'student-panel.profile',                           'title' => 'Profile'],
            ['route_name' => 'student-panel-subject-list.index',                'title' => 'Subject List'],
            ['route_name' => 'student-panel-class-routine.index',               'title' => 'Class Routine'],
            ['route_name' => 'student-panel-exam-routine.index',                'title' => 'Exam Routine'],
            ['route_name' => 'student-panel-marksheet.index',                   'title' => 'Marksheet'],
            ['route_name' => 'student-panel-attendance.index',                  'title' => 'Attendance'],
            ['route_name' => 'student-panel-fees.index',                        'title' => 'Fees'],
        ];

        foreach ($studentSearchArr as $search) {
            Search::firstOrCreate([
                'route_name'    => $search['route_name'],
                'title'         => $search['title'],
                'user_type'     => 'Student'
            ]);
        }
        




        $parentSearchArr = [
            ['route_name' => 'parent-panel-dashboard.index.index',              'title' => 'Dashboard'],
            ['route_name' => 'parent-panel.profile',                            'title' => 'Profile'],
            ['route_name' => 'parent-panel-subject-list.index',                 'title' => 'Subject List'],
            ['route_name' => 'parent-panel-class-routine.index',                'title' => 'Class Routine'],
            ['route_name' => 'parent-panel-exam-routine.index',                 'title' => 'Exam Routine'],
            ['route_name' => 'parent-panel-marksheet.index',                    'title' => 'Marksheet'],
            ['route_name' => 'parent-panel-fees.index',                         'title' => 'Fees'],
            ['route_name' => 'parent-panel-attendance.index',                   'title' => 'Attendance'],
        ];

        foreach ($parentSearchArr as $search) {
            Search::firstOrCreate([
                'route_name'    => $search['route_name'],
                'title'         => $search['title'],
                'user_type'     => 'Parent'
            ]);
        }
    }
}
