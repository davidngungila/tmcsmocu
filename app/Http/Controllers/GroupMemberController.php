<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index()
    {
        return view('groups.members.index');
    }

    public function add()
    {
        return view('groups.members.add');
    }

    public function store(Request $request)
    {
        return redirect()->route('groups.members')->with('success', 'Member added successfully!');
    }

    public function remove($id)
    {
        return redirect()->route('groups.members')->with('success', 'Member removed successfully!');
    }
}
