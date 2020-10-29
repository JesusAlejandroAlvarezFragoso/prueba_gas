<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UC;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class GeographicController extends Controller
{
	/**
	 * Regresa los recursos con los municipios filtrados.
	 * @package	TestGas.App.Http.Controllers.GeographicController.show_munics
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	\Illuminate\Http\Request $request
	 * @param	string $state: estado que se usa como filtro
	 * @return	\Illuminate\Http\JsonResponse
	 * @uses	\App\UC\UC3
	 * @since	Versión 1.0, revisión 2.
	 */
	public function show_munics(Request $request, string $state):
	\Illuminate\Http\JsonResponse
	{
		$uc = new UC\UC3();

		$results = $uc($state);

    	return  response()->json([
		    'resources'=>[
				'munics'=>$results
			]
		]);
    }
}
