<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Result Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $attempt->quiz->title }}</h1>
                
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="bg-indigo-50 p-4 rounded">
                        <div class="text-3xl font-bold text-indigo-600">{{ round($attempt->percentageScore(), 1) }}%</div>
                        <div class="text-sm text-gray-600">Your Score</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="text-3xl font-bold text-gray-900">{{ $attempt->total_score }}</div>
                        <div class="text-sm text-gray-600">Points Earned</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="text-3xl font-bold text-gray-900">{{ $attempt->quiz->questions()->sum('points') }}</div>
                        <div class="text-sm text-gray-600">Total Points</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="text-3xl font-bold {{ $attempt->isPassed() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $attempt->isPassed() ? 'PASSED' : 'FAILED' }}
                        </div>
                        <div class="text-sm text-gray-600">Result</div>
                    </div>
                </div>

                <p class="text-gray-600">
                    Passing score: {{ $attempt->quiz->passing_score }}% | 
                    Time taken: {{ $attempt->getDuration() }} minutes
                </p>
            </div>
        </div>

        <!-- Answer Review -->
        <div class="space-y-4">
            @foreach ($attempt->scores as $score)
                <div class="bg-white rounded-lg shadow p-6 {{ $score->is_correct ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500' }}">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $score->question->question_text }}</h3>
                        <span class="text-sm font-semibold {{ $score->is_correct ? 'text-green-600' : 'text-red-600' }}">
                            {{ $score->points }}/{{ $score->question->points }} points
                        </span>
                    </div>

                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-600">Your answer:</p>
                            <p class="font-semibold">{{ $score->student_answer }}</p>
                        </div>

                        @if ($score->is_correct)
                            <div class="text-green-600">✓ Correct</div>
                        @else
                            <div class="text-red-600">✗ Incorrect</div>
                            <div>
                                <p class="text-sm text-gray-600">Correct answer:</p>
                                <p class="font-semibold">
                                    @foreach ($score->question->correctOptions() as $option)
                                        {{ $option->option_text }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('quizzes.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Back to Quizzes
            </a>
            @if (auth()->user()->isStudent())
                <a href="{{ route('attempts.start', $attempt->quiz) }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Retake Quiz
                </a>
            @endif
        </div>
    </div>
</x-app-layout>