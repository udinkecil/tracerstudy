<?php  namespace App\Transformers;

use App\Mahasiswa;
use League\Fractal\TransformerAbstract;

class TracerTransformer extends TransformerAbstract {
    public function transform(Mahasiswa $mahasiswa)
    {
        return [
            'id'             => (int) $mahasiswa->recid,
            'nim'            => $mahasiswa->nimhs,
            'nama_mahasiswa' => trim($mahasiswa->nmmhs),
            'kelamin'        => $mahasiswa->kelamin->nmkod,
            'tahun_lulus'    => ($mahasiswa->tglre) ? $mahasiswa->tglre->year : null,
            'program_studi'  => $mahasiswa->jurusan->nmjur,
            'predikat'       => ($mahasiswa->predikat) ? $mahasiswa->predikat->nmkod : null,
            'status_kuliah'  => ($mahasiswa->status) ? $mahasiswa->status->nmkod : null,
            'email'          => ($mahasiswa->usrnm) ? "{$mahasiswa->usrnm}@std.moestopo.ac.id" : null,
            'total_sks'      => $mahasiswa->skstt,
            'ipk'            => $mahasiswa->nlipk,
            'photo_url'      => [ 'thumbnail' => ($mahasiswa->photo)
                ? "http://mahasiswa.moestopo.ac.id/foto/thumbnail/{$mahasiswa->photo}"
                : "assets/admin/layout3/img/{$mahasiswa->kelamin->nmkod}.png",
                                   'large' => ($mahasiswa->photo)
                                       ? "http://mahasiswa.moestopo.ac.id/foto/{$mahasiswa->photo}"
                                       : "assets/admin/layout3/img/{$mahasiswa->kelamin->nmkod}.png" ]
        ];
    }
}