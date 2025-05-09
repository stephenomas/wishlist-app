<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WishlistFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/wishlist', [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Added to wishlist']);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_view_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/wishlist');

        $response->assertStatus(200)
            ->assertJsonFragment(['product_id' => $product->id]);
    }

    public function test_user_can_remove_product_from_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/wishlist/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Removed from wishlist']);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_cannot_remove_nonexistent_product_from_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/wishlist/{$product->id}");

        $response->assertStatus(404)
            ->assertJson(['message' => 'Product not in your wishlist']);
    }
}
