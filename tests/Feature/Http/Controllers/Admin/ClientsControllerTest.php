<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Client;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Test basic client's collection list
     * @return void
     */
    public function test_has_filled_client_collection()
    {
        $aClient = factory(Client::class, 1)->create();

        $response = $this->get(route('admin.clients.index'));
        $response->assertStatus(200);
        $response->assertViewHas(['clients', 'paginator']);

        /* @var $clients Collection */
        $clients = $response->original->getData()['clients'];

        $this->assertInstanceOf(Collection::class, $clients);
        $this->assertNotEmpty($clients);
        $this->assertInstanceOf(Client::class, $clients->first());
        $this->assertEquals($aClient->first()->id, $clients->first()->id);
    }

    /**
     * Test basic client's empty collection
     * @return void
     */
    public function test_has_empty_client_collection()
    {
        $response = $this->get(route('admin.clients.index'));
        $response->assertStatus(200);
        $response->assertViewHas(['clients', 'paginator']);

        /* @var $clients Collection */
        $clients = $response->original->getData()['clients'];

        $this->assertInstanceOf(Collection::class, $clients);
        $this->assertEmpty($clients);
    }

    /**
     * Test search functionality with a piece of a name, email, whatsapp
     * @return void
     */
    public function test_partial_search()
    {
        /* @var $clients Collection */

        // create some random Client, so we have a large collection
        // plus one expected for tests purposes
        factory(Client::class, 50)->create();

        $partialName = str_random(10);
        $partialEmail = str_random(10);
        $partialWhats = '14521452';

        $expectedName = 'Client test ' . $partialName;
        $expectedEmail = $partialEmail . '@test.com';
        $expectedWhats = '99 ' . $partialWhats;

        factory(Client::class, 1)->create([
            'nome' => $expectedName,
            'email' => $expectedEmail,
            'whatsapp' => $expectedWhats,
        ]);

        // search with known name part
        $response = $this->get(route('admin.clients.index') . '?search=' . $partialName);
        $response->assertStatus(200);
        $clients = $response->original->getData()['clients'];
        $this->assertCount(1, $clients);
        $this->assertEquals($expectedName, $clients->first()->nome);

        // search with known email part
        $response = $this->get(route('admin.clients.index') . '?search=' . $partialEmail);
        $response->assertStatus(200);
        $clients = $response->original->getData()['clients'];
        $this->assertCount(1, $clients);
        $this->assertEquals($expectedEmail, $clients->first()->email);

        // search with known whatsapp part
        $response = $this->get(route('admin.clients.index') . '?search=' . $partialWhats);
        $response->assertStatus(200);
        $clients = $response->original->getData()['clients'];
        $this->assertCount(1, $clients);
        $this->assertEquals($expectedWhats, $clients->first()->whatsapp);
    }

    /**
     * Test if search term supplied on request is present as data variable on view
     */
    public function test_view_has_search_term_when_supplied()
    {
        $response = $this->get(route('admin.clients.index') . '?search=searchTermValue');
        $response->assertStatus(200);
        $response->assertViewHas('searchTerm');
        $this->assertEquals('searchTermValue', $response->original->getData()['searchTerm']);
    }

    /**
     * Test when multi search terms is supplied on request, it's present as unified term
     * data variable on view
     */
    public function test_view_has_unified_search_term_when_multi_terms_supplied_on_request()
    {
        $response = $this->get(route('admin.clients.index') . '?search=searchTermValue searchTermValue2');
        $response->assertStatus(200);
        $response->assertViewHas('searchTerm');
        $this->assertEquals('searchTermValue searchTermValue2', $response->original->getData()['searchTerm']);
    }

    /**
     * Basic show request test with valid Client::id
     */
    public function test_show_with_existent_client()
    {
        /* @var $responseClient Client */

        // create some ($total) test clients
        $client = factory(Client::class, 10)->create()->get(5);
        $response = $this->get(route('admin.clients.show', ['id' => $client->id]));

        $response->assertStatus(200);
        $response->assertViewHas('client');
        $responseClient = $response->original->getData()['client'];
        $this->assertInstanceOf(Client::class, $responseClient);
        $this->assertEquals($client->id, $responseClient->id);
    }

    /**
     * Show request test with invalid Client::id
     */
    public function test_show_with_non_existent_client()
    {
        $response = $this->get(route('admin.clients.show', ['id' => '1234']));
        $response->assertStatus(404);
    }

}
