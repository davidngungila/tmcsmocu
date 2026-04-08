@extends('layouts.app')

@section('title', $announcement->title ?? 'Announcement Details')

@section('content')
<div class="space-y-6">
    <div class="mb-6">
        <a href="{{ route('communications.announcements') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 inline-block">
            &larr; Back to Announcements
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ $announcement->title }}</h1>
        <div class="flex items-center text-sm text-gray-500 mt-2">
            <span>By {{ $announcement->author->name ?? 'System' }}</span>
            <span class="mx-2">·</span>
            <span>{{ $announcement->created_at->format('F d, Y g:i A') }}</span>
            <span class="mx-2">·</span>
            <span>{{ $announcement->views ?? 0 }} views</span>
            @if($announcement->is_featured ?? false)
                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Featured
                </span>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">{{ $announcement->content ?? 'No content available.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
