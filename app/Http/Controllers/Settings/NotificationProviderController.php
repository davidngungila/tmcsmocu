<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\NotificationProvider;
use Illuminate\Http\Request;

class NotificationProviderController extends Controller
{
    public function index()
    {
        $providers = NotificationProvider::orderBy('type')->orderBy('is_primary', 'desc')->get();
        return view('settings.notification-providers.index', compact('providers'));
    }

    public function create()
    {
        return view('settings.notification-providers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sms_username' => 'nullable|string|max:255',
            'sms_password' => 'nullable|string|max:255',
            'sms_from' => 'nullable|string|max:255',
            'sms_url' => 'nullable|url|max:500',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $provider = NotificationProvider::create($validated);

        // If set as primary, update others
        if ($validated['is_primary'] ?? false) {
            $provider->setAsPrimary();
        }

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider created successfully.');
    }

    public function edit($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        return view('settings.notification-providers.edit', compact('provider'));
    }

    public function update(Request $request, $id)
    {
        $provider = NotificationProvider::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sms_username' => 'nullable|string|max:255',
            'sms_password' => 'nullable|string|max:255',
            'sms_from' => 'nullable|string|max:255',
            'sms_url' => 'nullable|url|max:500',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $provider->update($validated);

        // If set as primary, update others
        if ($validated['is_primary'] ?? false) {
            $provider->setAsPrimary();
        }

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider updated successfully.');
    }

    public function destroy($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $provider->delete();

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider deleted successfully.');
    }

    public function setPrimary($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $provider->setAsPrimary();

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Provider set as primary successfully.');
    }
}

