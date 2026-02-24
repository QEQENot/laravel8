<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    public function home()
    {
        $slider_settings = DB::table('homepage_settings')
            ->where('section', 'slider')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $slider_news = DB::table('news')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $latest_news = DB::table('news')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $news_header = DB::table('homepage_settings')
            ->where('section', 'news_header')
            ->first();

        $all_news_button = DB::table('homepage_settings')
            ->where('section', 'all_news_button')
            ->first();

        return view('index', compact(
            'slider_settings',
            'slider_news',
            'latest_news',
            'news_header',
            'all_news_button'
        ));
    }

    public function news(Request $request)
    {
        $query = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->select('news.*', 'categories.name as category_name', 'categories.slug as category_slug');

        if ($request->filled('category')) {
            $query->where('categories.slug', $request->category);
        }

        $news = $query->orderBy('news.created_at', 'desc')->paginate(9)->appends($request->only('category'));
        $categories = DB::table('categories')->get();
        $active_category = $request->category;

        return view('news', compact('news', 'categories', 'active_category'));
    }

    public function newsDetail($id)
    {
        $news = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as author_name')
            ->where('news.id', $id)
            ->first();

        if (!$news) {
            return redirect('/news')->with('error', 'Новость не найдена');
        }

        DB::table('news')->where('id', $id)->increment('views');
        $views = DB::table('news')->where('id', $id)->value('views');

        $related_news = DB::table('news')
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $id)
            ->limit(3)
            ->get();

        $comments = DB::table('news_comments')
            ->where('news_id', $id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $avg_rating = DB::table('news_comments')
            ->where('news_id', $id)
            ->where('is_approved', true)
            ->avg('rating');

        return view('news-detail', compact('news', 'related_news', 'comments', 'avg_rating', 'views'));
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $reviews_count = DB::table('reviews')
            ->where('user_id', $user->id)
            ->count();

        $published_reviews = DB::table('reviews')
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->count();

        $moderation_reviews = DB::table('reviews')
            ->where('user_id', $user->id)
            ->where('status', 'moderation')
            ->count();

        return view('profile.index', compact('user', 'reviews_count', 'published_reviews', 'moderation_reviews'));
    }

    public function editProfile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user_id = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user_id,
            'email' => 'required|email|max:255|unique:users,email,' . $user_id,
        ]);

        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'patronymic' => $request->patronymic,
                'login' => $request->login,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'updated_at' => now()
            ]);

        return redirect('/profile')->with('success', 'Профиль обновлен');
    }

    public function myReviews()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user_id = Auth::id();
        $user = Auth::user();

        $reviews = DB::table('reviews')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.reviews', compact('reviews', 'user'));
    }

    public function addReviewForm()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        return view('profile.add-review', compact('user'));
    }

    public function storeReview(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

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

        return redirect('/profile/reviews')->with('success', 'Отзыв отправлен на модерацию');
    }

    public function addComment(Request $request, $news_id)
    {
        $request->validate([
            'comment' => 'required|string|min:3|max:1000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $data = [
            'news_id' => $news_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => now()
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
            $data['user_name'] = Auth::user()->name . ' ' . Auth::user()->surname;
            $data['is_approved'] = true;
        } else {
            $request->validate(['user_name' => 'required|string|max:255']);
            $data['user_name'] = $request->user_name;
            $data['is_approved'] = false;
        }

        DB::table('news_comments')->insert($data);

        $message = Auth::check()
            ? 'Ваш отзыв добавлен'
            : 'Ваш отзыв отправлен на модерацию';

        return redirect()->back()->with('success', $message);
    }

    public function deleteComment($id)
    {
        DB::table('news_comments')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Отзыв удалён');
    }
}
