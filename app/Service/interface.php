<?php

use Illuminate\Support\Facades\Request;

interface AssessmentServiceInterface
{
    public function calculateAndProcess(Request $request);
    public function generatePdfResult(Request $request);
}