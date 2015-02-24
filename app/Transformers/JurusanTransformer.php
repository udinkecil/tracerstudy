<?php  namespace App\Transformers; 

use App\Jurusan;
use League\Fractal\TransformerAbstract;

class JurusanTransformer extends TransformerAbstract {
    public function transform(Jurusan $jurusan)
    {
        return [
            'id' => (int) $jurusan->recid,
            'kode_jurusan' => $jurusan->kdjur,
            'nama_jurusan' => $jurusan->nmjur
        ];
    }
}