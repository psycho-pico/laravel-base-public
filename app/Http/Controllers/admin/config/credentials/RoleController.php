<?php

namespace App\Http\Controllers\admin\config\credentials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReferenceController;
use DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Editable
    public function definedVar($key) {
        $entytyName = 'Role';
        $routeName = 'roles';
        $modelName = 'Spatie\Permission\Models\Role';
        $isSoftDelete = 0;
        $defaultOrderBy = ['name', 'ASC'];
        $permissions = [
            'view' => 'config-view',
            'create' => 'config-create',
            'edit' => 'config-edit',
            'delete' => 'config-delete'
        ];

        try {
            $definedVar = ${$key};
            return $definedVar;
        } catch (\Exception $e) {
            // abort(500);
            return null;
        }
    }

    // Editable
    public function columns($id = '')
    {
        $columns = [
            'Name' => [
                'name' => 'name',
                'type' => 'string',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'string',
                'validation' => 'required|max:255|unique:permissions,name' . ($id != '' ? ',' . $id : ''),
            ],
            'Permission' => [
                'name' => 'permission',
                'type' => 'relation',
                'index' => 1, 'show' => 1, 'edit' => 1,
                'validation' => 'required',
                'relation' => 'hasMany',
                'method' => 'getPermissionNames',
                'relationRef' => 'permissionData',
                'relationMap' => 'rolePermissions',
            ],
            'Created At' => [
                'name' => 'created_at',
                'type' => 'timestamp',
                'index' => 0, 'show' => 1, 'edit' => 0,
            ],
            'Updated At' => [
                'name' => 'updated_at',
                'type' => 'timestamp',
                'index' => 0, 'show' => 1, 'edit' => 0,
            ],
        ];
        if ($this->definedVar('isSoftDelete') == 1 && auth()->user()->can('deleted-view')) {
            $columns =  array_merge($columns, [
                'Deleted' => [
                    'name' => 'deleted_at',
                    'type' => 'timestamp',
                    'index' => 1, 'show' => 1, 'edit' => 0,
                ],
            ]);
        }
        return $columns;
    }

    // Editable
    public function additionFormData($action, $id, $maindata) {
        $otherdatas = null;

        $permissionData = Permission::where('deleted_at', null)->pluck('name', 'id')->all();
        // $permission = Permission::get();
        $otherdatas[0] = ['permissionData', $permissionData];

        if (!is_null($id) && !is_null($maindata)) {
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
            $otherdatas[1] = ['rolePermissions', $rolePermissions];
        }

        return $otherdatas;
    }
    // Editable
    public function storeInputMutator($request)
    {
        $input = $request->all();
        $input = array_except($input,array('permission'));
        return $input;
    }
    // Editable
    public function updateInputMutator($request)
    {
        $input = $request->all();
        $input = array_except($input,array('permission'));
        return $input;
    }
    // Editable
    public function additionStore($maindata, $request, $status = true)
    {
        $status = $maindata->syncPermissions($request->input('permission'));
        return $status;
    }
    // Editable
    public function additionUpdate($maindata, $request, $status = true)
    {
        $status = $maindata->syncPermissions($request->input('permission'));
        return $status;
    }
    // Editable
    public function additionDestroy($maindata) {}
    // Editable
    public function additionBurn($maindata) {}
    // Editable
    public function additionRestore($maindata) {}

    //
    //
    //
    //
    //
    //

    function __construct()
    {
        $permissions = $this->definedVar('permissions');
        $this->middleware('permission:' . $permissions['view'] . '|' . $permissions['create'] . '|' . $permissions['edit'] . '|' . $permissions['delete'], ['only' => ['index','show']]);
        $this->middleware('permission:' . $permissions['create'], ['only' => ['create','store']]);
        $this->middleware('permission:' . $permissions['edit'], ['only' => ['edit','update']]);
        $this->middleware('permission:' . $permissions['delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->index(explode('@', app('request')->route()->getAction()['controller'])[0], $request, $this->definedVar('entytyName'), $this->definedVar('permissions'), $this->columns(), $this->definedVar('modelName'));
    }

    public function form($action, $id)
    {
        $columns = $this->columns();
        $ReferenceController = New ReferenceController;
        $maindata = !is_null($id) ? $ReferenceController->maindata(explode('@', app('request')->route()->getAction()['controller'])[0], $id, $this->definedVar('modelName'), $action) : null;
        return $ReferenceController->form(explode('@', app('request')->route()->getAction()['controller'])[0], $action, $id, $maindata, $columns, $this->definedVar('routeName'));
    }

    public function show($id)
    {
        return $this->form('Show', $id);
    }

    public function create()
    {
        return $this->form('Create', null);
    }

    public function edit($id)
    {
        return $this->form('Edit', $id);
    }

    public function store(Request $request)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->store(explode('@', app('request')->route()->getAction()['controller'])[0], $request, $this->definedVar('entytyName'), $this->columns(), $this->storeInputMutator($request), $this->definedVar('modelName'), $this->definedVar('routeName'));
    }

    public function update(Request $request, $id)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->update(explode('@', app('request')->route()->getAction()['controller'])[0], $request, $this->definedVar('entytyName'), $this->columns($id), $this->updateInputMutator($request), $this->definedVar('modelName'), $this->definedVar('routeName'), $id);
    }

    public function destroy($id)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->destroy(explode('@', app('request')->route()->getAction()['controller'])[0],$id,$this->definedVar('entytyName'),$this->definedVar('modelName'),$this->definedVar('routeName'));
    }

    public function burn($id)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->burn(explode('@', app('request')->route()->getAction()['controller'])[0],$id,$this->definedVar('entytyName'),$this->definedVar('modelName'),$this->definedVar('routeName'));
    }

    public function restore($id)
    {
        $ReferenceController = New ReferenceController;
        return $ReferenceController->restore(explode('@', app('request')->route()->getAction()['controller'])[0], $id, $this->definedVar('entytyName'), $this->definedVar('modelName'), $this->definedVar('routeName'));
    }
}
