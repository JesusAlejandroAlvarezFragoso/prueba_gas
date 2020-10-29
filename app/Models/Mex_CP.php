<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class Mex_CP extends Model
{
	protected $primaryKey='mex_cp_id';
	protected $table='Mex_CPs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
	    'd_codigo',
	    'd_asenta',
	    'd_tipo_asenta',
	    'd_mnpio',
	    'd_estado',
	    'd_ciudad',
	    'd_CP',
	    'c_estado',
	    'c_oficina',
	    'c_CP',
	    'c_tipo_asenta',
	    'c_mnpio',
	    'id_asenta_cpcons',
	    'd_zona',
	    'c_cve_ciudad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
}
