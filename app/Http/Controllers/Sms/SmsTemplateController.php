<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function index()
    {
        $templates = SmsTemplate::with('creator')->latest()->paginate(20);
        return view('sms.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('sms.templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:160',
            'language' => 'required|in:swahili,english',
        ]);

        $validated['created_by'] = auth()->id();

        SmsTemplate::create($validated);

        return redirect()->route('sms.templates.index')
            ->with('success', 'SMS template created successfully.');
    }

    public function edit($id)
    {
        $template = SmsTemplate::findOrFail($id);
        return view('sms.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = SmsTemplate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:160',
            'language' => 'required|in:swahili,english',
            'is_active' => 'boolean',
        ]);

        $template->update($validated);

        return redirect()->route('sms.templates.index')
            ->with('success', 'SMS template updated successfully.');
    }

    public function destroy($id)
    {
        $template = SmsTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('sms.templates.index')
            ->with('success', 'SMS template deleted successfully.');
    }
}
