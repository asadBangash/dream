<?php

namespace Modules\Forums\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Forums\Entities\ForumPost;
use Modules\Forums\Entities\ForumPostComment;
use Modules\Forums\Http\Requests\ForumPostRequest;
use Modules\MainApp\Entities\User;

class ForumsController extends Controller
{

    use CommonHelperTrait, ApiReturnFormatTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(request()->publisher);
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('settings.All Forums List');
        $data['roles'] = Role::pluck('name', 'id');

        $query = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest()
            ->when(request('publisher'), function ($q) {
                $q->whereJsonContains('target_roles',  (string) request('publisher'));
            })
            ->when(!blank($status), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when(!blank($publishedStatus), function ($q) use ($publishedStatus) {
                $q->where('is_published', $publishedStatus);
            })
            ->when(!blank($approvalStatus), function ($q) use ($approvalStatus) {
                $q->where('approval_status', $approvalStatus);
            })
            ->when(!blank($keyword), function ($q) use ($keyword) {
                $q->where(function ($query) use ($keyword) {
                    $query->where('description', 'like', '%' . $keyword . '%');
                });
            });

        $data['forums'] = $query->paginate(10);
        $data['superadmin'] = true;

        return view('forums::forum.index', compact('data'));
    }


    public function myIndex()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('settings.My Forums List');
        $data['roles'] = Role::pluck('name', 'id');

        $query = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest()
            ->where('created_by', auth()->user()->id)
            ->whereJsonContains('target_roles', (string) RoleEnum::SUPERADMIN)

            ->when(!blank($publishedStatus), function ($q) use ($publishedStatus) {
                return $q->where('is_published', $publishedStatus);
            })
            ->when($approvalStatus, function ($q) use ($approvalStatus) {
                return $q->where('approval_status', $approvalStatus);
            })
            ->when($keyword, function ($q) use ($keyword) {
                return $q->where(function ($query) use ($keyword) {
                    $query->where('description', 'like', '%' . $keyword . '%');
                });
            });

