<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        Um pedido deve incluir:
        - ID do pedido
        - Nome do solicitante -> requester_name
        - O destino -> destination
        - Data de ida -> departure_date
        - Data de volta -> return_date
        - Status -> status
            solicitado -> requested
            aprovado -> approved
            cancelado -> canceled
        */
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->string('destination');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['requested', 'approved', 'canceled'])->default('requested');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();

            $table->softDeletes();

            // Otimizando as buscas com o index
            $table->index('status');
            $table->index('destination');
            $table->index(['departure_date', 'return_date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};
