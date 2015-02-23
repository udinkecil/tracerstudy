<?php  namespace App\Transformers;

use App\Mahasiswa;
use League\Fractal\TransformerAbstract;

class TracerTransformer extends TransformerAbstract {
    public function transform(Mahasiswa $mahasiswa)
    {
        return [
            'id' => (int) $mahasiswa->recid,
            'nim' => $mahasiswa->nimhs,
            'nama_mahasiswa' => trim($mahasiswa->nmmhs),
            'kelamin' => $mahasiswa->kelamin->nmkod,
            'program_studi' => $mahasiswa->jurusan->nmjur,
            'predikat' => $mahasiswa->predikat->nmkod
        ];
    }
}