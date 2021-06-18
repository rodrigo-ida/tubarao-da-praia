<?php

namespace Tests\Unit;

use App\Client;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery as m;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function tearDown()
    {
        m::close();
    }

    public function test_login_token_must_be_unique()
    {
        $service = new ClientService();

        $client = factory(Client::class)->make();
        $client->resetLoginToken($service);
        $client->save();
        $firstToken = $client->login_token;

        /* @var $service ClientService|\Mockery\MockInterface */
        $service = m::mock(ClientService::class.'[generateLoginToken]')->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('generateLoginToken')->times(1)->andReturn($firstToken);
        $service->shouldReceive('generateLoginToken')->atLeast(1)->passthru();

        $secondToken = $service->generateUniqueLoginToken();

        $this->assertNotEquals($firstToken, $secondToken);
    }

}