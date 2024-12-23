@extends('user.layouts.user')

@section('user-content')
<!-- Progress Tracker -->
<div class="max-w-4xl mx-auto mb-8">
    <div class="relative">
        <!-- Progress Line -->
        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
        <div class="absolute top-1/2 left-0 w-1/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

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

            <!-- Step 2: Active -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg ring-4 ring-green-100">
                    2
                </div>
                <span class="text-sm font-medium text-green-600">Abstract</span>
            </div>

            <!-- Step 3: Pending -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
                    3
                </div>
                <span class="text-sm font-medium text-gray-500">Preview</span>
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
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Abstract Submission</h2>
            <p class="text-green-100 text-sm mt-2">Please fill in the details of your abstract submission</p>
        </div>
    <form class="p-8" id="step2Form" method="POST" 
        action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="submission_type" value="abstract">
        <div id="authorsContainer" class="space-y-8">
                <!-- Primary Author Section -->
                <div class="author-section bg-gray-50 p-6 border border-gray-800 transition-all duration-300 hover:shadow-md" data-author-index="0">
            <!-- Title Input -->
            <div class="form-group">
                <label for="article-title" class="block text-lg font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                        id="article-title" 
                        name="article_title" 
                        placeholder="Enter the title of your article" 
                        value="" 
                        class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg @error('article_title') border-red-500 @enderror"
                        required>
                    @error('article_title')
                        <p class="mt-1 text-sm text-red-500">Best/p>
                    @enderror
                    <div class="text-sm text-gray-500 mt-1">Title should be clear and descriptive</div>
                </div>
            </div>

            <!-- Sub-Theme Selection -->
            <div class="form-group">
                <label for="sub-theme" class="block text-lg font-medium text-gray-700 mb-2">
                    Sub-Theme <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="sub-theme" 
                        name="sub_theme" 
                        class="w-full h-12 px-4 border border-gray-800 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors appearance-none bg-white @error('sub_theme') border-red-500 @enderror"
                        required>
                        <option value="">Select a sub-theme</option>
                        <option value="Transformative Education" {{ old('sub_theme') == 'Transformative Education' ? 'selected' : '' }}>
                            Transformative Education
                        </option>
                        <option value="Business and Entrepreneurship" {{ old('sub_theme') == 'Business and Entrepreneurship' ? 'selected' : '' }}>
                            Business and Entrepreneurship
                        </option>
                        <option value="Health and Food Security" {{ old('sub_theme') == 'Health and Food Security' ? 'selected' : '' }}>
                            Health and Food Security
                        </option>
                        <option value="Digital, Creative Economy and Contemporary Societies" {{ old('sub_theme') == 'Digital, Creative Economy and Contemporary Societies' ? 'selected' : '' }}>
                            Digital, Creative Economy and Contemporary Societies
                        </option>
                        <option value="Engineering, Technology and Sustainable Environment" {{ old('sub_theme') == 'Engineering, Technology and Sustainable Environment' ? 'selected' : '' }}>
                            Engineering, Technology and Sustainable Environment
                        </option>
                        <option value="Blue Economy & Maritime Affairs" {{ old('sub_theme') == 'Blue Economy & Maritime Affairs' ? 'selected' : '' }}>
                            Blue Economy & Maritime Affairs
                        </option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                    @error('sub_theme')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Abstract Input -->
            <div class="form-group">
                <label for="abstract" class="block text-lg font-medium text-gray-700 mb-2">
                    Abstract <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div id="abstract" 
                        contenteditable="true" 
                        class="w-full min-h-[200px] p-4 border border-gray-800 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-white @error('abstract') border-red-500 @enderror"
                        data-placeholder="Enter your abstract here..."></div>
                    <input type="hidden" name="abstract" id="hiddenAbstract">
                    <div class="flex justify-between mt-2">
                        <p id="wordCount" class="text-sm text-gray-600">Word Count: 0/500</p>
                        <p class="text-sm text-gray-500">Maximum 500 words</p>
                    </div>
                    @error('abstract')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Keywords Input -->
            <div class="form-group">
                <label class="block text-lg font-medium text-gray-700 mb-2">
                    Keywords <span class="text-red-500">*</span>
                    <span class="text-sm text-gray-500 ml-2">(3-5 keywords)</span>
                </label>
                <div id="keywords-container" class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" name="keywords[]" placeholder="Keyword 1" 
                            class="w-full h-10 px-3 border border-gray-800 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <input type="text" name="keywords[]" placeholder="Keyword 2" 
                            class="w-full h-10 px-3 border border-gray-800 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <input type="text" name="keywords[]" placeholder="Keyword 3" 
                            class="w-full h-10 px-3 border border-gray-800 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" id="add-keyword" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Keyword
                    </button>
                </div>
                <p id="max-keyword-message" class="mt-2 text-sm text-red-500 hidden">
                    Maximum number of keywords (5) reached
                </p>
            </div>
        

        <!-- Action Buttons -->
        <div class="flex justify-between mt-12">
            <button type="button" onclick="goBack()" 
                class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Previous
            </button>
            <a href="{{route('user.preview')}}" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Next
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        </div>
</div>
    </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editableDiv = document.getElementById('abstract');
    const hiddenInput = document.getElementById('hiddenAbstract');
    const wordCountElem = document.getElementById('wordCount');
    const MAX_WORDS = 500;

    // Set placeholder text
    editableDiv.dataset.placeholder = "Enter your abstract here...";
    if (!editableDiv.textContent.trim()) {
        editableDiv.classList.add('empty');
    }

    editableDiv.addEventListener('focus', function() {
        if (editableDiv.classList.contains('empty')) {
            editableDiv.classList.remove('empty');
            editableDiv.textContent = '';
        }
    });

    editableDiv.addEventListener('blur', function() {
        if (!editableDiv.textContent.trim()) {
            editableDiv.classList.add('empty');
        }
    });

    function updateWordCount() {
        let text = editableDiv.innerText || editableDiv.textContent;
        text = text.replace(/[^a-zA-Z\s.,;:'"\-?!()]/g, '');
        let words = text.trim().split(/\s+/).filter(Boolean);
        let wordCount = words.length;

        wordCountElem.textContent = `Word Count: ${wordCount}/${MAX_WORDS}`;
        wordCountElem.className = wordCount > MAX_WORDS ? 'text-sm text-red-500' : 'text-sm text-gray-600';

        if (wordCount > MAX_WORDS) {
            words = words.slice(0, MAX_WORDS);
            text = words.join(' ');
            editableDiv.innerText = text;
        }

        hiddenInput.value = text;
    }

    editableDiv.addEventListener('input', updateWordCount);
    document.getElementById('step2Form').addEventListener('submit', updateWordCount);
    updateWordCount();

    // Keywords Management
    const MAX_KEYWORDS = 5;
    const keywordsContainer = document.getElementById('keywords-container');
    const addKeywordButton = document.getElementById('add-keyword');
    const maxKeywordMessage = document.getElementById('max-keyword-message');

    addKeywordButton.addEventListener('click', function() {
        const currentKeywords = keywordsContainer.querySelectorAll('input').length;

        if (currentKeywords < MAX_KEYWORDS) {
            const newKeywordDiv = document.createElement('div');
            newKeywordDiv.className = 'flex items-center space-x-2 mt-3';
            
            newKeywordDiv.innerHTML = `
                <input type="text" name="keywords[]" placeholder="Keyword ${currentKeywords + 1}" 
                    class="w-full h-10 px-3 border border-gray-800 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <button type="button" class="flex-shrink-0 ml-2 text-red-500 hover:text-red-700" onclick="removeKeyword(this)">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>`;

            keywordsContainer.appendChild(newKeywordDiv);
        }

        // Update UI based on keyword count
        const newCount = keywordsContainer.querySelectorAll('input').length;
        maxKeywordMessage.classList.toggle('hidden', newCount < MAX_KEYWORDS);
        addKeywordButton.classList.toggle('opacity-50', newCount >= MAX_KEYWORDS);
        addKeywordButton.disabled = newCount >= MAX_KEYWORDS;
    });

    // Function to remove keyword input
    window.removeKeyword = function(button) {
        const keywordDiv = button.parentElement;
        keywordDiv.remove();

        const currentKeywords = keywordsContainer.querySelectorAll('input').length;
        maxKeywordMessage.classList.add('hidden');
        addKeywordButton.classList.remove('opacity-50');
        addKeywordButton.disabled = false;

        // Update placeholder numbers
        const inputs = keywordsContainer.querySelectorAll('input');
        inputs.forEach((input, index) => {
            input.placeholder = `Keyword ${index + 1}`;
        });
    };

    // Form validation
    const form = document.getElementById('step2Form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Validate title
        const titleInput = document.getElementById('article-title');
        if (!titleInput.value.trim()) {
            showError(titleInput, 'Title is required');
            return;
        }

        // Validate sub-theme
        const subThemeSelect = document.getElementById('sub-theme');
        if (!subThemeSelect.value) {
            showError(subThemeSelect, 'Please select a sub-theme');
            return;
        }

        // Validate abstract
        const abstractText = hiddenInput.value.trim();
        if (!abstractText) {
            showError(editableDiv, 'Abstract is required');
            return;
        }

        const wordCount = abstractText.split(/\s+/).filter(Boolean).length;
        if (wordCount > MAX_WORDS) {
            showError(editableDiv, `Abstract must not exceed ${MAX_WORDS} words`);
            return;
        }

        // Validate keywords
        const keywords = Array.from(keywordsContainer.querySelectorAll('input'))
            .map(input => input.value.trim())
            .filter(Boolean);

        if (keywords.length < 3) {
            showError(keywordsContainer, 'At least 3 keywords are required');
            return;
        }

        // If all validation passes, submit the form
        this.submit();
    });

    function showError(element, message) {
        // Remove any existing error messages
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Add error styling
        element.classList.add('border-red-500');

        // Create and append error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1';
        errorDiv.textContent = message;
        element.parentElement.appendChild(errorDiv);

        // Scroll to the error
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Clear error styling on input
    document.querySelectorAll('input, select, #abstract').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            const errorMessage = this.parentElement.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    });
});

// Navigation confirmation
window.onbeforeunload = function() {
    const form = document.getElementById('step2Form');
    if (form.querySelector('input[name="article_title"]').value ||
        form.querySelector('select[name="sub_theme"]').value ||
        document.getElementById('hiddenAbstract').value ||
        Array.from(form.querySelectorAll('input[name="keywords[]"]')).some(input => input.value.trim())) {
        return "You have unsaved changes. Are you sure you want to leave?";
    }
};

function goBack() {
    if (confirm('Are you sure you want to go back? Any unsaved changes will be lost.')) {
        window.history.back();
    }
}
</script>

<style>
#abstract[data-placeholder]:empty:before {
    content: attr(data-placeholder);
    color: #9CA3AF;
}

#abstract.empty[data-placeholder]:before {
    content: attr(data-placeholder);
    color: #9CA3AF;
}

.form-group {
    position: relative;
}

.error-message {
    position: absolute;
    bottom: -1.5rem;
    left: 0;
    right: 0;
}
</style>
@endsection