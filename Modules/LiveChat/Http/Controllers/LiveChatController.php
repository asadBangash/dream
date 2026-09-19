<?php

namespace Modules\LiveChat\Http\Controllers;

use App\Enums\RoleEnum;
use App\Interfaces\UserInterface;
use App\Models\Academic\Subject;
use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\LiveChat\Entities\MessageUser;
use Modules\LiveChat\Http\Requests\LiveChatRequest;
use Modules\LiveChat\Interfaces\LiveChatInterface;

class LiveChatController extends Controller
{

    use ApiReturnFormatTrait;

    private $user;
    private $live_chat;

    public function __construct(UserInterface $userInterface, LiveChatInterface $liveChatInterface)
    {
        $this->user = $userInterface;
        $this->live_chat = $liveChatInterface;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    public function index(Request $request)
    {

        try {

            $data['title'] = ___('live_chat.Live_Chat');
            return view('livechat::index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function chatList(Request $request)
    {
        try {
            $data['user_id'] = @$request->user_id ? decryptFunction($request->user_id) : null;
            if (@$data['user_id']) {
                $data['user'] = MessageUser::with('image')->where('id', $data['user_id'])->first();
                $users = MessageUser::with('image')->where('id', '!=', auth()->id())
                    ->search($request)
                    ->where('id', '!=', $data['user_id']);
            } else {
                $data['user'] = null;
                $users = MessageUser::with('image')->search($request)->where('id', '!=', auth()->id());
            }
            $data['users'] = $users->orderBy('id', 'DESC')->paginate(5);
            $data['title'] = ___('live_chat.Live_Chat');
            $content['last_page'] = $data['users']->lastPage();
            $content['html'] = view('livechat::partials.chat-list', compact('data'))->render();
            return $this->responseWithSuccess(___('live_chat.Live_Chat'), $content); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function setting()
    {
        try {
            $data['title'] = ___('live_chat.Live_Chat_Setting');
            return view('livechat::setting', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function settingUpdate(LiveChatRequest $request)
    {
        try {
            $result = $this->live_chat->update($request);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function adminLiveChat()
    {
        try {
            $data['title'] = ___('student_info.Live_Chat'); // title
            return view('livechat::admin.live_chat', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function adminChatList(Request $request)
    {
        try {
            $data = $this->live_chat->adminChatList($request);
            $users = [];
            $userId = null;
            $user = null;


            if ($data) {
                $users = $data['users'];
                $userId = $data['userId'];

                if ($userId) {
                    $staff = User::find(decryptFunction($userId));
                    if ($staff) {
                        $userId = $staff->id;
                        $user = $staff;
                    }
                }
            }

            //            dd($users);

            $data = array_merge($data ?? [], [
                'user_id' => $userId,
                'user' => $user,
                'users' => $users,
                'title' => ___('live_chat.Live_Chat')
            ]);

            $content['last_page'] = null;
            $content['html'] = view('livechat::partials.admin-chat-list')->with($data)->render();

            return response()->json([
                'message' => ___('live_chat.Live_Chat'),
                'result' => true,
                'data' => $content
            ]);
        } catch (\Exception $e) {
            dd($e);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }


    // live chat
    public function studentLiveChat()
    {
        try {
            $data['title'] = ___('student_info.Live_Chat'); // title
            return view('livechat::student.live_chat', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // live chat

    public function studentChatList(Request $request)
    {
        try {
            $data = $this->live_chat->studentChatList($request);
            $users = [];
            $userId = null;
            $user = null;

            if ($data) {
                $users = $data['users'];
                $userId = $data['userId'];

                if ($userId) {
                    $staff = Staff::find(decryptFunction($userId));
                    if ($staff) {
                        $userId = $staff->id;
                        $user = $staff;
                    }
                }
            }
            $data = array_merge($data ?? [], [
                'user_id' => $userId,
                'user' => $user,
                'users' => $users,
                'title' => ___('live_chat.Live_Chat')
            ]);

            $content['last_page'] = null;
            $content['html'] = view('livechat::partials.student-chat-list')->with($data)->render();

            return response()->json([
                'message' => ___('live_chat.Live_Chat'),
                'result' => true,
                'data' => $content
            ]);
        } catch (\Exception $e) {
            dd($e);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    // live chat
    public function instructorLiveChat()
    {
        try {
            $data['title'] = ___('live_chat.Live_Chat'); // title
            return view('livechat::instructor.live_chat', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // live chat

    public function instructorChatList(Request $request)
    {
        try {
            $data = $this->live_chat->instructorChatList($request);
            $users = [];
            $userId = null;
            $user = null;

            if ($data) {
                $users = $data['users'];
                $userId = $data['userId'];

                if ($userId) {
                    $staff = Student::find(decryptFunction($userId));
                    if ($staff) {
                        $userId = $staff->id;
                        $user = $staff;
                    }
                }
            }

            $admins = User::whereIn('role_id', [RoleEnum::SUPERADMIN, RoleEnum::ADMIN])
                ->whereHas('messages', function ($query) {
                    $query->where('receiver_id', auth()->id()); // Find messages sent to the authenticated user
                })
                ->get();

            $data = array_merge($data ?? [], [
                'user_id' => $userId,
                'user' => $user,
                'users' => $users,
                'admins' => $admins,
                'title' => ___('live_chat.Live_Chat')
            ]);

            $content['last_page'] = null;
            $content['html'] = view('livechat::partials.instructor-chat-list')->with($data)->render();

            return response()->json([
                'message' => ___('live_chat.Live_Chat'),
                'result' => true,
                'data' => $content
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // live chat
    public function guardianLiveChat()
    {
        try {
            $data['title'] = ___('live_chat.Live_Chat'); // title
            return view('livechat::guardian.live_chat', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // live chat

    public function guardianChatList(Request $request)
    {
        try {
            $data = $this->live_chat->guardianChatList($request);
            $users = [];
            $userId = null;
            $user = null;

            if ($data) {
                $users = $data['users'];
                $userId = $data['userId'];

                if ($userId) {
                    $staff = Staff::find(decryptFunction($userId));
                    if ($staff) {
                        $userId = $staff->id;
                        $user = $staff;
                    }
                }
            }

            $data = array_merge($data ?? [], [
                'user_id' => $userId,
                'user' => $user,
                'users' => $users,
                'title' => ___('live_chat.Live_Chat')
            ]);

            $content['last_page'] = null;
            $content['html'] = view('livechat::partials.guardian-chat-list')->with($data)->render();

            return response()->json([
                'message' => ___('live_chat.Live_Chat'),
                'result' => true,
                'data' => $content
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
