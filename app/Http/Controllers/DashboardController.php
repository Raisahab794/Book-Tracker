<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $statistics = [
            'total_books' => $user->books()->count(),
            'completed_books' => $user->books()->where('status', 'completed')->count(),
            'currently_reading' => $user->books()->where('status', 'reading')->count(),
            'want_to_read' => $user->books()->where('status', 'want_to_read')->count(),
            'total_pages_read' => $user->books()->where('status', 'completed')->sum('total_pages'),
            'pages_in_progress' => $user->books()->where('status', 'reading')->sum('current_page'),
            'completion_rate' => $this->calculateCompletionRate($user),
            'reading_streak' => $this->calculateReadingStreak($user),
            'total_reading_time' => $user->readingSessions()->sum('minutes_spent'),
            'books_this_month' => $user->books()->where('status', 'completed')->whereMonth('updated_at', now()->month)->count(),
            'pages_this_month' => $user->readingSessions()->whereMonth('date', now()->month)->sum('pages_read'),
            'reading_time_this_month' => $user->readingSessions()->whereMonth('date', now()->month)->sum('minutes_spent'),
            'yearly_goal_progress' => $this->calculateYearlyGoalProgress($user),
        ];

        $recentActivity = [
            'recent_books' => $user->books()->latest()->take(5)->get(),
            'recent_sessions' => $user->readingSessions()->with('book')->latest()->take(5)->get()
        ];

        return view('dashboard', compact('statistics', 'recentActivity'));
    }

    private function calculateReadingStreak($user)
    {
        $sessions = $user->readingSessions()->orderBy('date', 'desc')->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->unique();
        
        $streak = 0;
        $currentDate = Carbon::today();

        while ($sessions->contains($currentDate->format('Y-m-d'))) {
            $streak++;
            $currentDate->subDay();
        }

        return $streak;
    }

    private function calculateCompletionRate($user)
    {
        $totalBooks = $user->books()->count();
        if (!$totalBooks) return 0;
        
        $completedBooks = $user->books()->where('status', 'completed')->count();
        return round(($completedBooks / $totalBooks) * 100, 1);
    }

    private function calculateYearlyGoalProgress($user)
    {
        $goal = $user->readingGoals()->where('year', now()->year)->first();
        if (!$goal) return [
            'books_read' => 0,
            'books_goal' => 0,
            'percentage' => 0
        ];

        $booksRead = $user->books()->where('status', 'completed')->whereYear('updated_at', now()->year)->count();
        return [
            'books_read' => $booksRead,
            'books_goal' => $goal->books_goal,
            'percentage' => round(($booksRead / $goal->books_goal) * 100, 1)
        ];
    }
}