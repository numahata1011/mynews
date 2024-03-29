<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// 以下を追記することでNews Modelが扱えるようになる
use App\News;
// 以下を追記(17)
use App\History;
// 以下を追記(17)※日付操作ライブラリ
use Carbon\Carbon;
// 以下を追記(31)※Herokuへの画像のアップロード
use Storage;

class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }

  public function create(Request $request)
  {
      // 以下を追記
      // Varidationを行う
      $this->validate($request, News::$rules);

      $news = new News;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        //storeメソッド、引数内のディレクトリに一意のファイル名として保存し、そこへのパスを返す
        //fileメソッド、画像をアップロードするメソッド
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');//カリキュラム(30)変更、元は$path = $request->file('image')->store('public/image');
        //basenameメソッド、パスではなくファイル名だけ取得する
        $news->image_path = Storage::disk('s3')->url($path);//カリキュラム(30)変更、元は$news->image_path = basename($path);
      } else {
          $news->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      //fillメソッド、配列をカラムに代入する
      $news->fill($form);
      //saveメソッド、保存
      $news->save();

      return redirect('admin/news/create');
  }

  // 以下を追記
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = News::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = News::all();
      }
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }

  // 以下を追記(16)

  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news.edit', ['news_form' => $news]);
  }

  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      if ($request->remove == 'true') {
          $news_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = Storage::disk('s3')->putFile('/',$news_form['image'],'public');//カリキュラム(30)変更、元は$path = $request->file('image')->store('public/image');
          $news->image_path = Storage::disk('s3')->url($path);//カリキュラム(30)変更、元は$news->image_path = basename($path);
      } else {
          $news_form['image_path'] = $news->image_path;
      }

      unset($news_form['image']);
      unset($news_form['remove']);
      unset($news_form['_token']);

      // 該当するデータを上書きして保存する
      //$news->fill($news_form);,$news->save();を短縮して書いたもの
      $news->fill($news_form)->save();
      
      // 以下を追記(17)
      $history = new History();
      $history->news_id = $news->id;
      $history->edited_at = Carbon::now();
      $history->save();

      return redirect('admin/news/');
  }

  // 以下を追記(16)
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/news/');
  }

}