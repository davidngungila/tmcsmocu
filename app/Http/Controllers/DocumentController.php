<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('documents.index')->with('success', 'Document created successfully!');
    }

    public function show($id)
    {
        return view('documents.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('documents.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully!');
    }
}
