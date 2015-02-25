<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function status()
    {
        return $this->belongsTo('App\Code', 'stakl', 'kdkod')->where('kdgrp', '05');
    }

    public function getDates()
    {
        return ['tglre', 'tglhr'];
    }
    
    public function scopeIpkBetween($query, $start = null, $end = null)
    {
        return (empty($start)) ? $query : $query->whereBetween('nlipk', [$start, $end]);
    }

    public function scopeYearBetween($query, $start = null, $end = null)
    {
        return (empty($start)) ? $query : $query->whereBetween(DB::raw("YEAR(tglre)"), [$start, $end]);
    }

    public function scopeSearchName($query, $term = null)
    {
        return (empty($term)) ? $query : $query->where('nmmhs', 'LIKE', '%'.$term.'%');
    }

    public function scopeSearchNim($query, $nimhs = null)
    {
        return (empty($nimhs)) ? $query : $query->where('nimhs', 'LIKE', '%'.$nimhs.'%');
    }

    public function scopeSearchJurusan($query, $kdjur = null)
    {
        return (empty($kdjur)) ? $query : $query->where('kdjur', '=', $kdjur);
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status['lulus'] && $status['aktif']) {
            return $query;
        } else if ($status['lulus'] && ! $status['aktif']) {
            return $query->where('stakl', 'L');
        } else if (! $status['lulus'] && $status['aktif']) {
            return $query->where('stakl', 'A');
        }

        return $query;
    }

    public function scopeSorting($query, $sort)
    {
        $sortType = [ 'DESC', 'ASC' ];
        $field = "{$sort['field']}";

        return $query->orderBy($field, $sortType[$sort['sort']]);
    }
}
