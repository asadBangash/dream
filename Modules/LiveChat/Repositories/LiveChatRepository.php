<?php

namespace Modules\LiveChat\Repositories;

use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\Setting;
use App\Models\Staff\Department;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\LiveChat\Entities\Message;
use Modules\LiveChat\Entities\MessageUser;
use Modules\LiveChat\Interfaces\LiveChatInterface;
use Modules\LiveChat\Traits\PusherTrait;

class LiveChatRepository implements LiveChatInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, PusherTrait, CommonHelperTrait;

    private $messageModel;
    private $userModel;
    private $messageUser;
    private $settingModel;

    public function __construct(
        Message $messageModel,
        User $userModel,
        Setting $settingModel,
        MessageUser $messageUserModel

    ) {
        $this->messageModel = $messageModel;
        $this->userModel = $userModel;
        $this->messageUser = $messageUserModel;
        $this->settingModel = $settingModel;
    }

    public function model()
    {
        return $this->messageModel;
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {

            $receiver = $this->userModel->find(decryptFunction($request->user_id));

            if (!$receiver) {
                return $this->responseWithError(___('alert.user_not_found'));
            }
            $message = $this->messageModel->create([
                'message' => $request->message,
                'sender_id' => auth()->user()->id,
                'receiver_id' => decryptFunction($request->user_id),
            ]);

            $result = $this->sendMessage($message);

            if (!$result['status']) {
                return response()->json([
                    'message' => $result['message'],
                    'data' => [],
                    'result' => false,
                ], 400);
            }
            DB::commit(); // commit database transaction
            $result['data']['image'] = @globalAsset(auth()->user()->upload->path, '40X40.webp');
            return response()->json([
                'message' => ___('alert.message_send'),
                'data' => $result['data'],
                'result' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function update($request)
    {
        try {
            if ($request->has('pusher_app_id')) {
                $pusher_app_id = $this->settingModel::where('name', 'pusher_app_id')->first();
                if ($pusher_app_id) {
                    $pusher_app_id->update(['value' => $request->pusher_app_id]);
                } else {
                    $this->settingModel::create([
                        'name' => 'pusher_app_id',
                        'value' => $request->pusher_app_id,
                    ]);
                }
                $this->setEnvironmentValue('PUSHER_APP_ID', $request->pusher_app_id);
            }
            if ($request->has('pusher_app_key')) {
                $pusher_app_key = $this->settingModel::where('name', 'pusher_app_key')->first();
                if ($pusher_app_key) {
                    $pusher_app_key->update(['value' => $request->pusher_app_key]);
                } else {
                    $this->settingModel::create([
                        'name' => 'pusher_app_key',
                        'value' => $request->pusher_app_key,
                    ]);
                }
                $this->setEnvironmentValue('PUSHER_APP_KEY', $request->pusher_app_key);
            }
            if ($request->has('pusher_app_secret')) {
                $pusher_app_secret = $this->settingModel::where('name', 'pusher_app_secret')->first();
                if ($pusher_app_secret) {
                    $pusher_app_secret->update(['value' => $request->pusher_app_secret]);
                } else {
                    $this->settingModel::create([
                        'name' => 'pusher_app_secret',
                        'value' => $request->pusher_app_secret,
                    ]);
                }
                $this->setEnvironmentValue('PUSHER_APP_SECRET', $request->pusher_app_secret);
            }
            if ($request->has('pusher_app_cluster')) {
                $pusher_app_cluster = $this->settingModel::where('name', 'pusher_app_cluster')->first();
                if ($pusher_app_cluster) {
                    $pusher_app_cluster->update(['value' => $request->pusher_app_cluster]);
                } else {
                    $this->settingModel::create([
                        'name' => 'pusher_app_cluster',
                        'value' => $request->pusher_app_cluster,
                    ]);
                }
                $this->setEnvironmentValue('PUSHER_APP_CLUSTER', $request->pusher_app_cluster);
            }
            return $this->responseWithSuccess(___('alert.Live_chat_settings_update'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function readMessages($id)
    {
        try {
            Log::info('Reading messages from:' . decryptFunction($id));
            $this->model()->where('receiver_id', decryptFunction($id))->update(['is_seen' => 1]);
            return $this->responseWithSuccess(___('alert.message_read'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function adminChatList($request)
    {
        $authAdmin = Auth::user();
        $user = null;
        $users = [];
        $userId = $request->input('user_id');

        $userIds = [];

        $department = Department::where('staff_user_id', @$authAdmin->staff->id)->first();


        if ($department) {
            $staffs = Staff::where('department_id', $department->id)->pluck('user_id')->toArray();
            $students = Student::with('parent')->where('department_id', $department->id)->get(['id', 'user_id', 'parent_guardian_id']);
            $studentIds = $students->pluck('user_id')->toArray() ?? [];
            $parentIds = $students->pluck('parent.user_id')->toArray() ?? [];

            $userIds = array_merge($staffs, $studentIds, $parentIds);
        }

        $users = User::with('lastMessage')
            ->when(!empty($userIds), function ($query) use ($userIds) {
                $query->whereIn('id', $userIds);
            })
            ->where('id', '!=', $authAdmin->id)
            ->when($request->filled('key'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->key . '%');
            })
            ->get();

        return [
            'users' => $users,
            'user' => $user,
            'userId' => $userId,
        ];
    }


    public function studentChatList($request)
    {
        $authStudent = auth()->user();
        $user = null;
        $users = [];
        $userId = $request->input('user_id');

        $studentClass = SessionClassStudent::where('student_id', $authStudent->student->id)->first();

        if (!$studentClass) {
            return $this->responseWithError('Student class not found');
        }

        $subjectAssign = SubjectAssign::where('classes_id', $studentClass->classes_id)
            ->where('section_id', $studentClass->section_id)->get();


        if ($subjectAssign->isEmpty()) {
            return $this->responseWithError('Subject not assigned');
        }
        // dd($subjectAssign->pluck('id'));
        $subjectAssignChildren = SubjectAssignChildren::whereIn('subject_assign_id', $subjectAssign->pluck('id'))->get();


        if ($subjectAssignChildren->isEmpty()) {
            return $this->responseWithError('Subject not assigned');
        }

        $staffIdsArray = $subjectAssignChildren->pluck('staff_id')->toArray();

        $uniqueStaffIds = array_unique($staffIdsArray);


        $admin = User::with('lastMessage')
            ->where('role_id', 1)
            ->when($request->filled('key'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->key . '%');
            })
            ->select('users.name as first_name', 'users.upload_id', 'id as user_id')
            ->get();


        $users = Staff::query()
            ->with(['lastMessage' => function ($query) {
                $query->latest('created_at');
            }])
            ->whereIn('id', $uniqueStaffIds)
            ->when($request->filled('key'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->key . '%')
                        ->orWhere('last_name', 'like', '%' . $request->key . '%');
                });
            })
            ->select('staff.*')
            ->addSelect(DB::raw('(SELECT MAX(created_at) FROM messages WHERE receiver_id = staff.user_id) as last_message_time'))
            ->orderBy('last_message_time', 'desc')
            ->get();

        // Merge the two collections
        $users = $users->merge($admin);


        return [
            'users' => $users,
            'user' => $user,
            'userId' => $userId,
        ];
    }


    public function guardianChatList($request)
    {
        $authUser = auth()->user()->parent;
        $user = null;
        $users = [];
        $userId = $request->input('user_id');
        $children = Student::where('parent_guardian_id', $authUser->id)->first();

        $studentClass = SessionClassStudent::where('student_id', $children->id)->first();

        if (!$studentClass) {
            return $this->responseWithError('Student class not found');
        }

        $subjectAssign = SubjectAssign::where('classes_id', $studentClass->classes_id)
            ->where('section_id', $studentClass->section_id)->get();

        if ($subjectAssign->isEmpty()) {
            return $this->responseWithError('Subject not assigned');
        }
        $subjectAssignChildren = SubjectAssignChildren::where('subject_assign_id', $subjectAssign->pluck('id'))->get();

        if ($subjectAssignChildren->isEmpty()) {
            return $this->responseWithError('Subject not assigned');
        }

        $staffIdsArray = $subjectAssignChildren->pluck('staff_id')->toArray();

        $uniqueStaffIds = array_unique($staffIdsArray);

        $users = Staff::query()->whereIn('id', $uniqueStaffIds)
            ->when($request->filled('key'), function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->key . '%');
                $query->orWhere('last_name', 'like', '%' . $request->key . '%');
            })
            ->select('staff.*')
            ->addSelect(DB::raw('(SELECT MAX(created_at) FROM messages WHERE receiver_id = staff.user_id) as last_message_time'))
            ->orderBy('last_message_time', 'desc')
            ->get();

        return [
            'users' => $users,
            'user' => $user,
            'userId' => $userId,
        ];
    }


    public function instructorChatList($request)
    {
        $authStaff = auth()->user()->staff;
        $user = null;
        $users = [];
        $userId = $request->input('user_id');

        $department = Department::where('staff_user_id', $authStaff->id)->first();

        $subjectAssignChildren = SubjectAssignChildren::where('staff_id', $authStaff->id)->get();

        if ($subjectAssignChildren->isEmpty()) {
            return $this->responseWithError('Subject not assigned children');
        }

        $subjectAssignIdsArray = $subjectAssignChildren->pluck('subject_assign_id')->toArray();

        $uniqueSubjestAssignIds = array_unique($subjectAssignIdsArray);

        $subjectAssigns = SubjectAssign::whereIn('id', $uniqueSubjestAssignIds)->get();

        if ($subjectAssigns->isEmpty()) {
            return $this->responseWithError('Subject not assigned');
        }

        $classIdsArray = $subjectAssigns->pluck('classes_id')->toArray();

        $uniqueClassIds = array_unique($classIdsArray);

        $studentClasses = SessionClassStudent::whereIn('classes_id', $uniqueClassIds)->get();

        $studentIdsArray = $studentClasses->pluck('student_id')->toArray();

        $uniqueStudentIds = array_unique($studentIdsArray);


        $userQuery = Student::query()->with('parent', function ($q) use ($request) {
            $q->when($request->filled('key'), function ($query) use ($request) {
                $query->where('guardian_name', 'like', '%' . $request->key . '%');
            });
        })
            ->whereIn('id', $uniqueStudentIds)

            ->when($request->filled('key'), function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->key . '%')
                    ->orWhere('last_name', 'like', '%' . $request->key . '%');
            })
            ->select('students.*')
            ->addSelect(DB::raw('(SELECT MAX(created_at) FROM messages WHERE receiver_id = students.user_id) as last_message_time'))
            ->orderBy('last_message_time', 'desc');

        if ($department) {
            $userQuery->where('department_id', $department->id);
        }
        $users = $userQuery->get();

        return [
            'users' => $users,
            'user' => $user,
            'userId' => $userId,
        ];
    }
}
