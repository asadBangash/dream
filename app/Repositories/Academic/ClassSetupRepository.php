<?php

namespace App\Repositories\Academic;

use App\Enums\ApiStatus;
use App\Traits\ReturnFormatTrait;
use App\Models\Academic\ClassSetup;
use App\Interfaces\Academic\ClassSetupInterface;
use App\Models\Academic\ClassSetupChildren;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ClassSetupRepository implements ClassSetupInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ClassSetup $model)
    {
        $this->model = $model;
    }

    public function getSections($id) // class id
    {

        $result = $this->model->active()->where('classes_id', $id)->where('session_id', setting('session'))->first();
        return ClassSetupChildren::with('section')->where('class_setup_id', @$result->id)->select('section_id')->get()->unique('section_id');
    }
    public function promoteClasses($id) // session id
    {
        return $this->model->active()->where('session_id', $id)->get();
    }
    public function promoteSections($session_id, $classes_id) //session id, class id
    {
        $result = $this->model->active()->where('classes_id', $classes_id)->where('session_id', $session_id)->first();
        return ClassSetupChildren::with('section')->where('class_setup_id', @$result->id)->select('section_id')->get();
    }

    public function all()
    {
        return $this->model->where('session_id', setting('session'))->active()->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $sessionId = setting('session');
            if (! $sessionId) {
                return $this->responseWithError(___('student_info.select_session'), []);
            }

            $branchId = hasModule('MultiBranch') ? branchIdForPersist($request) : 1;

            if (hasModule('MultiBranch') && ! isSuperAdmin() && $branchId < 1) {
                return $this->responseWithError(___('branch.select_branch'), []);
            }

            if (hasModule('MultiBranch') && $branchId > 0) {
                $class = Classes::withoutGlobalScopes()->find($request->classes);
                if (! $class || (int) $class->branch_id !== $branchId) {
                    return $this->responseWithError(___('branch.select_branch'), []);
                }

                $sectionIds = array_filter($request->sections ?? []);
                if ($sectionIds !== []) {
                    $validCount = Section::withoutGlobalScopes()
                        ->whereIn('id', $sectionIds)
                        ->where('branch_id', $branchId)
                        ->count();
                    if ($validCount !== count($sectionIds)) {
                        return $this->responseWithError(___('branch.select_branch'), []);
                    }
                }
            }

            $duplicate = $this->model::query()
                ->where('session_id', $sessionId)
                ->where('classes_id', $request->classes)
                ->when(hasModule('MultiBranch') && $branchId > 0, fn ($q) => $q->where('branch_id', $branchId))
                ->first();

            if ($duplicate) {
                return $this->responseWithError(___('alert.there_is_already_a_class_for_this_session'), []);
            }

            $setup             = new $this->model;
            $setup->session_id = $sessionId;
            $setup->classes_id = $request->classes;
            $setup->status     = $request->status;
            applyBranchIdToModel($setup, $branchId);
            $setup->save();

            foreach ($request->sections ?? [] as $item) {
                $row = new ClassSetupChildren();
                $row->class_setup_id = $setup->id;
                $row->section_id     = $item;
                $row->status         = $request->status;
                applyBranchIdToModel($row, $branchId);
                $row->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (HttpExceptionInterface $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $branchId = hasModule('MultiBranch')
                ? (int) ($this->model->findOrFail($id)->branch_id ?: branchIdForPersist($request))
                : 1;

            $duplicate = $this->model::query()
                ->where('session_id', setting('session'))
                ->where('classes_id', $request->classes)
                ->where('id', '!=', $id)
                ->when(hasModule('MultiBranch'), fn ($q) => $q->where('branch_id', $branchId))
                ->first();

            if ($duplicate) {
                return $this->responseWithError(___('alert.there_is_already_a_class_for_this_session'), []);
            }

            $setup              = $this->model->findOrfail($id);
            $setup->classes_id  = $request->classes;
            $setup->status      = $request->status;
            $setup->save();

            ClassSetupChildren::where('class_setup_id', $setup->id)->delete();

            foreach ($request->sections ?? [] as $item) {
                $row = new ClassSetupChildren();
                $row->class_setup_id = $setup->id;
                $row->section_id     = $item;
                $row->status         = $request->status;
                applyBranchIdToModel($row, $branchId);
                $row->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (HttpExceptionInterface $e) {
            DB::rollBack();
            throw $e;
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
