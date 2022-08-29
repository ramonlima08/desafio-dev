<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_import_history_status_code()
    {
        $response = $this->get('/api/importhistory');
        $response->assertStatus(200);
    }

    public function test_get_import_history_toreverse_status_code()
    {
        $response = $this->post('/api/importhistory/toreverse', [
            'id' => null
        ]);
        $response->assertJson([
            'error' => [
                "type" => "validator"
             ]
        ]);
    }
}
