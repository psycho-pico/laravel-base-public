<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Pagination;

use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
/**
 *
 */
class ReferenceController
{

    public function index($origin, $request, $entytyName, $permissions, $columns, $modelName)
    {
        $originController = New $origin;

        $pagination = 10;
        $perpages = Pagination::orderBy('per_page', 'ASC')->get();

        if (isset($request->all()['perpage']) && is_numeric($request->all()['perpage']) && (int)$request->all()['perpage'] > 0 && (int)$request->all()['perpage'] < 1001) {
            $pagination = $request->all()['perpage'];
        }
        elseif (auth()->user()->getPreference && !is_null(auth()->user()->getPreference->table_row_per_page)) {
            $pagination = auth()->user()->getPreference->table_row_per_page;
        }

        $columnSearchables = array_filter($columns, function ($var) {
            return (isset($var['search']) && !is_null($var['search']));
        });

        $maindatas = $modelName::whereRaw('1 = 1');

        $requestKeys = array_keys($request->all());
        $requestValues = array_values($request->all());
        foreach ($columns as $columnsKey => $columnsValue) {
            if (isset($columnsValue['search']) && !is_null($columnsValue['search'])) {
                if ($exist = in_array($columnsValue['name'], $requestKeys)) {
                    $searchKey = $columnsValue['name'];
                    $searchValue = $requestValues[array_search($searchKey, $requestKeys)];
                    if (!is_null($searchValue)) {
                        if ($columnsValue['search'] == 'string' || $columnsValue['search'] == 'boolean') {
                            $maindatas = $maindatas->where($searchKey, 'like', '%' . $searchValue . '%');
                        }
                    }
                }
            }
        }

        if ($originController->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
            if (isset($request->all()['del']) && $request->all()['del'] == '1') {
                $maindatas = $maindatas->onlyTrashed();
            }
            elseif (isset($request->all()['withDel']) && $request->all()['withDel'] == '1') {
                $maindatas = $maindatas->withTrashed();
            }
        }

        $o = $request->all()['o'] ?? false;
        $s = $request->all()['s'] ?? 'ASC';
        $isO = $o ? in_array($o, array_column(array_values($columnSearchables), 'name')) : false;
        if ($o && $isO) {
            $maindatas = $maindatas->orderBy($o, $s);
        }
        else {
            if (!is_null($originController->definedVar('defaultOrderBy'))) {
                $defaultOrderBy = $originController->definedVar('defaultOrderBy')[0];
                $defaultOrderSort = $originController->definedVar('defaultOrderBy')[1];
            }
            else {
                if ($originController->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
                    if ((isset($request->all()['del']) && $request->all()['del'] == '1') || (isset($request->all()['withDel']) && $request->all()['withDel'] == '1')) {
                        $defaultOrderBy = 'deleted_at';
                        $defaultOrderSort = 'ASC';
                    }
                    else {
                        $defaultOrderBy = 'id';
                        $defaultOrderSort = 'DESC';
                    }
                }
                $defaultOrderBy = 'id';
                $defaultOrderSort = 'DESC';
            }
            $maindatas = $maindatas->orderBy($defaultOrderBy, $defaultOrderSort);
        }

        $maindatas = $maindatas->paginate($pagination);
        $maindatas = $maindatas->appends(request()->query());

        return view('admin.reference.index',compact(
            'entytyName',
            'permissions',
            'columns',
            'perpages',
            'maindatas'
        ))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }


    public function mainData($origin, $id, $modelName, $action)
    {
        $originController = New $origin;
        $maindata = $modelName::whereRaw('1 = 1');
        if ($originController->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
            $maindata = $maindata->withTrashed();
        }
        $maindata =  $maindata->find($id);
        if ($maindata != null && $action == 'Edit' && $maindata->deleted_at != null) {
            return null;
        }
        else {
            return $maindata;
        }
    }


    public function form($origin, $action, $id, $maindata, $columns, $routeName)
    {
        $compact = [
            'maindata',
            'entytyName',
            'action',
            'columns',
            'permissions'
        ];
        $originController = New $origin;
        $entytyName = $originController->definedVar('entytyName');
        $modelName = $originController->definedVar('modelName');
        $permissions = $originController->definedVar('permissions');
        $otherdatas = $originController->additionFormData($action, $id, $maindata);
        if (!is_null($otherdatas)) {
            foreach ($otherdatas as $key => $otherdata) {
                ${$otherdata[0]} = $otherdata[1];
                $compact = array_merge($compact, [$otherdata[0]]);
            }
        }
        if ($action == 'Edit' && $maindata == null) {
                $msgStatus = 'fail';
                $msg = $entytyName . ' not found';
                return redirect()->route($routeName . '.index')
                ->with($msgStatus, $msg);
        }
        return view('admin.reference.form',compact($compact));
    }


