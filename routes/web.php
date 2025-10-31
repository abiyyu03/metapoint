<?php

use App\Filament\Pages\AssessmentSubmissionDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('filament.admin.auth.login');
});

Route::get('/admin/assessment-detail/{record}', AssessmentSubmissionDetail::class)
    ->name('filament.admin.pages.assessment-submission-detail');