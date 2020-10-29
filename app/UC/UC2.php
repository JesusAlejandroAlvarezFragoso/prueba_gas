<?php
namespace App\UC;

use Illuminate\Support\Facades\Http;
use App\Models\Mex_CP;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class UC2
{
	/**
	 * Regresa recursos necesarios para el formulario de mapa.
	 * @package	TestGas.App.UC.UC2.__invoke
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @return	\StdClass
	 * @uses	\App\Models\Mex_CP::groupBy
	 * @since	Versión 1.0, revisión 2.
	 */
	public function __invoke(): \StdClass
	{
		$states = Mex_CP::groupBy('d_estado')
			->selectRaw('d_estado as value')
			->get()
		;
		$mniops = Mex_CP::groupBy('d_mnpio')
			->selectRaw('d_mnpio as value')
			->get()
		;

		return (Object)[
			'states'=>$states,
			'munics'=>$mniops
		];
	}
}
