<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Jurusan;
use App\Transformers\JurusanTransformer;
use Illuminate\Http\Request;

class JurusanController extends ApiController {

	public function index(Jurusan $jurusan)
	{
	    $resource = $jurusan->all();

        return $this->respondWithCollection($resource, new JurusanTransformer());
	}

}
