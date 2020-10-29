<?php
namespace App\Http\Controllers;

use App\Http\Requests\GasolineMap;
use Illuminate\Http\Request;
use App\UC;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class MapController extends Controller
{
	/**
	 * Regresa los recursos para mostrar en el mapa de puntos.
	 * @package	TestGas.App.Http.Controllers.MapController.read_gasoline
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	\App\Http\Requests\GasolineMap $request
	 * @return	\Illuminate\Http\JsonResponse
	 * @uses	\App\UC\UC1
	 * @since	Versión 1.0, revisión 2.
	 */
	public function read_gasoline(GasolineMap $request):
	\Illuminate\Http\JsonResponse
	{
		$params = $request->validated();
		$uc = new UC\UC1();

		$results = $uc($params);

    	return  response()->json([
		    'resources'=>[
				'points'=>$results
			]
		]);
    }

	/**
	 * Regresa los recursos para mostrar en el mapa de puntos.
	 * @package	TestGas.App.Http.Controllers.MapController.show_read_gas
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	\Illuminate\Http\Request $request
	 * @return	\Illuminate\Http\JsonResponse
	 * @uses	\App\UC\UC2
	 * @since	Versión 1.0, revisión 2.
	 */
	public function show_read_gas(Request $request):
	\Illuminate\Http\JsonResponse
	{
		$uc = new UC\UC2();
		$resouces = $uc();

    	return response()->json([
		    'resources'=>$resouces
		]);
	}
}
