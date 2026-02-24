<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $reviews_count = DB::table('reviews')
            ->where('user_id', $user->id)
            ->count();
        
        return view('profile.index', compact('user', 'reviews_count'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());
        
        return redirect()->route('profile')->with('success', 'Профиль обновлен');
    }

    public function reviews()
    {
        $user = Auth::user();
        
        $reviews = DB::table('reviews')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('profile.reviews', compact('user', 'reviews'));
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'car_model' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        DB::table('reviews')->insert([
            'user_id' => Auth::id(),
            'car_model' => $request->car_model,
            'title' => $request->title,
            'content' => $request->content,
            'rating' => $request->rating,
            'status' => 'moderation',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return redirect()->route('profile.reviews')->with('success', 'Отзыв отправлен на модерацию');
    }
    
    public function deleteReview($id)
    {
        $user_id = Auth::id();
        
        $review = DB::table('reviews')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();
            
        if (!$review) {
            return redirect()->back()->with('error', 'Отзыв не найден');
        }
        
        DB::table('reviews')->where('id', $id)->delete();
        
        return redirect()->route('profile.reviews')->with('success', 'Отзыв удален');
    }
    
    public function editReview($id)
    {
        $user_id = Auth::id();
        
        $review = DB::table('reviews')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();
            
        if (!$review) {
            return redirect()->route('profile.reviews')->with('error', 'Отзыв не найден');
        }
        
        return view('profile.edit-review', compact('review'));
    }
    
    public function updateReview(Request $request, $id)
    {
        $user_id = Auth::id();
        
        $review = DB::table('reviews')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();
            
        if (!$review) {
            return redirect()->route('profile.reviews')->with('error', 'Отзыв не найден');
        }
        
        $request->validate([
            'car_model' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        DB::table('reviews')
            ->where('id', $id)
            ->update([
                'car_model' => $request->car_model,
                'title' => $request->title,
                'content' => $request->content,
                'rating' => $request->rating,
                'status' => 'moderation',
                'updated_at' => now()
            ]);
            
        return redirect()->route('profile.reviews')->with('success', 'Отзыв обновлен и отправлен на модерацию');
    }
}