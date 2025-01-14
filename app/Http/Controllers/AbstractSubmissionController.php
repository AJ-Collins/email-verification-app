<?php

namespace App\Http\Controllers;

use App\Models\AbstractSubmission;
use App\Models\AbstractDraft;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewUserNotification;

class AbstractSubmissionController extends Controller
{
    private const SESSION_KEYS = [
        'author',
        'all_authors',
        'abstract',
        'submission_type'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function step1(Request $request)
    {
        // Check if there's existing session data
        $author = session('author', []);
        $submissionType = session('submission_type', 'abstract');
        $draft = $this->getCurrentDraft();

        $allAuthors = session('all_authors', [['is_correspondent' => false]]);

        return view('user.partials.step1', compact('author', 'submissionType', 'draft', 'allAuthors'));
    }

    public function postStep1(Request $request)
    {
        $validatedData = $request->validate([
            'authors' => 'required|array|min:1',
            'authors.*.first_name' => 'required|string|max:255',
            'authors.*.middle_name' => 'nullable|string|max:255',
            'authors.*.surname' => 'required|string|max:255',
            'authors.*.department' => 'required|string|max:255',
            'authors.*.university' => 'required|string|max:255',
            'authors.*.email' => 'required|email|max:255',
            'authors.*.is_correspondent' => 'required|boolean',
            'submission_type' => 'required|in:abstract',
        ]);

        // Ensure 'is_correspondent' defaults to false if not provided
        foreach ($validatedData['authors'] as &$author) {
            $author['is_correspondent'] = $author['is_correspondent'] ?? false;
        }

        // Assign the primary author and store data in session
        $primaryAuthor = $validatedData['authors'][0];
        $allAuthors = $validatedData['authors'];

        session([
            'author' => $primaryAuthor,
            'all_authors' => $allAuthors,
            'submission_type' => $validatedData['submission_type']
        ]);

        return redirect()->route('user.step2')->with('success', 'Step 1 completed successfully.');
    }
    public function step2(Request $request)
    {
        $subThemes = [
            'Transformative Education',
            'Business and Entrepreneurship',
            'Health and Food Security',
            'Digital, Creative Economy and Contemporary Societies',
            'Engineering, Technology and Sustainable Environment',
            'Blue Economy & Maritime Affairs',
        ];

        // Check if step 1 is completed
        if (!Session::has('author')) {
            return redirect()->route('user.step1')
                ->with('error', 'Please complete author details first.');
        }

        // Get existing abstract data if available
        $abstract = array_merge([
            'article_title' => '',
            'sub_theme' => '',
            'abstract' => '',
            'keywords' => [],
        ], Session::get('abstract', []));

        if ($request->has('keywords')) {
            // Save keywords to session
            $abstract['keywords'] = array_filter($request->input('keywords'), function ($value) {
                return !empty($value); // Only save non-empty keywords
            });
            Session::put('abstract', $abstract);
        }
        $draft = $this->getCurrentDraft();

        return view('user.partials.step2', compact('abstract', 'subThemes', 'draft'));
    }


   public function postStep2(Request $request)
    {
        $validatedData = $request->validate([
            'article_title' => 'required|string|max:500',
            'sub_theme' => 'required|string|max:500',
            'abstract' => 'required|string|max:5000',
            'keywords' => 'required|array|min:3|max:5',
            'keywords.*' => 'string|max:255',
        ]);

        // Store as array in session
        session([
            'abstract' => [
                'article_title' => $validatedData['article_title'],
                'sub_theme' => $validatedData['sub_theme'],
                'abstract' => $validatedData['abstract'],
                'keywords' => $validatedData['keywords'] ?? [],
            ]
        ]);

        return redirect()->route('user.preview');
    }
    public function preview(Request $request)
    {
        // Retrieve session data
        $author = $request->session()->get('author');
        $abstract = $request->session()->get('abstract');
        $allAuthors = $request->session()->get('all_authors');
    
        // Check if session data is available for required fields
        if (!$author || !$abstract || !$allAuthors) {
            return redirect()->route('user.step1')->with('error', 'Required data is missing. Please complete all steps.');
        }
        
        $article_title = $abstract['article_title'] ?? 'Untitled';
        $correspondingAuthor = collect($allAuthors)->firstWhere('is_correspondent', true);

        // If abstract data is an array, convert it to an AbstractSubmission object for consistency
        if (!isset($abstract['keywords']) || !is_array($abstract['keywords'])) {
            $abstract['keywords'] = [];
        }
    
        $draft = $this->getCurrentDraft();
        // Passing data to the preview view
        return view('user.partials.preview', compact('author', 'abstract', 'allAuthors', 'article_title', 'correspondingAuthor', 'draft'));
    }
    


    public function postPreview(Request $request)
    {
        $user = auth()->user();
        $authorData = $request->session()->get('author');
        $abstractData = $request->session()->get('abstract');
        $allAuthors = $request->session()->get('all_authors');
        
        if (!$authorData || !$abstractData) {
            return redirect()->route('user.step1')->with('error', 'No author or abstract data available.');
        }
    
        $subTheme = $abstractData['sub_theme'];
        $acronyms = [
            'Transformative Education' => 'TE',
            'Business and Entrepreneurship' => 'BE',
            'Health and Food Security' => 'HFS',
            'Digital, Creative Economy and Contemporary Societies' => 'DCECS',
            'Engineering, Technology and Sustainable Environment' => 'ETSE',
            'Blue Economy & Maritime Affairs' => 'BEMA',
        ];
    
        $acronym = $acronyms[$subTheme] ?? 'N/A';
        $year = date('y');
        
        // Generate unique identifier using timestamp and uniqid
        $uniqueCode = mb_strtoupper(Str::random(mt_rand(4, 5)) . Str::random(mt_rand(3, 5)));
        $serialNumber = "{$acronym}-{$uniqueCode}-{$year}";
    
        $this->deleteDraft($serialNumber);
    
        $abstractSubmission = new AbstractSubmission();
        $abstractSubmission->serial_number = $serialNumber;
        $abstractSubmission->title = $abstractData['article_title'];
        $abstractSubmission->sub_theme = $abstractData['sub_theme'];
        $abstractSubmission->abstract = $abstractData['abstract'];
        $abstractSubmission->keywords = json_encode($abstractData['keywords']);
        $abstractSubmission->user_reg_no = auth()->user()->reg_no;
        $abstractSubmission->final_status = "submitted";
        $abstractSubmission->save();
    
        foreach ($allAuthors as $authorData) {
            $authorData['abstract_submission_id'] = $serialNumber;
            $author = new Author($authorData);
            $author->save();
        }
    
        $data = [
            'message' => $abstractData['article_title'] . ' Abstract Submitted successfully',
            'link' => '/some-link',
        ];
        
        $user->notify(new NewUserNotification($data));
        $request->session()->forget(self::SESSION_KEYS);
    
        return redirect()->route('user.dashboard')->with('success', 'Submission successful.');
    }
    
    public function saveDraft(Request $request)
    {
        $user = auth()->user();
        $currentStep = $request->input('current_step', 1);
        $serialNumber = $request->input('serial_number');

        if (!$serialNumber) {
            // Generate a preliminary serial number without sub_theme
            $serialCode = mb_strtoupper(Str::random(mt_rand(4, 5)) . Str::random(mt_rand(3, 5)));
            $serialNumber = "DRAFT-{$serialCode}-" . date('y');
        }

        try {
            $draft = AbstractDraft::firstOrNew(['serial_number' => $serialNumber]);

            if (!$draft->exists) {
                $draft->user_reg_no = $user->reg_no;
                $draft->serial_number = $serialNumber;
            }

            // Save authors
            if ($currentStep >= 1 || $request->has('authors')) {
                $authors = $request->input('authors') ?? session('all_authors');
                if ($authors) {
                    foreach ($authors as &$author) {
                        $author['is_correspondent'] = $author['is_correspondent'] ?? false;
                    }
                    $draft->authors = json_encode($authors);
                }
            }

            // Save abstract details
            if ($currentStep >= 2) {
                $abstract = $request->only(['article_title', 'sub_theme', 'abstract', 'keywords']);
                $draft->title = $abstract['article_title'] ?? $draft->title;
                $draft->sub_theme = $abstract['sub_theme'] ?? $draft->sub_theme;
                $draft->abstract = $abstract['abstract'] ?? $draft->abstract;
                $draft->keywords = isset($abstract['keywords']) ? json_encode($abstract['keywords']) : $draft->keywords;

                // Update serial number with sub_theme if available
                if (isset($abstract['sub_theme'])) {
                    $subTheme = $abstract['sub_theme'];
                    $acronyms = [
                        'Transformative Education' => 'TE',
                        'Business and Entrepreneurship' => 'BE',
                        'Health and Food Security' => 'HFS',
                        'Digital, Creative Economy and Contemporary Societies' => 'DCECS',
                        'Engineering, Technology and Sustainable Environment' => 'ETSE',
                        'Blue Economy & Maritime Affairs' => 'BEMA',
                    ];

                    $acronym = $acronyms[$subTheme] ?? 'N/A';
                    $serialCode = mb_strtoupper(Str::random(mt_rand(4, 5)) . Str::random(mt_rand(3, 5)));
                    $newSerialNumber = "{$acronym}-{$serialCode}-" . date('y');

                    // Update the draft's serial number
                    $draft->serial_number = $newSerialNumber;

                    // Store the new serial number in the session
                    $request->session()->put('serial_number', $newSerialNumber);
                }
            }

            $draft->save();

            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully',
                'serial_number' => $draft->serial_number,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving draft: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function resumeDraft($serialNumber)
    {
        $draft = AbstractDraft::where('serial_number', $serialNumber)
            ->where('user_reg_no', auth()->user()->reg_no)
            ->firstOrFail();

        // Restore session data
        if ($draft->authors) {
            $authors = json_decode($draft->authors, true);
            session([
                'all_authors' => $authors,
                'author' => $authors[0] ?? []
            ]);
        }

        if ($draft->title || $draft->abstract) {
            session([
                'abstract' => [
                    'article_title' => $draft->title,
                    'sub_theme' => $draft->sub_theme,
                    'abstract' => $draft->abstract,
                    'keywords' => json_decode($draft->keywords, true) ?? []
                ]
            ]);
        }

        // Determine which step to resume to
        if (!$draft->authors) {
            return redirect()->route('user.step1');
        } elseif (!$draft->title || !$draft->abstract) {
            return redirect()->route('user.step2');
        } else {
            return redirect()->route('user.preview');
        }
    }

    private function getCurrentDraft()
    {
        return AbstractDraft::where('user_reg_no', auth()->user()->reg_no)
            ->first();
    }

    public function viewDrafts()
    {
        $abstractDrafts = AbstractDraft::where('user_reg_no', auth()->user()->reg_no)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.partials.drafts', compact('abstractDrafts'))->with('type', 'abstract');
    }

    public function deleteDraft($serialNumber)
    {
        $draft = AbstractDraft::where('serial_number', $serialNumber)
            ->where('user_reg_no', auth()->user()->reg_no)
            ->first();

        if ($draft) {
            $draft->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Draft not found'], 404);
    }
    public function PostSubmitArticle(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx|max:512000',
            ]);

            // Get the uploaded file
            $file = $request->file('document');

            // Retrieve the serial number from the request (ensure it's passed in the form)
            $serialNumber = $request->input('serial_number');
            if (!$serialNumber) {
                throw new \Exception('Serial number is missing.');
            }

            // Generate a unique file name
            $fileName = $serialNumber . '.' . $file->getClientOriginalExtension();

            // Store the file
            $filePath = $file->storeAs('articles', $fileName, 'public');
            if (!$filePath) {
                throw new \Exception('Failed to store the file.');
            }

            // Update the database record where the serial number matches
            $updated = AbstractSubmission::where('serial_number', $serialNumber)
                ->update(['pdf_path' => $filePath]);

            if (!$updated) {
                throw new \Exception('Failed to update the database record.');
            }

            $user = auth()->user();
            $data = [
                'message' => $fileName['serial_number'] . ' Submitted successfully. View status',
                'link' => '/some-link',
            ];
            
            $user->notify(new NewUserNotification($data));

            // Redirect with success message
            return redirect()->route('user.dashboard')->with('success', 'Article uploaded successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload article. Please try again.');
        }
    }
}
