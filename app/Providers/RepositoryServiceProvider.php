<?php

namespace App\Providers;

use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\GenderInterface;
use App\Interfaces\SessionInterface;
use App\Interfaces\SettingInterface;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Interfaces\FlagIconInterface;
use App\Interfaces\LanguageInterface;
use App\Interfaces\ReligionInterface;
use App\Repositories\GenderRepository;
use App\Interfaces\BloodGroupInterface;
use App\Interfaces\PermissionInterface;
use App\Repositories\SessionRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\FlagIconRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\ReligionRepository;
use App\Interfaces\Fees\FeesTypeInterface;
use App\Repositories\BloodGroupRepository;
use App\Repositories\Gmeet\GmeetInterface;
use App\Repositories\PermissionRepository;
use App\Interfaces\Academic\ShiftInterface;
use App\Interfaces\Fees\FeesGroupInterface;
use App\Interfaces\GeneralSettingInterface;
use App\Repositories\Gmeet\GmeetRepository;
use App\Interfaces\Accounts\IncomeInterface;
use App\Interfaces\Fees\FeesAssignInterface;
use App\Interfaces\Fees\FeesMasterInterface;
use App\Interfaces\Academic\ClassesInterface;
use App\Interfaces\Academic\SectionInterface;
use App\Interfaces\Academic\SubjectInterface;
use App\Interfaces\Accounts\ExpenseInterface;
use App\Interfaces\Fees\FeesCollectInterface;
use App\Interfaces\Report\MarksheetInterface;
use App\Interfaces\Staff\DepartmentInterface;
use App\Repositories\Fees\FeesTypeRepository;
use App\Interfaces\Frontend\FrontendInterface;
use App\Interfaces\Staff\DesignationInterface;
use App\Interfaces\WebsiteSetup\NewsInterface;
use App\Repositories\Academic\ShiftRepository;
use App\Repositories\AuthenticationRepository;
use App\Repositories\Fees\FeesGroupRepository;
use App\Repositories\GeneralSettingRepository;
use App\Interfaces\Academic\ClassRoomInterface;
use App\Interfaces\Report\ExamRoutineInterface;
use App\Repositories\Accounts\IncomeRepository;
use App\Repositories\Fees\FeesAssignRepository;
use App\Repositories\Fees\FeesMasterRepository;
use App\Interfaces\Academic\ClassSetupInterface;
use App\Interfaces\WebsiteSetup\SliderInterface;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Academic\SubjectRepository;
use App\Repositories\Accounts\ExpenseRepository;
use App\Repositories\Fees\FeesCollectRepository;
use App\Repositories\Homework\HomeworkInterface;
use App\Repositories\Report\MarksheetRepository;
use App\Repositories\Staff\DepartmentRepository;
use App\Interfaces\Accounts\AccountHeadInterface;
use App\Interfaces\Examination\ExamTypeInterface;
use App\Interfaces\WebsiteSetup\CounterInterface;
use App\Repositories\Frontend\FrontendRepository;
use App\Repositories\Homework\HomeworkRepository;
use App\Repositories\Staff\DesignationRepository;
use App\Repositories\WebsiteSetup\NewsRepository;
use App\Interfaces\Academic\ClassRoutineInterface;
use App\Interfaces\Academic\TimeScheduleInterface;
use App\Repositories\Academic\ClassRoomRepository;
use App\Repositories\Report\ExamRoutineRepository;
use App\Interfaces\Academic\SubjectAssignInterface;
use App\Interfaces\StudentPanel\DashboardInterface;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\WebsiteSetup\SliderRepository;
use App\Repositories\Accounts\AccountHeadRepository;
use App\Repositories\Examination\ExamTypeRepository;
use App\Repositories\WebsiteSetup\CounterRepository;
use App\Interfaces\AuthenticationRepositoryInterface;
use App\Repositories\Academic\ClassRoutineRepository;
use App\Repositories\Academic\TimeScheduleRepository;
use App\Interfaces\Examination\MarksRegisterInterface;
use App\Repositories\Academic\SubjectAssignRepository;
use App\Repositories\NoticeBoard\NoticeBoardInterface;
use App\Repositories\StudentPanel\DashboardRepository;
use App\Interfaces\StudentInfo\PromoteStudentInterface;
use App\Repositories\NoticeBoard\NoticeBoardRepository;
use App\Interfaces\OnlineExamination\OnlineExamInterface;
use App\Repositories\Examination\MarksRegisterRepository;
use App\Repositories\StudentInfo\PromoteStudentRepository;
use App\Interfaces\OnlineExamination\QuestionBankInterface;
use App\Interfaces\OnlineExamination\QuestionGroupInterface;
use App\Repositories\OnlineExamination\OnlineExamRepository;
use App\Repositories\OnlineExamination\QuestionBankRepository;
use App\Repositories\SmsMailTemplate\SmsMailTemplateInterface;
use App\Repositories\OnlineExamination\QuestionGroupRepository;
use App\Repositories\SmsMailTemplate\SmsMailTemplateRepository;
use App\Interfaces\Report\ClassRoutineInterface as ReportClassRoutineInterface;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use App\Interfaces\StudentPanel\MarksheetInterface as StudentPanelMarksheetInterface;
use App\Interfaces\StudentPanel\ExamRoutineInterface as StudentPanelExamRoutineInterface;
use App\Repositories\StudentPanel\MarksheetRepository as StudentPanelMarksheetRepository;
use App\Interfaces\StudentPanel\ClassRoutineInterface as StudentPanelClassRoutineInterface;
use App\Repositories\StudentPanel\ExamRoutineRepository as StudentPanelExamRoutineRepository;
use App\Repositories\StudentPanel\Homework\HomeworkInterface as StudentPanelHomeworkInterface;
use App\Repositories\StudentPanel\ClassRoutineRepository as StudentPanelClassRoutineRepository;
use App\Repositories\StudentPanel\Homework\HomeworkRepository as StudentPanelHomeworkRepository;
use App\Repositories\ParentPanel\Homework\HomeworkInterface as ParentPanelHomeworkInterface;
use App\Repositories\ParentPanel\Homework\HomeworkRepository as ParentPanelHomeworkRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Frontend
        $this->app->bind(FrontendInterface::class,                 FrontendRepository::class);

        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);
        $this->app->bind(RoleInterface::class,                     RoleRepository::class);
        $this->app->bind(PermissionInterface::class,               PermissionRepository::class);
        $this->app->bind(UserInterface::class,                     UserRepository::class);
        $this->app->bind(GeneralSettingInterface::class,           GeneralSettingRepository::class);
        $this->app->bind(SettingInterface::class,                  SettingRepository::class);
        $this->app->bind(LanguageInterface::class,                 LanguageRepository::class);
        $this->app->bind(FlagIconInterface::class,                 FlagIconRepository::class);
        $this->app->bind(GenderInterface::class,                   GenderRepository::class);
        $this->app->bind(ReligionInterface::class,                 ReligionRepository::class);
        $this->app->bind(BloodGroupInterface::class,               BloodGroupRepository::class);
        // website setup
        $this->app->bind(SliderInterface::class,                   SliderRepository::class);
        $this->app->bind(CounterInterface::class,                  CounterRepository::class);
        $this->app->bind(NewsInterface::class,                     NewsRepository::class);
        // Academic
        $this->app->bind(SessionInterface::class,                  SessionRepository::class);
        $this->app->bind(ClassesInterface::class,                  ClassesRepository::class);
        $this->app->bind(SectionInterface::class,                  SectionRepository::class);
        $this->app->bind(SubjectInterface::class,                  SubjectRepository::class);
        $this->app->bind(ShiftInterface::class,                    ShiftRepository::class);
        $this->app->bind(ClassRoomInterface::class,                ClassRoomRepository::class);
        $this->app->bind(ClassSetupInterface::class,               ClassSetupRepository::class);
        $this->app->bind(SubjectAssignInterface::class,            SubjectAssignRepository::class);
        $this->app->bind(ClassRoutineInterface::class,             ClassRoutineRepository::class);
        $this->app->bind(TimeScheduleInterface::class,             TimeScheduleRepository::class);
        // Fess
        $this->app->bind(FeesGroupInterface::class,                FeesGroupRepository::class);
        $this->app->bind(FeesTypeInterface::class,                 FeesTypeRepository::class);
        $this->app->bind(FeesMasterInterface::class,               FeesMasterRepository::class);
        $this->app->bind(FeesAssignInterface::class,               FeesAssignRepository::class);
        $this->app->bind(FeesCollectInterface::class,              FeesCollectRepository::class);
        // Staff
        $this->app->bind(DepartmentInterface::class,               DepartmentRepository::class);
        $this->app->bind(DesignationInterface::class,              DesignationRepository::class);
        
        // Examination
        $this->app->bind(ExamTypeInterface::class,                 ExamTypeRepository::class);
        $this->app->bind(MarksRegisterInterface::class,            MarksRegisterRepository::class);
        // Report
        $this->app->bind(MarksheetInterface::class,                MarksheetRepository::class);
        $this->app->bind(ReportClassRoutineInterface::class,       ReportClassRoutineRepository::class);
        $this->app->bind(ExamRoutineInterface::class,              ExamRoutineRepository::class);
        // Accounts
        $this->app->bind(AccountHeadInterface::class,              AccountHeadRepository::class);
        $this->app->bind(IncomeInterface::class,                   IncomeRepository::class);
        $this->app->bind(ExpenseInterface::class,                  ExpenseRepository::class);
        // Students
        $this->app->bind(PromoteStudentInterface::class,           PromoteStudentRepository::class);
        
        
        // Student panel
        $this->app->bind(DashboardInterface::class,                          DashboardRepository::class);
        $this->app->bind(StudentPanelClassRoutineInterface::class,           StudentPanelClassRoutineRepository::class);
        $this->app->bind(StudentPanelExamRoutineInterface::class,            StudentPanelExamRoutineRepository::class);
        $this->app->bind(StudentPanelMarksheetInterface::class,              StudentPanelMarksheetRepository::class);

        // Online examination
        $this->app->bind(QuestionGroupInterface::class,           QuestionGroupRepository::class);
        $this->app->bind(QuestionBankInterface::class,            QuestionBankRepository::class);
        $this->app->bind(OnlineExamInterface::class,              OnlineExamRepository::class);
        $this->app->bind(HomeworkInterface::class,                HomeworkRepository::class);
        // live class
        $this->app->bind(GmeetInterface::class,                GmeetRepository::class);
        // communication
        $this->app->bind(NoticeBoardInterface::class,                NoticeBoardRepository::class);
        $this->app->bind(SmsMailTemplateInterface::class,                SmsMailTemplateRepository::class);
        
        // Online examination
        $this->app->bind(StudentPanelHomeworkInterface::class,    StudentPanelHomeworkRepository::class);
        $this->app->bind(ParentPanelHomeworkInterface::class,    ParentPanelHomeworkRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
