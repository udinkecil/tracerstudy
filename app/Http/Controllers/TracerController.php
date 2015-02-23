<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Mahasiswa;
use App\Transformers\TracerTransformer;

class TracerController extends ApiController {

    public function index(Mahasiswa $mahasiswa)
    {
        $paginator = $mahasiswa->where('stakl', 'L')->paginate(25);

        return $this->respondWithPaginate($paginator, new TracerTransformer());
    }

}
