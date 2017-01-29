<?php

namespace Tests\Feature;


use App\Role;
use App\User;
use App\Record;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class RecordsControllerTest extends TestCase
{
    public function testAddStartRecord()
    {
        $user = factory(User::class)->create();
        $user->roles()->save(Role::where('role_name', 'worker')->first());

        $response = $this->actingAs($user)->withoutMiddleware()->json('POST', '/record/add', ['type' => 'WORK']);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);

        $response_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('record_id',$response_array);
    }
    public function testAddStartRecordStartedTime()
    {
        $user = factory(User::class)->create();
        $user->roles()->save(Role::where('role_name', 'worker')->first());

        $response = $this->actingAs($user)->withoutMiddleware()->json('POST', '/record/add', ['type' => 'WORK']);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);

        $response = $this->actingAs($user)->json('POST', '/record/add', ['type' => 'WORK']);
        $response->assertStatus(405);
        $response->assertJson(['status' => false]);

    }
    public function testFinishRecord()
    {
        $user = factory(User::class)->create();
        $user->roles()->save(Role::where('role_name', 'worker')->first());

        $response = $this->actingAs($user)->withoutMiddleware()->json('POST', '/record/add', ['type' => 'WORK']);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);

        $response_array = (array)json_decode($response->content());

        $response = $this->actingAs($user)->json('PATCH', '/record/finish', ['record_id' => $response_array['record_id']]);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }
}
