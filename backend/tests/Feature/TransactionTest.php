<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * Teste requisição summary
     *
     * @return void
     */
    public function test_get_summary_status_code()
    {
        $response = $this->get('/api/summary');
        $response->assertStatus(200);
    }

    public function test_get_transactions_status_code()
    {
        $response = $this->get('/api/transaction');
        $response->assertStatus(200);
    }

    public function test_get_store_status_code()
    {
        $response = $this->get('/api/store');
        $response->assertStatus(200);
    }

    public function test_post_transaction_store_status_code()
    {
        $response = $this->post('/api/transaction/store');
        $response->assertStatus(200);
    }

    public function test_post_fail_transaction_import_status_code()
    {
        $response = $this->post('/api/transaction/import');
        $response->assertStatus(422);
    }

    public function test_dont_transaction_import_file_requests()
    {
        $response = $this->post('/api/transaction/import', [
            'file' => null,
        ]);
        $response->assertJson([
            'error' => [
                "type" => "validator"
             ]
        ]);
    }
    
    
}
