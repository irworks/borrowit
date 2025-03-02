<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DynamicContentSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('dynamic_contents')->insert([
            [
                'slot' => 'below_navbar',
                'content' => '<div>This is the <i>below_navbar</i> slot.</div>',
                'html' => 1,
            ],
            [
                'slot' => 'above_page_content',
                'content' => '<div>This is the <i>above_page_content</i> slot.</div>',
                'html' => 1,
            ],
            [
                'slot' => 'below_page_content',
                'content' => '<div>This is the <i>below_page_content</i> slot.</div>',
                'html' => 1,
            ],
            [
                'slot' => 'footer',
                'content' => '<div class="d-flex justify-content-center">
                                <p>This is the <i>footer</i> slot.</p>
                              </div>',
                'html' => 1,
            ],
        ]);
    }
}
