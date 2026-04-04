@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Message Templates</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage reusable SMS templates</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('sms.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                Send SMS
            </a>
            <a href="{{ route('sms.broadcast') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Broadcast
            </a>
            <a href="{{ route('sms.templates.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Create Template
            </a>
        </div>
    </div>

    <!-- Templates Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($templates->count() > 0)
                        @foreach($templates as $template)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600" title="{{ $template->message }}">
                                    {{ Str::limit($template->message, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ $template->category ?? 'General' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $template->usage_count ?? 0 }} times</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $template->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button onclick="useTemplate('{{ $template->message }}')" class="text-purple-600 hover:text-purple-900">Use</button>
                                    <a href="{{ route('sms.templates.edit', $template->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('sms.templates.delete', $template->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0v6m0 0h6m-6 0v6m0 0h6m-6 0v6m0 0h6M6 6v12a2 2 0 002-2 2H4a2 2 0 00-2-2V6a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-2">No templates found</p>
                                    <p class="text-sm">Create templates to quickly reuse common messages.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function useTemplate(message) {
    // Store template in localStorage for use in SMS form
    localStorage.setItem('selectedTemplate', message);
    // Redirect to SMS create page
    window.location.href = '{{ route('sms.create') }}';
}
</script>
@endsection
