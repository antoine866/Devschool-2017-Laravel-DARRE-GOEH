<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/


public function index()
{
// Liste des articles

$posts = Post::orderBy('id', 'desc')->paginate(10);

return view('posts.index', compact('posts'));

}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
return view('posts.create');
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
// Enregistre le formulaire de création



$this->validate($request, [
'title' => 'required|min:6',
'content' => 'required|min:20'
],
[
'title.required' => 'Titre requis',
'title.min' => 'Le titre doit faire au moins 6 caractères',
'content.required' => 'Contenu requis',
'content.min' => 'Le contenu doit faire au moins 20 caractères'

]);

$post = new Post;
$input = $request->input();
$input['user_id'] = Auth::user()->id;

$post->fill($input)->save();



return redirect()
->route('post.index')
->with('success', 'L\'article a bien été ajouté');
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//Afficher un article
$post = Post::findOrFail($id);
return view('posts.show', compact('post'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$post = Post::findOrFail($id);
//Afficher le formulaire d'édition d'un article
return view('posts.edit', compact('post'));
}

/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
//Enregistre le formulaire d'édition en BDD

$this->validate($request,
[
'title.required' => 'Titre requis',
'title.min' => 'Le titre doit faire au moins 6 caractères',
'content.required' => 'Contenu requis',
'content.min' => 'Le contenu doit faire au moins 20 caractères'

]);

$post = Post::findOrFail($id);
$input = $request->input();

$post->fill($input)->save();

return redirect()
->route('post.show',$id)
->with('success', 'L\'article a bien été mis à jour');
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
//Supprime l'article

$post = Post::findOrFail($id);
$post->delete();

return redirect()
->route('post.index')
->with('sucess', 'L\'article a bien été supprimé');
}
}