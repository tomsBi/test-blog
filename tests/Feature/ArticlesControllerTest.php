<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->followingRedirects();

        $response = $this->post(route('articles.store'), [
            'title' => 'Example title',
            'content' => 'Example content'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Example title',
            'content' => 'Example content'
        ]);
    }

    public function testDeleteArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);

        $this->followingRedirects();

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    public function testShowAllArticles(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertSee($article->id);
        $response->assertSee($article->title);
        $response->assertSee($article->created_at->format('Y-m-d h:i'));
        $response->assertSee($article->updated_at->format('Y-m-d h:i'));
    }

    public function testStoreArticles(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $response = $this->post(route('articles.store'), [
            'title' => $article->title,
            'content' => $article->content
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    public function testShowArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $response = $this->get(route('articles.show', [
            'article' => $article
        ]));

        $response->assertStatus(200);
        $response->assertSee($article->title);
        $response->assertSee($article->content);
        $response->assertSee($article->id);
    }

    public function testEditArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.edit', [
            'article' => $article
        ]));

        $response->assertStatus(200);
        $response->assertSee($article->title);
        $response->assertSee($article->content);
    }

    public function testUpdateArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $response = $this->put(route('articles.update', [
            'article' => $article
        ]),[
            'title' => 'Updated title',
            'content'=> 'Updated content'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated title',
            'content' => 'Updated content'
        ]);
    }

}
