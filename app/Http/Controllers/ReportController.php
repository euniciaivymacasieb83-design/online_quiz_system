<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportPDF() {
        $scores = Score::all();
        $pdf = PDF::loadView('reports.scores', compact('scores'));
        return $pdf->download('scores-report.pdf');
    }

    public function exportExcel() {
        return Excel::download(new ScoresExport(), 'scores.xlsx');
    }

    public function exportCSV() {
        return Excel::download(new ScoresExport(), 'scores.csv');
    }

    public function import(Request $request) {
        Excel::import(new QuizzesImport(), $request->file('file'));
        return redirect()->back()->with('success', 'Data imported');
    }

    public function index(Request $request) {
        $query = Quiz::query();
    
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
    
        $quizzes = $query->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }
}
