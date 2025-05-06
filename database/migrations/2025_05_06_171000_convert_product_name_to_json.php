<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert existing string values to JSON
        $products = DB::table('products')->get();
        
        foreach ($products as $product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'name' => json_encode([
                        app()->getLocale() => $product->name
                    ])
                ]);
        }
        
        // Now change the column type to JSON
        Schema::table('products', function (Blueprint $table) {
            $table->json('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, add a temporary string column
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_string')->after('name');
        });
        
        // Convert JSON values to the temporary string column
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $nameData = json_decode($product->name, true);
            $name = $nameData[app()->getLocale()] ?? '';
            
            DB::table('products')
                ->where('id', $product->id)
                ->update(['name_string' => $name]);
        }
        
        // Drop the JSON column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('name');
        });
        
        // Rename the temporary column to the original name
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name_string', 'name');
        });
    }
}; 