    public function store($origin, $request, $entytyName, $columns, $storeInputMutator, $modelName, $routeName)
    {
        $originController = New $origin;

        $columnsToValidate = array();
        foreach ($columns as $key => $value) {
            if ($value['edit'] == 1 && isset($value['validation']) && !is_null($value['validation']) ) {
                $columnsToValidate =  array_merge($columnsToValidate, [
                    $value['name'] => $value['validation'],
                ]);
            }
        }
        $request->validate($columnsToValidate);

        $input = array_except($storeInputMutator, array('prevPage'));
        $maindata = $modelName::create($input);

        $additionStore = $originController->additionStore($maindata, $request);

        $msgStatus = 'success';
        $msg = $entytyName . ' saved successfully';
        // return redirect()->route($routeName . '.index')
        return redirect($request->all()['prevPage'])
        ->with($msgStatus, $msg);
    }


    public function update($origin, $request, $entytyName, $columns, $updateInputMutator, $modelName, $routeName, $id)
    {
        $originController = New $origin;

        $columnsToValidate = array();
        foreach ($columns as $key => $value) {
            if ($value['edit'] == 1 && isset($value['validation']) && !is_null($value['validation']) ) {
                $columnsToValidate =  array_merge($columnsToValidate, [
                    $value['name'] => $value['validation'],
                ]);
            }
        }
        $request->validate($columnsToValidate);

        $input = $request->all();

        $maindata = $modelName::find($id);

        if (!is_null($id) && $id != '' && !is_null($maindata)) {
            $input = array_except($updateInputMutator, array('prevPage'));
            $update = $maindata->update($input);

            $additionStore = $originController->additionUpdate($maindata, $request, $id);

            if ($update) {
                $msgStatus = 'success';
                $msg = $entytyName . ' updated successfully';
            }
            else {
                $msgStatus = 'fail';
                $msg = $entytyName . ' failed to update';
            }
        }
        else {
            $msgStatus = 'fail';
            $msg = $entytyName . ' not found';
        }

        // return redirect()->route($routeName . '.index')
        return redirect($request->all()['prevPage'])
        ->with($msgStatus, $msg);
    }


    public function destroy($origin, $id, $entytyName, $modelName, $routeName)
    {
        $maindata = $modelName::find($id);
        if (!is_null($maindata)) {
            $originController = New $origin;
            $additionDestroy = $originController->additionDestroy($maindata);
            if (is_null($additionDestroy)) {
                $destroy = $maindata->delete();
                if ($destroy) {
                    $msgStatus = "success";
                    $msg = $entytyName . " deleted successfully";
                }
                else {
                    $msgStatus = "fail";
                    $msg = $entytyName . " failed to delete";
                }
            }
            else {
                $msgStatus = "fail";
                $msg = $additionDestroy;
            }
        }
        else {
            $msgStatus = "fail";
            $msg = $entytyName . " not found";
        }
        // return redirect()->route($routeName . '.index')
        return redirect()->back()
        ->with($msgStatus, $msg);
    }


    public function burn($origin, $id, $entytyName, $modelName, $routeName)
    {
        $originController = New $origin;
        if ($originController->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
            $maindata = $modelName::onlyTrashed()->find($id);
        }
        else {
            $maindata = null;
        }
        if (!is_null($maindata)) {
            $additionBurn = $originController->additionBurn($maindata);
            if (is_null($additionBurn)) {
                $burn = $maindata->forceDelete();
                if ($burn) {
                    $msgStatus = "success";
                    $msg = $entytyName . " burned down successfully";
                }
                else {
                    $msgStatus = "fail";
                    $msg = $entytyName . " failed to burn";
                }
            }
            else {
                $msgStatus = "fail";
                $msg = $additionBurn;
            }
        }
        else {
            $msgStatus = "fail";
            $msg = $entytyName . " not found";
        }
        // return redirect()->route($routeName . '.index')
        return redirect()->back()
        ->with($msgStatus, $msg);
    }


    public function restore($origin, $id, $entytyName, $modelName, $routeName)
    {
        $originController = New $origin;
        if ($originController->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
            $maindata = $modelName::onlyTrashed()->find($id);
        }
        else {
            $maindata = null;
        }
        if (!is_null($maindata)) {
            $additionRestore = $originController->additionRestore($maindata);
            if (is_null($additionRestore)) {
                $restore = $maindata->restore();
                if ($restore) {
                    $msgStatus = "success";
                    $msg = $entytyName . " restored successfully";
                }
                else {
                    $msgStatus = "fail";
                    $msg = $entytyName . " failed to restore";
                }
            }
            else {
                $msgStatus = "fail";
                $msg = $additionRestore;
            }
        }
        else {
            $msgStatus = "fail";
            $msg = $entytyName . " not found";
        }
        // return redirect()->route($routeName . '.index')
        return redirect()->back()
        ->with($msgStatus, $msg);
    }
}
