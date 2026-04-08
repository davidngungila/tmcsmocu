@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="space-y-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Announcements</h1>
        <p class="text-gray-600 mt-2">Stay updated with the latest news and announcements</p>
    </div>

    <!-- Featured Announcements -->
    @if(isset($featuredAnnouncements) && $featuredAnnouncements->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Featured Announcements</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredAnnouncements as $announcement)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Featured
                                </span>
                                <span class="ml-auto text-sm text-gray-500">
                                    {{ $announcement->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $announcement->title }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ \Illuminate\Support\Str::limit($announcement->content ?? '', 100) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    By {{ $announcement->author->name ?? 'System' }}
                                </span>
                                <a href="{{ route('communications.show-announcement', $announcement->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Announcements -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">All Announcements</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($announcements ?? [] as $announcement)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $announcement->title }}
                                </h3>
                                @if($announcement->is_featured ?? false)
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Featured
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 mb-3">
                                {{ \Illuminate\Support\Str::limit($announcement->content ?? '', 200) }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>By {{ $announcement->author->name ?? 'System' }}</span>
                                <span class="mx-2">·</span>
                                <span>{{ $announcement->created_at->format('M d, Y g:i A') }}</span>
                                <span class="mx-2">·</span>
                                <span>{{ $announcement->views ?? 0 }} views</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('communications.show-announcement', $announcement->id) }}" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <p class="text-lg font-medium mb-2">No announcements yet</p>
                    <p>Check back later for the latest announcements and updates.</p>
                </div>
            @endforelse
        </div>
        
        @if(isset($announcements) && $announcements->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
