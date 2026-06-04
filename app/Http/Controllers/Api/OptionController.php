<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Store a newly created option in storage.
     */
    public function store(Request $request, Question $question)
    {
        $this->authorize('update', $question->quiz);

        $validated = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'nullable|boolean',
        ]);

        $validated['question_id'] = $question->id;
        $validated['is_correct'] = $request->has('is_correct');

        Option::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Option added successfully.');
    }

    /**
     * Update the specified option in storage.
     */
    public function update(Request $request, Option $option)
    {
        $this->authorize('update', $option->question->quiz);

        $validated = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'nullable|boolean',
        ]);

        $validated['is_correct'] = $request->has('is_correct');

        $option->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Option updated successfully.');
    }

    /**
     * Remove the specified option from storage.
     */
    public function destroy(Option $option)
    {
        $this->authorize('update', $option->question->quiz);

        $option->delete();

        return redirect()
            ->back()
            ->with('success', 'Option deleted successfully.');
    }
}