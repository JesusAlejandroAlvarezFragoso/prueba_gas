<?php
namespace App\UC;

use Illuminate\Support\Facades\Http;
use App\Models\Mex_CP;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class UC3
{
	/**
	 * Regresa recursos necesarios para el formulario de mapa.
	 * @package	TestGas.App.UC.UC3.__invoke
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	string $state: estado filtro
	 * @return	\Illuminate\Database\Eloquent\Collection
	 * @uses	\App\Models\Mex_CP::where
	 * @since	Versión 1.0, revisión 2.
	 */
	public function __invoke(string $state):
	\Illuminate\Database\Eloquent\Collection
	{
		$mniops = Mex_CP::where('d_estado', $state)
			->selectRaw('d_mnpio as value')
			->groupBy('d_mnpio')
			->get()
		;

		return $mniops;
	}
}
