

<?php $__env->startSection('reviewer-content'); ?>
<!-- Enhanced Document Management Section -->
<div x-data="{ activeTab: 'articles', searchQuery: '', showFilters: false, statusFilter: 'all' }">
    <div class="border-b border-gray-200 shadow-sm bg-white">
        <div class="flex justify-between items-center p-4">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">In Review</h2>
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
            </div>
        </div>
    </div>
    <!-- Enhanced Tabbed Navigation Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'articles', 'border-transparent': activeTab !== 'articles' }"
                @click="activeTab = 'articles'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Articles
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs"><?php echo e($abstractCount); ?></span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Research Proposals
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs"><?php echo e($proposalCount); ?></span>
            </button>
        </div>
    </div>

    <!-- Enhanced Tab Content -->
        <div class="bg-white shadow-sm">
            <!-- Enhanced Abstracts Tab -->
            <div x-show="activeTab === 'articles'" class="overflow-x-auto" x-data="{ selectedItems: [] }">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Score</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Remarks</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($submission->title); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($submission->serial_number); ?></div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($submission->sub_theme); ?></td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700 group relative">
                                <?php echo e($submission->score ?? 'Assess file'); ?>

                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-max px-3 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <?php echo e($submission->score ? "{$submission->score} marks assigned after assessment" : "Assess the document and assign marks"); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">Good (Remarks)</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">
                                <div class="flex flex-col items-center space-y-2">
                                    <?php if($submission->final_status === 'under_review' && $submission->reviewer_status === 'accepted'): ?>
                                        <a href="<?php echo e(route('reviewer.abstract.assessment', ['serial_number' => $submission->serial_number])); ?>" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Assess
                                        </a>
                                    <?php elseif($submission->final_status === 'revision_required' && $submission->reviewer_status === 'accepted'): ?>
                                        <span class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7v4M5 7v4m4 8l4-4m0 0l4 4m-4-4v6"/>
                                            </svg>
                                            Requested Revision
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <form action="<?php echo e(route('reviewer.abstract.reject')); ?>" method="POST" class="group relative p-2 text-gray-600 hover:text-red-600 rounded-full hover:bg-red-100">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                        <button type="submit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                          </svg>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Reject</span>
                                        </button>
                                    </form>
                                    <a href="<?php echo e(route('research.abstract.download', $submission->serial_number)); ?>" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                        <!-- PDF icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download PDF
                                        </span>
                                    </a>
                                    <a href="<?php echo e(route('abstract.abstractWord.download', $submission->serial_number)); ?>" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                        <!-- Word document icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0H13m-2.5 4H13m-2.5 4H13"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download Word
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-600">
                                No articles assigned yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
        <!-- Research Proposals Tab (Hidden by default) -->
        <div x-show="activeTab === 'proposals'" class="p-4" style="display: none;">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </td>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Remarks</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($researchSubmission->article_title); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($researchSubmission->serial_number); ?></div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($researchSubmission->sub_theme); ?></td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700 group relative">
                            <?php echo e($researchSubmission->score ?? 'Assess file'); ?>

                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-max px-3 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <?php echo e($researchSubmission->score ? "{$researchSubmission->score} marks assigned after assessment" : "Assess the document and assign marks"); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">Good (Remarks)</td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            <div class="flex justify-center p-2">
                                <a href="<?php echo e(route('reviewer.proposal.assessment', ['serial_number' => $researchSubmission->serial_number])); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Assess
                                </a>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <form action="<?php echo e(route('reviewer.proposal.reject')); ?>" method="POST" class="group relative p-2 text-gray-600 hover:text-red-600 rounded-full hover:bg-red-100">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                        <button type="submit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Reject</span>
                                        </button>
                                    </form>
                                <a href="<?php echo e(route('proposal.abstract.download', $researchSubmission->serial_number)); ?>" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                    <!-- PDF icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                        Download PDF
                                    </span>
                                </a>
                                <a href="<?php echo e(route('proposal.abstractWord.download', $researchSubmission->serial_number)); ?>" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                    <!-- Word document icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0H13m-2.5 4H13m-2.5 4H13"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                        Download Word
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-600">
                            No articles assigned yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
</table>

        </div>
    </div>
</div>

<!-- Enhanced Document Review Form -->
<!-- Enhanced Document Review Form -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm" x-data="{ rating: 0, feedbackType: 'general', showGuide: false }">
    <div class="flex justify-between items-center mb-6">
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reviewer.layouts.reviewer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/reviewer/partials/documents.blade.php ENDPATH**/ ?>