<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model {

	protected $table = 'msmhs';
    protected $primaryKey = 'nimhs';
    
    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'kdjur', 'kdjur');
    }

    public function kelamin()
    {
        return $this->belongsTo('App\Code', 'kdkel', 'kdkod')->where('kdgrp', '08');
    }
    
    public function predikat()
    {
        return $this->belongsTo('App\Code', 'kdkat', 'kdkod')->where('kdgrp', '58');
    }
}
