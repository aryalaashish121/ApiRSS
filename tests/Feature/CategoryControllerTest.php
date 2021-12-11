<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function new_category_can_be_created()
    {
        $data = [
            'name'=>"Business"
        ];
        $response = $this->post('/api/category/create',$data);
        $response->assertStatus(201);
    }

    /** @test */
    public function fetching_categories_data(){
        $response= $this->get('/api/allcategories');
        $response->assertStatus(200);
    }
}
