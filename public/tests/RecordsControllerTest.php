<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecordsControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddStartRecord()
    {
        $user = factory(App\User::class)->create();
        $role = App\Role::where('role_name', 'worker')->first();
        $user->roles()->save($role);

        $response = $this->actingAs($user)
                            ->withSession(['type' => 'WORK'])
                            ->post('/record/add');
        $response->assertResponseStatus(200);
    }
}
