<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use EscolaLms\HeadlessH5P\Tests\TestCase;
use EscolaLms\HeadlessH5P\Models\H5PLibrary;
//use Illuminate\Support\Facades\App;

use EscolaLms\HeadlessH5P\Services\Contracts\HeadlessH5PServiceContract;

class ContentApiTest extends TestCase
{
    public function test_library_create()
    {
        $filename = 'arithmetic-quiz.h5p';
        $filepath = realpath(__DIR__.'/../mocks/'.$filename);
        $storage_path = storage_path($filename);

        copy($filepath, $storage_path);

        $h5pFile = new UploadedFile($storage_path, 'arithmetic-quiz.h5p', 'application/pdf', null, true);

        $response = $this->post('/api/hh5p/library', [
            'h5p_file' => $h5pFile,
        ]);

        $library = H5PLibrary::first();

        // TODO this should be from factory ?
        $response = $this->postJson('/api/hh5p/content', [
            "nonce"=>bin2hex(random_bytes(4)),
            "title"=>"The Title",
            "library"=>$library->uberName,
            "params"=>"{\"params\":{\"taskDescription\":\"Documentation tool\",\"pagesList\":[{\"params\":{\"elementList\":[{\"params\":{},\"library\":\"H5P.Text 1.1\",\"metadata\":{\"contentType\":\"Text\",\"license\":\"U\",\"title\":\"Untitled Text\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Text\"},\"subContentId\":\"da3387da-355a-49fb-92bc-3a9a4e4646a9\"}],\"helpTextLabel\":\"More information\",\"helpText\":\"\"},\"library\":\"H5P.StandardPage 1.5\",\"metadata\":{\"contentType\":\"Standard page\",\"license\":\"U\",\"title\":\"Untitled Standard page\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Standard page\"},\"subContentId\":\"ac6ffdac-be02-448c-861c-969e6a09dbd5\"}],\"i10n\":{\"previousLabel\":\"poprzedni\",\"nextLabel\":\"Next\",\"closeLabel\":\"Close\"}},\"metadata\":{\"license\":\"U\",\"authors\":[],\"changes\":[],\"extraTitle\":\"fdsfds\",\"title\":\"fdsfds\"}}"
        ]);

        if ($response->status() >= 422) {
            echo $response->content();
        }

        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
    }

    public function test_library_create_no_nonce()
    {
        $library = H5PLibrary::first();

        $response = $this->postJson('/api/hh5p/content', [
            "title"=>"The Title",
            "library"=>"Invalid lib name",
            "params"=>"{\"params\":{\"taskDescription\":\"Documentation tool\",\"pagesList\":[{\"params\":{\"elementList\":[{\"params\":{},\"library\":\"H5P.Text 1.1\",\"metadata\":{\"contentType\":\"Text\",\"license\":\"U\",\"title\":\"Untitled Text\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Text\"},\"subContentId\":\"da3387da-355a-49fb-92bc-3a9a4e4646a9\"}],\"helpTextLabel\":\"More information\",\"helpText\":\"\"},\"library\":\"H5P.StandardPage 1.5\",\"metadata\":{\"contentType\":\"Standard page\",\"license\":\"U\",\"title\":\"Untitled Standard page\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Standard page\"},\"subContentId\":\"ac6ffdac-be02-448c-861c-969e6a09dbd5\"}],\"i10n\":{\"previousLabel\":\"poprzedni\",\"nextLabel\":\"Next\",\"closeLabel\":\"Close\"}},\"metadata\":{\"license\":\"U\",\"authors\":[],\"changes\":[],\"extraTitle\":\"fdsfds\",\"title\":\"fdsfds\"}}"
        ]);

        $response->assertStatus(422);
    }

    public function test_library_create_invalid_library()
    {
        $library = H5PLibrary::first();

        $response = $this->postJson('/api/hh5p/content', [
            "nonce"=>bin2hex(random_bytes(4)),
            "title"=>"The Title",
            "library"=>"Invalid lib name",
            "params"=>"{\"params\":{\"taskDescription\":\"Documentation tool\",\"pagesList\":[{\"params\":{\"elementList\":[{\"params\":{},\"library\":\"H5P.Text 1.1\",\"metadata\":{\"contentType\":\"Text\",\"license\":\"U\",\"title\":\"Untitled Text\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Text\"},\"subContentId\":\"da3387da-355a-49fb-92bc-3a9a4e4646a9\"}],\"helpTextLabel\":\"More information\",\"helpText\":\"\"},\"library\":\"H5P.StandardPage 1.5\",\"metadata\":{\"contentType\":\"Standard page\",\"license\":\"U\",\"title\":\"Untitled Standard page\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Standard page\"},\"subContentId\":\"ac6ffdac-be02-448c-861c-969e6a09dbd5\"}],\"i10n\":{\"previousLabel\":\"poprzedni\",\"nextLabel\":\"Next\",\"closeLabel\":\"Close\"}},\"metadata\":{\"license\":\"U\",\"authors\":[],\"changes\":[],\"extraTitle\":\"fdsfds\",\"title\":\"fdsfds\"}}"
        ]);

        $response->assertStatus(422);
    }

    public function test_library_create_invalid_json()
    {
        $library = H5PLibrary::first();

        $response = $this->postJson('/api/hh5p/content', [
            "nonce"=>bin2hex(random_bytes(4)),
            "title"=>"The Title",
            "library"=>$library->uberName,
            "params"=>"XXX!!!{\"params\":{\"taskDescription\":\"Documentation tool\",\"pagesList\":[{\"params\":{\"elementList\":[{\"params\":{},\"library\":\"H5P.Text 1.1\",\"metadata\":{\"contentType\":\"Text\",\"license\":\"U\",\"title\":\"Untitled Text\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Text\"},\"subContentId\":\"da3387da-355a-49fb-92bc-3a9a4e4646a9\"}],\"helpTextLabel\":\"More information\",\"helpText\":\"\"},\"library\":\"H5P.StandardPage 1.5\",\"metadata\":{\"contentType\":\"Standard page\",\"license\":\"U\",\"title\":\"Untitled Standard page\",\"authors\":[],\"changes\":[],\"extraTitle\":\"Untitled Standard page\"},\"subContentId\":\"ac6ffdac-be02-448c-861c-969e6a09dbd5\"}],\"i10n\":{\"previousLabel\":\"poprzedni\",\"nextLabel\":\"Next\",\"closeLabel\":\"Close\"}},\"metadata\":{\"license\":\"U\",\"authors\":[],\"changes\":[],\"extraTitle\":\"fdsfds\",\"title\":\"fdsfds\"}}"
        ]);

        $response->assertStatus(422);
    }
}