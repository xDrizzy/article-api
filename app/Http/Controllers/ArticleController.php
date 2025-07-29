<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::all() ; // Récupération de tout les articles de la DB

        return response()->json([   // Retourne la liste des articles au format JSON
            'success'=> true ,
            'articles' => $articles
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validateData = $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required',
            'published'=>'boolean',

        ]);

        // Enregistrement d'un article en base.
        $article = Article::create($validateData) ;

        // Retour de la création de l'article au format JSON.

        return response()->json([   // Retourne la liste des articles au format JSON
            'success' => true ,
            'message' => 'Article créé avec succès',
            'article' => $article
        ] , 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
        return response()->json([
            'success'=> true ,
            'article' => $article 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
        // Validation des données
        $validateData = $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required',
            'published'=>'boolean',

        ]);

        // On met à jour l'article modifié a partir de son identifiant
        $article -> update($validateData) ; 

        // Retour de la création de l'article au format JSON.

        return response()->json([   // Retourne la liste des articles au format JSON
            'success' => true ,
            'message' => 'Article modifié avec succès',
            'article' => $article
        ] , 201 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
        
                // On met à jour l'article modifié a partir de son identifiant
                $article->delete() ; 
        
                // Retour de la création de l'article au format JSON.
        
                return response()->json([   // Retourne la liste des articles au format JSON
                    'success' => true ,
                    'message' => 'Article supprimé avec succès',
                ] , 201 );
            
    }
}
