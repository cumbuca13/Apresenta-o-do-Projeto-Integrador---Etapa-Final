<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Dentista;
use App\Models\Atendimento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AtendimentoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_atendimento_autenticado(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $paciente = Paciente::factory()->create();
        $dentista = Dentista::factory()->create([
            'nome' => 'Dr. Silva',
            'especialidade' => 'Endodontia',
            'email' => 'silva@ex.com'
        ]);

        $payload = [
            'paciente_id' => $paciente->id,
            'dentista_id' => $dentista->id,
            'data' => now()->toDateTimeString(),
            'descricao' => 'Consulta de rotina',
            'status' => 'Agendado'
        ];

        $response = $this->postJson('/api/atendimentos', $payload);
        $response->assertCreated()->assertJsonFragment(['descricao' => 'Consulta de rotina']);
        $this->assertDatabaseHas('atendimentos', ['paciente_id' => $paciente->id]);
    }
}
