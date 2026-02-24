<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function slider()
    {
        $slider_settings = DB::table('homepage_settings')
            ->where('section', 'slider')
            ->orderBy('sort_order')
            ->get();
        return view('admin.slider', compact('slider_settings'));
    }
    
    public function updateSlider(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);
        
        DB::table('homepage_settings')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'image' => $request->image,
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active ? 1 : 0,
                'updated_at' => now()
            ]);
            
        return redirect()->back()->with('success', 'Слайд обновлен');
    }
    
    public function newsList()
    {
        $news = DB::table('news')->orderBy('created_at', 'desc')->get();
        $categories = DB::table('categories')->get();
        return view('admin.news', compact('news', 'categories'));
    }
    
    public function createNews()
    {
        $categories = DB::table('categories')->get();
        return view('admin.news-create', compact('categories'));
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:news,slug',
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'image'       => 'required|string|max:255',
            'category_id' => 'required|integer'
        ]);

        DB::table('news')->insert([
            'title'       => $request->title,
            'slug'        => $request->slug,
            'excerpt'     => $request->excerpt,
            'content'     => $request->content,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'user_id'     => auth()->id(),
            'views'       => 0,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        return redirect('/admin/news')->with('success', 'Новость добавлена');
    }

    public function editNews($id)
    {
        $news = DB::table('news')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        return view('admin.news-edit', compact('news', 'categories'));
    }
    
    public function updateNews(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . $id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'required|string|max:255',
            'category_id' => 'required|integer'
        ]);
        
        DB::table('news')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'excerpt' => $request->excerpt,
                'content' => $request->content,
                'image' => $request->image,
                'category_id' => $request->category_id,
                'updated_at' => now()
            ]);
            
        return redirect('/admin/news')->with('success', 'Новость обновлена');
    }
    
    public function deleteNews($id)
    {
        DB::table('news')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Новость удалена');
    }
    
    public function categories()
    {
        $categories = DB::table('categories')->orderBy('id')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        DB::table('categories')->insert([
            'name'       => $request->name,
            'slug'       => $request->slug,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Категория добавлена');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name'       => $request->name,
            'slug'       => $request->slug,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Категория обновлена');
    }

    public function deleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Категория удалена');
    }

    public function settings()
    {
        $news_header = DB::table('homepage_settings')
            ->where('section', 'news_header')
            ->first();
            
        $all_news_button = DB::table('homepage_settings')
            ->where('section', 'all_news_button')
            ->first();
            
        return view('admin.settings', compact('news_header', 'all_news_button'));
    }
    
    public function updateSettings(Request $request)
    {
        if ($request->has('news_title')) {
            DB::table('homepage_settings')
                ->where('section', 'news_header')
                ->update([
                    'title' => $request->news_title,
                    'subtitle' => $request->news_subtitle,
                    'updated_at' => now()
                ]);
        }
        
        if ($request->has('button_text')) {
            DB::table('homepage_settings')
                ->where('section', 'all_news_button')
                ->update([
                    'button_text' => $request->button_text,
                    'button_link' => $request->button_link,
                    'updated_at' => now()
                ]);
        }
        
        return redirect()->back()->with('success', 'Настройки сохранены');
    }
}