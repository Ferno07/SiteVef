<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Projet;
use App\Services\EditorialData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EditorialController extends Controller
{
    public function sitemap()
    {
        return response()->view('sitemap', ['projets' => Projet::published()->get(), 'articles' => Article::published()->get()])->header('Content-Type', 'application/xml');
    }

    public function projets(Request $r)
    {
        $q = Projet::published()->with('images')->latest();
        if (in_array($r->statut, ['en_cours', 'a_venir', 'realise'])) {
            $q->where('statut', $r->statut);
        }

        return view('projets.index', ['projets' => $q->paginate(12)->withQueryString()]);
    }

    public function projet($slug)
    {
        return $this->projectView(Projet::published()->where('slug', $slug)->firstOrFail());
    }

    private function projectView(Projet $projet, bool $preview = false)
    {
        $projet->load('images');

        return view('projets.show', compact('projet', 'preview') + ['articles' => $projet->articles()->published()->latest('published_at')->get()]);
    }

    public function previewProjet(Projet $projet)
    {
        return $this->projectView($projet, true);
    }

    public function editProjet(Projet $projet)
    {
        return view('admin.project-edit', compact('projet'));
    }

    public function articles(Request $r)
    {
        $q = Article::published()->with('category')->latest('published_at');
        if ($r->filled('categorie')) {
            $q->where('category_id', $r->categorie);
        }

        return view('actualites.index', ['articles' => $q->paginate(12)->withQueryString(), 'categories' => Category::orderBy('nom')->get()]);
    }

    public function article($slug)
    {
        $article = Article::published()->with(['category', 'projets' => fn ($q) => $q->published()])->where('slug', $slug)->firstOrFail();

        return view('actualites.show', compact('article') + ['preview' => false, 'similaires' => Article::published()->where('id', '!=', $article->id)->where('category_id', $article->category_id)->latest('published_at')->limit(3)->get()]);
    }

    public function previewArticle(Article $article)
    {
        $article->load(['category', 'projets' => fn ($q) => $q->published()]);

        return view('actualites.show', compact('article') + ['preview' => true, 'similaires' => collect()]);
    }

    public function editArticle(?Article $article = null)
    {
        return view('admin.article-edit', ['article' => $article ?? new Article, 'categories' => Category::orderBy('nom')->get(), 'projets' => Projet::orderBy('titre')->get()]);
    }

    public function saveArticle(Request $r, ?Article $article = null)
    {
        $data = $r->validate(['titre' => 'required|string|max:255', 'slug' => ['nullable', 'alpha_dash', 'max:220', Rule::unique('articles')->ignore($article?->id)], 'extrait' => 'nullable|string|max:1000', 'contenu' => 'required|string|max:100000', 'category_id' => 'nullable|exists:categories,id', 'publication' => ['required', Rule::in(['brouillon', 'publie'])], 'seo_title' => 'nullable|string|max:255', 'meta_description' => 'nullable|string|max:255', 'image' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:3072', 'image_alt' => 'nullable|string|max:255', 'projets' => 'nullable|array', 'projets.*' => 'integer|exists:projets,id', 'retirer_image' => 'nullable|boolean']);
        $data['slug'] = $data['slug'] ?? $article?->slug ?? ((Str::slug($data['titre']) ?: 'article').'-'.Str::lower(Str::random(6)));
        if ($r->hasFile('image')) {
            $data['image'] = EditorialData::upload($r->file('image'), 'imagesActualites');
        } else {
            unset($data['image']);
            if ($r->boolean('retirer_image')) {
                $data['image'] = null;
            }
        }
        $data['published_at'] = $data['publication'] === 'publie' ? ($article?->published_at ?? now()) : null;
        unset($data['projets'],$data['retirer_image']);
        $article ??= new Article;
        \Illuminate\Support\Facades\DB::transaction(function () use ($article, $data, $r) {
            $article->fill($data)->save();
            $article->projets()->sync($r->input('projets', []));
        });

        return redirect()->route('admin.articles.edit', $article)->with('success', 'Article enregistré.');
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.projets.index')->with('success', 'Article supprimé.');
    }

    public function saveCategory(Request $r, ?Category $category = null)
    {
        $data = $r->validate(['nom' => ['required', 'string', 'max:100', Rule::unique('categories')->ignore($category?->id)]]);
        $category ??= new Category;
        $category->fill($data)->save();

        return back()->with('success', 'Catégorie enregistrée.');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();

        return back()->with('success','Catégorie supprimée ; les articles sont conservés.');
    }
}
