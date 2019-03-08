<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Epocler',
            'image' => 'https://drogariaspacheco.vteximg.com.br/arquivos/ids/347893-400-400/epocler-abacaxi-6-flaconetes-10ml-cada-Pacheco-504793.jpg?v=636663964469870000',
            'description' => Str::random(10)
        ]);
        DB::table('products')->insert([
            'name' => 'Dipirona',
            'image' => 'https://www.gigafarma.com.br/media/catalog/product/cache/1/thumbnail/600x600/9df78eab33525d08d6e5fb8d27136e95/l/e/legrand_20.png',
            'description' => Str::random(10),
        ]);
        DB::table('products')->insert([
            'name' => 'Eno',
            'image' => 'https://pngimage.net/wp-content/uploads/2018/05/eno-png.png',
            'description' => Str::random(10),
        ]);
        DB::table('products')->insert([
            'name' => 'Neosoro',
            'image' => 'https://catalogo.hypera.com.br/ImagensProdutos/3c277e6b-f5b5-4a7c-a9bc-41908c75d0b9.png',
            'description' => Str::random(10),
        ]);
        DB::table('products')->insert([
            'name' => 'Dorflex',
            'image' => 'https://pngimage.net/wp-content/uploads/2018/05/dorflex-png.png',
            'description' => Str::random(10),
        ]);
    }
}
