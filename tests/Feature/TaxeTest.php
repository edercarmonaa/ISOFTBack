<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaxeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
      /*
      $data = [
           'taxe_user' => "usuario@example.test",
           'taxe_rfc' => "XAXX010101000",
           'taxe_company' => "Empresa Ejemplo SA de CV",
           'taxe_email' => "facturacion@example.test"
         ];
      $token = "test_jwt_token";
      $response = $this->call('POST', '/api/taxes', $data, [], [], ['HTTP_Authorization' => 'Bearer '.$token]);
      $response
          ->assertStatus(200)
          ->assertJson(['success' => true]);
    $this->assertDatabaseHas('taxes', $data);

    $response = $this->call('POST', '/api/update_taxes', $data, [], [], ['HTTP_Authorization' => 'Bearer '.$token]);
    $response
        ->assertStatus(200)
        ->assertJson(['success' => true]);
  $this->assertDatabaseHas('taxes', $data);*/
    }
}
