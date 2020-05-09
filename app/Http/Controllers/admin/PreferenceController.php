<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Preference;
use Illuminate\Http\Request;
use Auth;

class PreferenceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('admin.preference');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Preference $preference)
    {
        //
    }

    public function edit(Preference $preference)
    {
        //
    }

    public function update(Request $request, Preference $preference)
    {
        //
    }

    public function destroy(Preference $preference)
    {
        //
    }

    public function ajaxRequestPost(Request $request)
    {
        $currentUserId = Auth::user()->id;
        $this->validate($request, [
            'search_panel_collapsed' => 'in:0,1',
            'sidebar_toggled' => 'in:0,1',
            'sidebar_item_collapsed' => 'in:0,1',
            'sidebar_item_collapsed_index' => 'int',
            'dark_mode' => 'in:0,1',
        ]);
        $foreignKey = ['user_id'   => $currentUserId];
        $input = $request->all();

        $isSaved = Preference::updateOrCreate($foreignKey, $input);
        if ($isSaved) {
            $stat = 'success';
            $msg = $isSaved->getChanges();
        }
        else {
            $stat = 'error';
            $msg = 'Failed to save';
        }
        return response()->json(['stat' => $stat, 'msg' => $msg]);
    }
}
