<?php

namespace App\Http\Controllers\admin\config\credentials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReferenceController;
// use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
    // Editable
    public function definedVar($key) {
        $entytyName = 'User';
        $routeName = 'users';
        $modelName = 'App\User';
        $isSoftDelete = 1;
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
            'Full Name' => [
                'name' => 'name',
                'type' => 'string',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'string',
                'validation' => 'required|max:255',
            ],
            'Email' => [
                'name' => 'email',
                'type' => 'string',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'string',
                'validation' => 'required|max:255|email|unique:users,email' . ($id != '' ? ',' . $id : ''),
            ],
            'Username' => [
                'name' => 'username',
                'type' => 'string',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'string',
                'validation' => 'required|max:255|unique:users,username' . ($id != '' ? ',' . $id : ''),
            ],
            'Roles' => [
                'name' => 'roles',
                'type' => 'relation',
                'index' => 1, 'show' => 1, 'edit' => 1,
                'validation' => 'required',
                'relation' => 'hasMany',
                'method' => 'getRoleNames',
                'relationRef' => 'roles',
                'relationMap' => 'userRole',
            ],
            'New Password' => [
                'name' => 'password',
                'type' => 'password',
                'index' => 0, 'show' => 0, 'edit' => 1,
                'validation' => 'same:confirm-password',
            ],
            'Confirm New Password' => [
                'name' => 'confirm-password',
                'type' => 'password',
                'index' => 0, 'show' => 0, 'edit' => 1
            ],
            'Alias' => [
                'name' => 'alias',
                'type' => 'string',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'string',
                'validation' => 'required|max:255',
            ],
            'Is Active' => [
                'name' => 'is_active',
                'type' => 'boolean',
                'index' => 1, 'show' => 1, 'edit' => 1, 'search' => 'boolean',
                'validation' => 'in:0,1',
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
            'Email Verified At' => [
                'name' => 'email_verified_at',
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
    public function additionFormData($action, $id, $maindata)
    {
        $otherdatas = null;
        $roles = Role::pluck('name', 'name')->all();
        $otherdatas[0] = ['roles', $roles];

        if (!is_null($id) && !is_null($maindata)) {
            $userRole = $maindata->roles->pluck('name', 'name')->all();
            $otherdatas[1] = ['userRole', $userRole];
        }
        return $otherdatas;
    }
    // Editable
    public function storeInputMutator($request)
    {
        $input = $request->all();
        $input['is_active'] = $request->has('is_active');
        $input['password'] = Hash::make($input['password']);
        return $input;
    }
    // Editable
    public function updateInputMutator($request)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        else{
            $input = array_except($input,array('password'));
        }
        $input['is_active'] = $request->has('is_active');
        return $input;
    }
    // Editable
    public function additionStore($maindata, $request, $status = true)
    {
        $input = $request->all();
        $status = $maindata->assignRole($request->input('roles'));
        return $status;
    }
    // Editable
    public function additionUpdate($maindata, $request, $id, $status = true)
    {
        $input = $request->all();
        $status = DB::table('model_has_roles')->where('model_id',$id)->delete();
        $maindata->assignRole($request->input('roles'));
        return $status;
    }
    // Editable
    public function additionDestroy($maindata)
    {
        if (auth()->user()->id == $maindata->id) {
            return 'You cannot delete yourself!';
        }
    }
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
    //
    //
    //
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
