<?php

namespace Modules\Forums\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Modules\Forums\Entities\Memory;
use Modules\Forums\Entities\MemoryGallery;
use Modules\MainApp\Entities\User;
use function Nette\Utils\data;

class MemoryController extends Controller
{

    use CommonHelperTrait, ApiReturnFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publisher = User::where('role_id', request('publisher'))->first()->id ?? null;
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('memory.Memory List');
        $data['roles'] = Role::pluck('name', 'id');
        $query = Memory::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
            ->latest()
            ->when($publisher, function ($q) use ($publisher) {
                return $q->where('created_by', $publisher);
            })
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

        $data['memories'] = $query->paginate(10);
        $data['superadmin'] = true;
        return view('forums::memory.index')->with($data);
    }

    public function myIndex()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('memory.Memory List');
        $data['roles'] = Role::pluck('name', 'id');
        $query = Memory::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
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

        $data['memories'] = $query->paginate(10);
        $data['superadmin'] = false;
        return view('forums::memory.index')->with($data);
    }

    public function indexStudent()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('memory.Memory List');
        $data['roles'] = Role::pluck('name', 'id');
        $query = Memory::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
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

        $data['memories'] = $query->paginate(10);
        return view('forums::students_memory.index')->with($data);
    }

    public function indexParent()
    {
        $status = request('status');
        $publishedStatus = request('published_status');
        $approvalStatus = request('approval_status');
        $keyword = request('keyword');

        $data['title'] = ___('memory.Memory List');
        $data['roles'] = Role::pluck('name', 'id');
        $query = Memory::with(['publisher:id,name,upload_id', 'approver:id,name,upload_id'])
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

        $data['memories'] = $query->paginate(10);
        return view('forums::parents_memory.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = ___('memory.Add New Memory');
        return view('forums::memory.create')->with($data);
    }

    public function createStudent()
    {
        $data['title'] = ___('memory.Add New Memory');
        return view('forums::students_memory.create')->with($data);
    }

    public function createParent()
    {
        $data['title'] = ___('memory.Add New Memory');
        return view('forums::parents_memory.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->inputValidation($request);
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            $memory = Memory::create([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
                'is_published' => 1
            ]);

            if ($memory) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function storeStudent(Request $request)
    {
        $this->inputValidation($request);
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            $memory = Memory::create([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'is_published' => 1
            ]);

            if ($memory) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('student-panel-memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function storeParent(Request $request)
    {
        $this->inputValidation($request);
        try {
            $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            $memory = Memory::create([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::PENDING,
                'approved_at' => Carbon::now(),
                'is_published' => 1
            ]);

            if ($memory) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('parent-panel-memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data['title'] = ___('memory.Memory Details');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::memory.show')->with($data);
    }
    public function showStudent($id)
    {
        $data['title'] = ___('memory.Memory Details');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::students_memory.show')->with($data);
    }
    public function showParent($id)
    {
        $data['title'] = ___('memory.Memory Details');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::parents_memory.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = ___('memory.Edit Memory');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::memory.edit')->with($data);
    }

    public function editStudent($id)
    {
        $data['title'] = ___('memory.Edit Memory');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::students_memory.edit')->with($data);
    }

    public function editParent($id)
    {
        $data['title'] = ___('memory.Edit Memory');
        $data['memory'] = Memory::with('galleries')->find($id);
        return view('forums::parents_memory.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->inputValidation($request, $id);
        try {
            $memory = Memory::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            } else {
                $upload_id = $memory->feature_image_id;
            }

            $memory->update([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
            ]);

            if ($memory && !empty($request->gallery_images)) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function updateStudent(Request $request, $id): RedirectResponse
    {
        $this->inputValidation($request, $id);
        try {
            $memory = Memory::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            } else {
                $upload_id = $memory->feature_image_id;
            }

            $memory->update([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
            ]);

            if ($memory && !empty($request->gallery_images)) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('student-panel-memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function updateParent(Request $request, $id): RedirectResponse
    {
        $this->inputValidation($request, $id);
        try {
            $memory = Memory::find($id);

            if ($request->filled('image')) {
                $upload_id = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            } else {
                $upload_id = $memory->feature_image_id;
            }

            $memory->update([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approval_status' => ApprovalStatus::APPROVED,
                'approved_at' => Carbon::now(),
            ]);

            if ($memory && !empty($request->gallery_images)) {
                foreach ($request->gallery_images as $gallery) {
                    $gallery_id = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return redirect()->route('parent-panel-memory.index')->with('success', ___('alert.Memory created successfully'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('danger', ___('alert.Something went wrong'));
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $forum = Memory::find($id);
            if ($request->status === ApprovalStatus::REJECTED) {
                $forum->approved_by = null;
                $forum->approved_at = null;
                $forum->rejected_by = auth()->id();
                $forum->approval_status = ApprovalStatus::REJECTED;
                $forum->save();
                return redirect()->route('memory.index')->with('success', ___('alert.Memory rejected successfully'));
            }

            if ($request->status === ApprovalStatus::PENDING) {
                $forum->approved_by = null;
                $forum->approved_at = null;
                $forum->pending_by = auth()->id();
                $forum->approval_status = ApprovalStatus::PENDING;
                $forum->save();
                return redirect()->route('memory.index')->with('success', ___('alert.Memory status changed to pending successfully'));
            }

            if ($request->status === 'approved'){
                $forum->approved_by = auth()->id();
                $forum->approved_at = now();
                $forum->approval_status = ApprovalStatus::APPROVED;
                $forum->save();
                return redirect()->route('memory.index')->with('success', ___('alert.Memory approved successfully'));
            }

            if ($request->status === 'published'){
                $forum->is_published = true;
                $forum->published_by = auth()->id();
                $forum->published_at = now();
                $forum->save();
                return redirect()->route('memory.index')->with('success', ___('alert.Memory published successfully'));
            }

            if ($request->status === 'unpublished'){
                $forum->is_published = false;
                $forum->published_by = null;
                $forum->published_at = null;
                $forum->save();
                return redirect()->route('memory.index')->with('success', ___('alert.Memory unpublished successfully'));
            }

            return redirect()->route('memory.index')->with('success', ___('alert.Invalid status'));
        }catch (\Throwable $th) {
            return redirect()->back()->with('danger', __('alert.something_went_wrong_please_try_again'));
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $memory = Memory::find($id);
            $deleted = $memory->delete();
            if ($deleted):
                $success[0] = 'Memory deleted successfully';
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

    public function deleteGalleryImage($id)
    {
        try {
            $gallery = MemoryGallery::find($id);
            $deleted = $gallery->delete();
            if ($deleted):
                $success[0] = 'Gallery deleted successfully';
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


    private function inputValidation($request, $id = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'gallery_images' => ($id ? 'nullable' : 'required') . '|array',
            'image' => ($id ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
}
