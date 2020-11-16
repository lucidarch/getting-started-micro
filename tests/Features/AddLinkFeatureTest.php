<?php

namespace App\Tests\Features;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddLinkFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_submit_a_link()
    {
        $response = $this->post('/submit', [
            'title' => 'Example Title',
            'url' => 'http://example.com',
            'description' => 'Example description.',
        ]);

       $response->assertStatus(403);
       $response->assertSee('This action is unauthorized.');
    }

    public function test_link_is_not_created_if_validation_fails()
    {
        $response = $this->actingAs(User::factory()->create())->post('/submit');

        $response->assertSessionHasErrors(['title', 'url', 'description']);
    }

    /**
     * @dataProvider invalidURLs
     */
    public function test_link_is_not_created_with_invalid_url($case)
    {
        $response = $this->actingAs(User::factory()->create())
                         ->post('/submit', [
                            'url'  => $case,
                            'title' => 'Example Title',
                            'description' => 'Example description',
                        ]);

        $response->assertSessionHasErrors(['url' => 'The url format is invalid.']);
    }

    public function test_max_length_fails_when_too_long()
    {
        $title = str_repeat('a', 256);
        $description = str_repeat('a', 256);
        $url = 'http://';
        $url .= str_repeat('a', 256 - strlen($url));

        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->post('/submit', compact('title', 'url', 'description'));

        $response->assertSessionHasErrors([
            'url' => 'The url may not be greater than 255 characters.',
            'title' => 'The title may not be greater than 255 characters.',
            'description' => 'The description may not be greater than 255 characters.',
        ]);
    }

    public function test_max_length_succeeds_when_under_max()
    {
        $url = 'http://';
        $url .= str_repeat('a', 255 - strlen($url));

        $data = [
            'title' => str_repeat('a', 255),
            'url' => $url,
            'description' => str_repeat('a', 255),
        ];

        $this->actingAs(User::factory()->create())->post('/submit', $data);

        $this->assertDatabaseHas('links', $data);
    }

    public function invalidURLs()
    {
        return [
            ['foo.com'],
            ['/invalid-url'],
            ['//invalid-url.com'],
        ];
    }
}
