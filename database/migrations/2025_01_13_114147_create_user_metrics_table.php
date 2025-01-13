<?php

use App\Models\User;
use App\Models\UserMetric;
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
        Schema::create('user_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->integer('total_categories');
            $table->integer('total_ideas');
            $table->integer('total_notes');
            $table->integer('total_usage_time')->default(0);
            $table->foreignId('last_category_created')->nullable()->references('id')->on('categories');
            $table->timestamps();
        });

        $users = User::all();

        foreach ($users as $user) {
            $lastCategoryCreated = $user->categories()->orderBy('created_at', 'desc')->first();
            $totalCategories = $user->categories->count();
            $totalIdeas = $user->ideas->count();
            $totalNotes = $user->notes->count();

            UserMetric::create([
                'user_id' => $user->id,
                'total_categories' => $totalCategories,
                'total_ideas' => $totalIdeas,
                'total_notes' => $totalNotes,
                'last_category_created' => $lastCategoryCreated->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_metrics');
    }
};
