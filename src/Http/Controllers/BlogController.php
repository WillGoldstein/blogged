<?php

namespace BinaryTorch\Blogged\Http\Controllers;

use BinaryTorch\Blogged\Models\Article;
use BinaryTorch\Blogged\Models\Category;
use BinaryTorch\Blogged\Filters\ArticleFilters;

class BlogController extends Controller
{
    /**
     * Show the blog home page.
     */
    public function index($category=null, ArticleFilters $filters = null)
    {
        $pagination = config('blogged.settings.pagination');

        if($category) {
            $category = Category::whereSlug($category)->firstOrFail();

            $articles = $category->articles()->published()->orderBy('publish_date', 'DESC')->with('category')->filter($filters)->paginate($pagination);
            
            return view('blogged::blog.index', compact('articles'));
        }

        // can't chain eloquent for w/e reason
        if ($filters){
            $articles = Article::published()->orderBy('publish_date', 'DESC')->with('category')->filter($filters)->paginate($pagination);
        } else {
            $articles = Article::published()->orderBy('publish_date', 'DESC')->with('category')->paginate($pagination);
        }

        return view('blogged::blog.index', compact('articles'));
    }

    /**
     * Show a given article.
     */
    public function show($category, Article $article)
    {
        $category = Category::where('slug', $category)->firstOrFail();

        abort_if($category->id != $article->category_id, 404);
        
        abort_if(! $article->published && $article->author->id != auth()->id(), 403);

        $article->load(['category', 'author']);

        return view('blogged::blog.show', compact('article'));
    }
}
