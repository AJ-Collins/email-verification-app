@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<!-- Enhanced Document Management Section -->
<div x-data="{ activeTab: 'abstracts', searchQuery: '', showFilters: false, statusFilter: 'all' }">
    <div class="border-b border-gray-200 shadow-sm bg-white">
        <div class="flex justify-between items-center p-4">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Document Assessment</h2>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search documents..."
                        class="w-64 px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button 
                    @click="showFilters = !showFilters"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border border-gray-300 rounded-md flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Filter Panel -->
    <div x-show="showFilters" class="bg-gray-50 p-4 border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select x-model="statusFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date Range</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                    <option>Custom range</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Priority</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option>All Priorities</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sort By</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option>Most Recent</option>
                    <option>Oldest First</option>
                    <option>Priority (High-Low)</option>
                    <option>Priority (Low-High)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Enhanced Tabbed Navigation Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'abstracts', 'border-transparent': activeTab !== 'abstracts' }"
                @click="activeTab = 'abstracts'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Abstracts
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">5</span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'articles', 'border-transparent': activeTab !== 'articles' }"
                @click="activeTab = 'articles'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Articles
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">4</span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Research Proposals
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">3</span>
            </button>
        </div>
    </div>

    <!-- Enhanced Tab Content -->
    <div class="bg-white shadow-sm">
        <!-- Enhanced Abstracts Tab -->
        <div x-show="activeTab === 'abstracts'" class="overflow-x-auto" x-data="{ selectedItems: [] }">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-8 px-4 py-2">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Document Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Category</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Priority</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Enhanced Example Submission -->
                    <tr class="border border-b hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Abstract_Research_2024.pdf</div>
                                    <div class="text-xs text-gray-500">2.4 MB</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Healthcare</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900">Medical Innovation Quarterly</div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">High</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">To Review</span>
                        </td>
                        <td class="px-4 py-3 text-center">
        <!-- Trigger Button -->
        <div class="flex justify-center p-4">
        <a href="{{ route('reviewer.partials.assessment') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Assess
</a>
        </div>
                                 
                                <button class="group relative p-2 text-gray-600 hover:text-green-600 rounded-full hover:bg-green-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Accept</span>
                                </button>
                                <button class="group relative p-2 text-gray-600 hover:text-red-600 rounded-full hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Reject</span>
                                </button>
                                <button class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Download</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="flex items-center justify-between px-4 py-3 border-t border-gray-200">
                <div class="flex items-center">
                    <label class="mr-2 text-sm text-gray-600">Show</label>
                    <select class="border-gray-300 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span class="ml-2 text-sm text-gray-600">entries</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">1</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>

        <!-- Articles Tab (Hidden by default) -->
        <div x-show="activeTab === 'articles'" class="p-4" style="display: none;">
            <!-- Similar structure as Abstracts tab -->
        </div>

        <!-- Research Proposals Tab (Hidden by default) -->
        <div x-show="activeTab === 'proposals'" class="p-4" style="display: none;">
            <!-- Similar structure as Abstracts tab -->
        </div>
    </div>
</div>

<!-- Enhanced Document Review Form -->
<!-- Enhanced Document Review Form -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm" x-data="{ rating: 0, feedbackType: 'general', showGuide: false }">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Review Document</h3>
        <button 
            @click="showGuide = !showGuide"
            class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Review Guidelines
        </button>
    </div>

    <!-- Review Guidelines Panel -->
    <div x-show="showGuide" class="mb-6 bg-indigo-50 p-4 rounded-lg">
        <h4 class="font-medium text-indigo-800 mb-2">Review Guidelines</h4>
        <ul class="text-sm text-indigo-700 space-y-2">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Provide specific, actionable feedback that helps authors improve their work
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Be constructive and respectful in your criticism
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Support your assessment with concrete examples
            </li>
        </ul>
    </div>
</div>

@endsection