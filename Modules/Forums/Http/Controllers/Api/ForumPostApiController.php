<?php

namespace Modules\Forums\Http\Controllers\Api;

use Carbon\Carbon;
use App\Enums\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\RedirectResponse;
use Modules\Forums\Entities\ForumPost;
use Illuminate\Support\Facades\Validator;
use Modules\Forums\Entities\ForumPostComment;
use Modules\Forums\Transformers\Api\ForumPostFeedResource;
use Modules\Forums\Transformers\Api\ForumPostListResource;
use Modules\Forums\Transformers\Api\ForumPostCommentResource;

class ForumPostApiController extends Controller
{

    use ApiReturnFormatTrait;
    use CommonHelperTrait;

    public function index()
    {
        $forumPosts = ForumPost::with('publisher:id,name,upload_id', 'approver:id,name,upload_id')
            ->where('created_by',auth()->id())
            ->latest()->paginate(10);
        ForumPostListResource::collection($forumPosts);
        return $this->responseWithSuccess('Forum Posts',  $forumPosts, 200);
    }


    public function feeds()
    {
         $forumPosts = ForumPost::with('publisher:id,name,upload_id', 'approver:id,name,upload_id','comments.replies')
            ->where(function ($query) {
              return  $userRoleId = auth()->user()->role_id;
                // If the user is not role_id = 1, apply the condition
                if ($userRoleId != 1) {
                    $query->where(function ($subQuery) use ($userRoleId) {
                        // Either target_roles is null, OR it contains the user's role_id
                        $subQuery->whereNull('target_roles')
                            ->orWhereJsonContains('target_roles', $userRoleId);
                    });
                }
            })
            ->latest()->where('status', 1)->where('is_published',1)->paginate(10);
        ForumPostFeedResource::collection($forumPosts);
        return $this->responseWithSuccess('Forum Posts',  $forumPosts, 200);
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
            [
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Errors', $validate->errors(), 422);
            }

            $upload_id         = $this->UploadImageCreate($request->image, 'backend/uploads/forums') ?? null;

            // Create a new forum post
            $forumPost = ForumPost::create([
                'slug' => Str::slug(Str::limit($request->description, 20)),
                'description' => $request->description,
                'upload_id' => $upload_id,
                'created_by' => auth()->id(),
            ]);
            return $this->responseWithSuccess('Forum Post Store',  $forumPost, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->responseWithError('Forum Post Failed',  $th->getMessage(), 400);
        }
    }


    public function show(ForumPost $forumPost)
    {
        return response()->json($forumPost, 200);
    }


    public function feedComments($id){
        $comments = ForumPostComment::where('forum_post_id',$id)->whereNull('parent_id')->with('replies')->get();
        $data = ForumPostCommentResource::collection($comments);
        return $this->responseWithSuccess('Forum Post commentys',  $data, 200);
    }

    // Update a forum post
    public function update(Request $request)
    {
        $forumPost = ForumPost::where('id',$request->id)->where('published_by', auth()->id())->first();
        if(!$forumPost){
            return $this->responseWithError('Not Found or Invalid Request', [], 404);
        }
        // Validate request
        $validate = Validator::make($request->all(),[
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validate->fails()){
            return $this->responseWithError('Validation Errors', $validate->errors(), 422);
        }
        // Update the forum post
        $forumPost->update([
            'slug' => Str::slug(Str::limit($request->description, 20)),
            'description' => $request->description,
            'upload_id'    => $request->hasFile('image') ? $this->UploadImageUpdate($request->image, 'backend/uploads/forums', $forumPost->upload_id) : $forumPost->upload_id
        ]);
        return response()->json($forumPost, 200);
    }


    // Delete a forum post
    public function destroy(ForumPost $forumPost)
    {
        $forumPost->delete();
        return response()->json(null, 204);
    }



    public function commentStore(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
            [
                'comment' => 'required',
                'forum_post_id' => 'required|exists:forum_posts,id',
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Errors', $validate->errors(), 422);
            }
            // Create a new forum post
            $forumPost = ForumPostComment::create([
                'comment' => $request->comment,
                'forum_post_id' => $request->forum_post_id,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
            ]);
            return $this->responseWithSuccess('Forum Comment Store',  $forumPost, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError('Forum Comment Store Failed',  $th->getMessage(), 400);
        }
    }


    public function commentReplyStore(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
            [
                'comment' => 'required',
                'forum_post_id' => 'required|exists:forum_posts,id',
                'comment_id' => 'required|exists:forum_post_comments,id',
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Errors', $validate->errors(), 422);
            }

            $forumPost = ForumPostComment::create([
                'comment' => $request->comment,
                'forum_post_id' => $request->forum_post_id,
                'parent_id' => $request->comment_id,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
            ]);
            return $this->responseWithSuccess('Forum Comment Reply Store',  $forumPost, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError('Forum Comment Reply Failed',  $th->getMessage(), 400);
        }
    }
}