        $data['forums'] = $query->paginate(10);
        $data['superadmin'] = false;
        return view('forums::forum.index', compact('data'));
    }

    public function indexStudent()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('settings.All Forums List');
        $data['roles'] = Role::pluck('name', 'id');

        $query = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest()
            ->where('created_by', auth()->user()->id)
            ->when(!blank($status), function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when(!blank($publishedStatus), function ($q) use ($publishedStatus) {
                return $q->where('is_published', $publishedStatus);
            })
            ->when($approvalStatus, function ($q) use ($approvalStatus) {
                return $q->where('approval_status', $approvalStatus);
            })
            ->when($keyword, function ($q) use ($keyword) {
                return $q->where(function ($query) use ($keyword) {
                    $query->where('description', 'like', '%' . $keyword . '%');
                });
            });

        $data['forums'] = $query->paginate(10);
        return view('forums::students_forum.index', compact('data'));
    }

    public function indexParent()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('settings.All Forums List');
        $data['roles'] = Role::pluck('name', 'id');

        $query = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest()
            ->where('created_by', auth()->user()->id)
            ->when(!blank($status), function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when(!blank($publishedStatus), function ($q) use ($publishedStatus) {
                return $q->where('is_published', $publishedStatus);
            })
            ->when($approvalStatus, function ($q) use ($approvalStatus) {
                return $q->where('approval_status', $approvalStatus);
            })
            ->when($keyword, function ($q) use ($keyword) {
                return $q->where(function ($query) use ($keyword) {
                    $query->where('description', 'like', '%' . $keyword . '%');
                });
            });

        $data['forums'] = $query->paginate(10);
        return view('forums::parents_forum.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function feeds(Request $request)
    {
        $data['title'] = ___('forums.Feeds');
        $data['feeds'] = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest('id')
            ->whereJsonContains('target_roles', (string)RoleEnum::SUPERADMIN)
            ->paginate(10);
        return view('forums::forum.feeds')->with($data);
    }

    public function feedsStudent(Request $request)
    {
        $data['title'] = ___('forums.Feeds');
        $data['feeds'] = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest('id')
            ->whereJsonContains('target_roles', (string) RoleEnum::STUDENT)
            ->paginate(10);
        return view('forums::students_forum.feeds')->with($data);
    }

    public function feedsParent(Request $request)
    {
        $data['title'] = ___('forums.Feeds');
        $data['feeds'] = ForumPost::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest('id')
            ->whereJsonContains('target_roles', (string) RoleEnum::GUARDIAN)
            ->paginate(10);
        return view('forums::parents_forum.feeds')->with($data);
    }


    public function create()
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Add New Forum');
        return view('forums::forum.create')->with($data);
    }

    public function createStudent()
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Add New Forum');
        return view('forums::students_forum.create')->with($data);
    }
    public function createParent()
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Add New Forum');
        return view('forums::parents_forum.create')->with($data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ForumPostRequest $request)
    {
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;

            $postData  = [
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'status' => $request->status,
                'views_count' => $request->views_count,
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'created_by' => auth()->id(),
                'target_roles' => $request->target_roles,
            ];
            if ($request->is_published) {
                $postData['is_published'] = $request->is_published;
                $postData['published_by'] = auth()->id();
                $postData['published_at'] = Carbon::now();
            }
            ForumPost::create($postData);
            return redirect()->route('forum.index')->with('success', ___('alert.Forum added successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function storeStudent(ForumPostRequest $request)
    {
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;

            $postData  = [
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'status' => $request->status,
                // 'views_count' => $request->views_count,
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'created_by' => auth()->id(),
                'target_roles' => [json_encode(RoleEnum::STUDENT)],
            ];
            // if ($request->is_published){
            $postData['is_published'] = 1;
            $postData['published_by'] = auth()->id();
            $postData['published_at'] = Carbon::now();
            // }
            ForumPost::create($postData);
            return redirect()->route('student-panel-forum.index')->with('success', ___('alert.Forum added successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function storeParent(ForumPostRequest $request)
    {
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;

            $postData  = [
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'status' => $request->status,
                // 'views_count' => $request->views_count,
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'created_by' => auth()->id(),
                'target_roles' => [json_encode(RoleEnum::GUARDIAN)],
            ];
            // if ($request->is_published){
            $postData['is_published'] = 1;
            $postData['published_by'] = auth()->id();
            $postData['published_at'] = Carbon::now();
            // }
            ForumPost::create($postData);
            return redirect()->route('parent-panel-forum.index')->with('success', ___('alert.Forum added successfully'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data['forum'] = ForumPost::with('upload', 'comments')->find($id);
        if ($data['forum'] && auth()->user()->id != $data['forum']->created_by) {
            $data['forum']->increment('views_count');
        }
        $data['title'] = ___('settings.View Forum');
        return view('forums::forum.show')->with($data);
    }


    public function showStudent($id)
    {
        $data['forum'] = ForumPost::with('upload', 'comments')->find($id);
        if ($data['forum'] && auth()->user()->id != $data['forum']->created_by) {
            $data['forum']->increment('views_count');
        }
        $data['title'] = ___('settings.View Forum');
        return view('forums::students_forum.show')->with($data);
    }


    public function showParent($id)
    {
        $data['forum'] = ForumPost::with('upload', 'comments')->find($id);
        if ($data['forum'] && auth()->user()->id != $data['forum']->created_by) {
            $data['forum']->increment('views_count');
        }
        $data['title'] = ___('settings.View Forum');
        return view('forums::parents_forum.show')->with($data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Edit Forum');
        $data['forum'] = ForumPost::find($id);
        return view('forums::forum.edit')->with($data);
    }
    public function editStudent($id)
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Edit Forum');
        $data['forum'] = ForumPost::find($id);
        return view('forums::students_forum.edit')->with($data);
    }
    public function editParent($id)
    {
        $data['roles'] = Role::pluck('name', 'id');
        $data['title'] = ___('settings.Edit Forum');
        $data['forum'] = ForumPost::find($id);
        return view('forums::parents_forum.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ForumPostRequest $request, $id)
    {
        try {
            $forum = ForumPost::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;
            } else {
                $upload_id = $forum->upload_id;
            }

            $forum->update([
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'is_published' => $request->is_published,
                'status' => $request->status,
                'views_count' => $request->views_count,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'target_roles' => $request->target_roles,
            ]);
            return redirect()->route('forum.index')->with('success', ___('alert.Forum updated successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function updateStudent(ForumPostRequest $request, $id)
    {
        try {
            $forum = ForumPost::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;
            } else {
                $upload_id = $forum->upload_id;
            }

            $forum->update([
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'is_published' => 1,
                'status' => $request->status,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'target_roles' => [json_encode(RoleEnum::STUDENT)],
            ]);
            return redirect()->route('student-panel-forum.index')->with('success', ___('alert.Forum updated successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function updateParent(ForumPostRequest $request, $id)
    {
        try {
            $forum = ForumPost::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;
            } else {
                $upload_id = $forum->upload_id;
            }

            $forum->update([
                'slug' => Str::slug(Str::limit(strip_tags($request->description), 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'is_published' => 1,
                'status' => $request->status,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'approved_by' => auth()->user()->role_id == RoleEnum::SUPERADMIN ? auth()->id() : null,
                'target_roles' => [json_encode(RoleEnum::GUARDIAN)],
            ]);
            return redirect()->route('parent-panel-forum.index')->with('success', ___('alert.Forum updated successfully'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row  = ForumPost::find($id);
            if ($row) {
                $this->UploadImageDelete($row->upload_id);
            }
            $row->delete();

            DB::commit();
            if ($row):
                $success[0] = 'Forum post deleted successfully';
                $success[1] = 'success';
                $success[2] = ___('alert.deleted');
                $success[3] = ___('alert.OK');
                return response()->json($success);
            else:
                $success[0] = 'Something went wrong';
                $success[1] = 'error';
                $success[2] = ___('alert.oops');
                return response()->json($success);
            endif;
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function changeStatus(Request $request, $id)
    {
        try {
            $forum = ForumPost::find($id);
            if ($request->status === ApprovalStatus::REJECTED) {
                $forum->approved_by = null;
                $forum->approved_at = null;
                $forum->rejected_by = auth()->id();
                $forum->approval_status = ApprovalStatus::REJECTED;
                $forum->save();
                return redirect()->route('forum.index')->with('success', ___('alert.Forum rejected successfully'));
            }

            if ($request->status === 'approved') {
                $forum->approved_by = auth()->id();
                $forum->approved_at = now();
                $forum->approval_status = ApprovalStatus::APPROVED;
                $forum->save();
                return redirect()->route('forum.index')->with('success', ___('alert.Forum approved successfully'));
            }

            if ($request->status === 'pending') {
                $forum->approved_by = auth()->id();
                $forum->approved_at = now();
                $forum->approval_status = ApprovalStatus::PENDING;
                $forum->pending_by = auth()->id();
                $forum->save();
                return redirect()->route('forum.index')->with('success', ___('alert.Forum status changed to pending successfully'));
            }

            if ($request->status === 'published') {
                $forum->is_published = true;
                $forum->published_by = auth()->id();
                $forum->published_at = now();
                $forum->save();
                return redirect()->route('forum.index')->with('success', ___('alert.Forum published successfully'));
            }

            if ($request->status === 'unpublished') {
                $forum->is_published = false;
                $forum->published_by = null;
                $forum->published_at = null;
                $forum->save();
                return redirect()->route('forum.index')->with('success', ___('alert.Forum unpublished successfully'));
            }

            return redirect()->route('forum.index')->with('success', ___('alert.Invalid status'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', __('alert.something_went_wrong_please_try_again'));
        }
    }

    public function commentStore(Request $request)
    {
        try {
            // Validate the request
            $validate = Validator::make($request->all(), [
                'comment' => 'required',
                'forum_post_id' => 'required|exists:forum_posts,id',
            ]);

            if ($validate->fails()) {
                return redirect()->back()
                    ->withErrors($validate->errors())
                    ->withInput();
            }

            // Prepare the data for creating a comment
            $commentData = [
                'comment' => $request->comment,
                'forum_post_id' => $request->forum_post_id,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
            ];

            // Create the forum post comment
            ForumPostComment::create($commentData);

            return redirect()
                ->back()
                ->with('success', ___('alert.Comment added successfully'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('danger', ___('alert.Something went wrong'))
                ->withInput();
        }
    }

    public function commentReply(Request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'comment' => 'required',
                    'forum_post_id' => 'required|exists:forum_posts,id',
                    'comment_id' => 'required|exists:forum_post_comments,id',
                ]
            );

            if ($validate->fails()) {
                return $this->responseWithError('Validation Errors', $validate->errors(), 422);
            }

            ForumPostComment::create([
                'comment' => $request->comment,
                'forum_post_id' => $request->forum_post_id,
                'parent_id' => $request->comment_id,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', ___('alert.Reply added successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', __('alert.something_went_wrong_please_try_again'));
        }
    }


    public function commentDelete($id)
    {
        try {
            $comment =  ForumPostComment::find($id);
            $deleted = $comment->delete();
            if ($deleted):
                $success[0] = 'Comment deleted successfully';
                $success[1] = 'success';
                $success[2] = ___('alert.deleted');
                $success[3] = ___('alert.OK');
                return response()->json($success);
            else:
                $success[0] = 'Something went wrong';
                $success[1] = 'error';
                $success[2] = ___('alert.oops');
                return response()->json($success);
            endif;
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


}
