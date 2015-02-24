<?php namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Transformers\TracerTransformer;
use Illuminate\Http\Request;

class TracerController extends ApiController {

    public function index(Mahasiswa $mahasiswa)
    {
        $paginator = $mahasiswa->where('stakl', 'L')->paginate(25);

        return $this->respondWithPaginate($paginator, new TracerTransformer());
    }

    public function search(Request $request, Mahasiswa $mahasiswa)
    {
        $input = $request->json()->all();

//        if (isset($input['start_ipk'])) {
//            if (empty($input['end_ipk'])) {
//                $input['end_ipk'] = $input['start_ipk'];
//            }
//
//            if($input['start_ipk'] > $input['end_ipk']) {
//                $tmp = $input['start_ipk'];
//                $input['start_ipk'] = $input['end_ipk'];
//                $input['end_ipk']   = $tmp;
//            }
//        }

        $paginator =  $mahasiswa->ipkBetween($input['start_ipk'], $input['end_ipk'])
                                ->yearBetween($input['start_year'], $input['end_year'])
                                ->searchName($input['nmmhs'])
                                ->searchNim($input['nimhs'])
                                ->searchJurusan($input['kdjur'])
                                ->filterStatus($input['status'])
                                ->sorting($input['sort'])
                                ->paginate(25);

        if ($paginator)
        {
            return $this->respondWithPaginate($paginator, new TracerTransformer());
        }
    }

}
