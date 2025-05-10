<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = DB::table('categories')->get();

        foreach ($categories as $category) {
            DB::table('categories')
                ->where('id', $category->id)
                ->update([
                    'name' => json_encode([app()->getLocale() => $category->name])
                ]);
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->json('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_string')->after('name');
        });

        $categories = DB::table('categories')->get();

        foreach ($categories as $category) {
            $nameData = json_decode($category->name, true);
            $name = $nameData[app()->getLocale()] ?? '';

            DB::table('categories')
                ->where('id', $category->id)
                ->update([
                    'name_string' => $name
                ]);
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('name_string', 'name');
        });
    }
};
