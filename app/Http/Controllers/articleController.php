<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Article;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ArticleController extends Controller

{
  public function createArticle(Request $request)
  {
   $this->validate($request, [
        'title' => 'required|min:30|max:70|unique:articles',
        'resume' => 'required|min:50|max:100',
        'text' => 'required|min:200',
        'uuid' => 'required',
    ]);
    $searchUser = DB::table('users')->where('uuid', $request->input('uuid'))->take(1)->get();
    $uuid = Article::newUniqueId();
    $slug = str_replace(' ', '-', $request->input('title'));
    $article = Article::create(['user_id' => $searchUser[0]->id, 'uuid' => $uuid, 'title' =>  $request->input('title'), 'resume' => $request->input('resume'), 'text' => $request->input('text'), 'slug' => $slug, 
    ]);
      $article->save();
      return response()->json(['uuid' => $uuid, 'title' =>  $request->input('title'), 'resume' => $request->input('resume'), 'text' => $request->input('text'), 'slug' => $slug, 'registeredAt' => $article['created_at'], 'User' => ['uuid' => $searchUser[0]->id, 'username' => $searchUser[0]->username]]);
  } 
  
  public function getAllArticles() {
    $getArticles = DB::table('articles')->join('users', 'articles.user_id', '=', 'users.id')->select('articles.title', 'articles.resume', 'articles.text',  'articles.slug', 'articles.created_at', 'users.uuid', 'users.username')->get();
    return response()->json($getArticles);
  }
  public function getArticle($articleUuid)
  {
      $getArticle = DB::table('articles')->join('users', 'articles.user_id', '=', 'users.id')->select('articles.title', 'articles.resume', 'articles.text',  'articles.slug', 'articles.created_at', 'users.uuid', 'users.username')->take(1)->get();
      return response()->json($getArticle);
    }
  public function updateArticle(Request $request, $articleUuid)
  {
    $this->validate($request, [
          'title' => 'required|min:30|max:70',
          'resume' => 'required|min:50|max:100',
          'text' => 'required|min:200',
      ]);
    $updateArticle = Article::where('uuid', $articleUuid)->update(['title' => $request->input('title'), 'resume' => $request->input('resume'), 'text' => $request->input('text')]);
    $returnArticle = DB::table('articles')->join('users', 'articles.user_id', '=', 'users.id')->select('articles.title', 'articles.resume', 'articles.text',  'articles.slug', 'articles.created_at', 'users.uuid', 'users.username')->take(1)->get();
      return response()->json($returnArticle);
  }
  public function deleteArticle($articleUuid)
  {
    if(Article::where('uuid', $articleUuid)->delete() === 1){
      return response()->json("Artigo apagado com sucesso");
    } else{
      return response()->json([], 404);
    }
  }
}