<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvImportTest extends TestCase
{
    use RefreshDatabase;

    public function testCsvImport()
    {
        Storage::fake('csv'); // Fake the storage disk

        $file = UploadedFile::fake()->create('import.csv'); 
        $response = $this->post('/import', ['file' => $file]); 

        $response->assertStatus(302); 
        
      
    }
}