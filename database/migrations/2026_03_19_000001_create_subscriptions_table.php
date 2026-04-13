// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {    public function up(): void
//     {
//         if (!Schema::hasTable('subscriptions')) Schema::create('subscriptions', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->onDelete('cascade');
//             $table->string('plan')->default('starter');           // starter | monthly | annual
//             $table->string('status')->default('free');            // free | active | expired | cancelled
//             $table->string('m_payment_id')->nullable()->unique(); // our reference sent to PayFast
//             $table->string('payfast_token')->nullable();          // PayFast payment ID returned
//             $table->decimal('amount_paid', 8, 2)->nullable();     // R0 | R450 | R5000
//             $table->timestamp('starts_at')->nullable();
//             $table->timestamp('expires_at')->nullable();
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('subscriptions');
//     }
// };