<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.partials.profile');
    }
    public function dashboard()
    {
        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();
        
        return view('user.partials.dashboard', compact('submissions', 'researchSubmissions'));
    }
    public function documents()
    {

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();

        return view('user.partials.documents', compact('submissions', 'researchSubmissions'));
    }
    public function viewProposal($serial_number)
    {
        $userRegNo = auth()->user()->reg_no;

        $researchSubmission = ResearchSubmission::where('serial_number', $serial_number)
            ->where('user_reg_no', $userRegNo)
            ->firstOrFail();

        return view('user.partials.document', compact('researchSubmission'));
   
    }
    
    public function submit()
    {
        return view('user.partials.submit');
    }
    public function step2()
    {
        return view('user.partials.step2');
    }
    public function preview()
    {
        return view('user.partials.preview');
    }
    public function confirm()
    {
        return view('user.partials.confirm');
    }
    public function step1_research()
    {
        return view('user.partials.step1_research');
    }
    public function step2_research()
    {
        return view('user.partials.step2_research');
    }
    public function preview_research()
    {
        return view('user.partials.preview_research');
    }
    public function confirm_research()
    {
        return view('user.partials.confirm_research');
    }
    public function confirmSubmission(Request $request)
    {
        // Handle your form submission logic

        // Add success message to the session
        session()->flash('success', 'Your submission was successful!');

        // Redirect to dashboard
        return redirect()->route('user.dashboard');
    }
}