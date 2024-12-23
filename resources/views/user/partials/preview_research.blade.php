@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 py-8">
    <!-- Progress Tracker -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
            <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

            <!-- Steps -->
            <div class="relative flex justify-between">
                <!-- Step 1: Complete -->
                <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Authors</span>
            </div>

                <!-- Step 2: Complete -->
                <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Authors</span>
            </div>

                <!-- Step 3: Active -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 ring-4 ring-green-100">
                        3
                    </div>
                    <span class="text-sm font-medium text-green-600">Preview</span>
                </div>

                <!-- Step 4: Pending -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
                        4
                    </div>
                    <span class="text-sm font-medium text-gray-500">Confirm</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Preview Submission</h2>
                <p class="text-green-100 text-sm mt-2">Review your submission details before proceeding.</p>
            </div>

            <!-- Split Preview Content -->
            <div class="flex flex-col lg:flex-row">                
                <!-- Left Side: Abstract and Details -->
                <div class="w-full lg:w-1/2 p-6 border border-gray-800">
                    <div class="space-y-6">
                        <!-- Article Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Article Details</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Title</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $articleTitle ?? 'No title provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Sub-Theme</h4>
                                        <p class="mt-1 text-base text-gray-900">{{ $subTheme ?? 'No sub-theme provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Keywords</h4>
                                        <div class="mt-1 flex flex-wrap gap-2">
                                            @forelse($keywords ?? [] as $keyword)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    {{ $keyword }}
                                                </span>
                                            @empty
                                                <p class="text-base text-gray-900">No keywords provided</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Abstract -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="prose max-w-none">
                                    {{ $abstract ?? 'No abstract provided' }}
                                </div>
                                <div class="mt-4 text-sm text-gray-500">
                                    Word count: {{ str_word_count($abstract ?? '') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Document Preview -->
                <div class="w-full lg:w-1/2 p-6 border border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Preview</h3>
                    <div class="bg-gray-50 rounded-lg h-[calc(100vh-400px)] min-h-[500px]">
                        @if(isset($documentPath))
                            @if(pathinfo($documentPath, PATHINFO_EXTENSION) === 'pdf')
                                <embed src="{{ route('preview.document', ['path' => $documentPath]) }}"
                                       type="application/pdf"
                                       class="w-full h-full rounded-lg"
                                       pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                            @else
                                <div class="flex flex-col items-center justify-center h-full p-6">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                    </svg>
                                    <p class="text-gray-900 font-medium mb-2">{{ basename($documentPath) }}</p>
                                    <a href="{{ route('preview.document', ['path' => $documentPath]) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Open Document
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500">No document uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Previous
                    </a>
                    <!-- Dropdown for "Go to Step" -->
                <div class="relative">
                    <select id="stepNavigation" class="block w-full px-4 py-2 pr-8 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="1">Go to Step 1: Authors</option>
                        <option value="2">Go to Step 2: Abstract</option>
                        <option value="3">Go to Step 3: Preview</option>
                        <option value="4" selected>Step 4: Confirm</option>
                    </select>
                </div>
                    <a href="{{route('reviewer.confirm_research')}}" 
                       class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Continue to Confirmation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection