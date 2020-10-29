<?php
namespace App\UC;

use Illuminate\Support\Facades\Http;
use App\Models\Mex_CP;

/**
 * @author 	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
 * @since 	29/10/2020
 */
class UC1
{
	/**
	 * @type	string
	 */
	private static $url;

	/**
	 * Construye los recursos para las peticiones.
	 * @package	TestGas.App.UC.UC1.__construct
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @since	Versión 1.0, revisión 2.
	 */
	public function __construct()
	{
		UC1::$url = 'https://api.datos.gob.mx/v1/precio.gasolina.publico?';
	}
	/**
	 * Busca puntos con API y regresa respuestas ordenadas.
	 * @package	TestGas.App.UC.UC1.__invoke
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	array $params: parametros de busqueda
	 * @return	\Illuminate\Support\Collection
	 * @uses	\App\UC\UC1::getApiResults
	 * @uses	\App\UC\UC1::getCPObjects
	 * @since	Versión 1.0, revisión 2.
	 */
	public function __invoke(array $params): \Illuminate\Support\Collection
	{
		//Hacemos peticiones
		$response_body = UC1::getApiResults($params);
		$zips = [];

		//Rastreamos CPs
		foreach ($response_body as $r) {
			if (empty($zips[ $r['codigopostal'] ])) {
				$zips[ $r['codigopostal'] ] = $r['codigopostal'];
			}
		}

		$cps = UC1::getCPObjects($zips);

		//completamos información
		foreach ($response_body as &$r) {
			if (isset($cps[ $r['codigopostal'] ])) {
				$cp = $cps[ $r['codigopostal'] ];
			}
			$r['dieasel'] = ($r['dieasel']!='')?$r['dieasel']:'desconocido';
			$r['municipio'] = $cp->d_mnpio??'desconocido';
			$r['estado'] = $cp->d_estado??'desconocido';
		}

		$results = collect($response_body);


		//Ordenamos por el criterio selecionado
		if (isset($params['sort']) and $params['sort']!='') {
			list($prop, $order) = explode('_', $params['sort']);

			$obj_prop = '';

			switch ($prop) {
				case 'PRICEREG': $obj_prop = 'regular'; break;
				case 'PRICEPRE': $obj_prop = 'premium'; break;
			}

			$results = ($order=='ASC')?
				$results->sortBy($obj_prop)
				: $results->sortByDesc($obj_prop)
			;
		}

		//regresamos resultados
		return $results;
	}

	/**
	 * Realiza peticiones a la API de acuerdo a los parametros.
	 * @package	TestGas.App.UC.UC1.getApiResults
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	array $data: parametros de busqueda
	 * @return	array
	 * @uses	\App\UC\UC1::orderParamsToSearch
	 * @uses	\Illuminate\Support\Facades\Http::get
	 * @since	Versión 1.0, revisión 2.
	 */
	public static function getApiResults(array $data): array
	{
		//Obtenemos paramentros de busqueda
		$params = UC1::orderParamsToSearch($data);
		$responses = [];
		$query = '';


		//Generamos qry de busqueda
		if (isset($params['pageSize'])) {
			$query.= 'pageSize='. $params['pageSize'] .'&';
		}


		//Hacemos consultas y unificamos resultados
		if (isset($params['munics'])) {
			foreach ($params['munics'] as $munic => $cps) {
				$cp_query = '';

				foreach ($cps as $k => $cp) {
					$cp_query .= 'codigopostal['. $k .']='. $cp .'&';
				}

				$response = Http::get(UC1::$url . $query . $cp_query);
				$response_body = $response->json();

				foreach ($response_body['results'] as $value) {
					$responses[] = $value;
				}
			}
		}
		else if (isset($params['codigopostal'])) {
			foreach ($params['codigopostal'] as $k => $cp_obj) {
				$query .= 'codigopostal['. $k .']='. $cp_obj->d_codigo .'&';
			}

			$response = Http::get(UC1::$url . $query);
			$response_body = $response->json();
			$responses = $response_body['results'];
		}


		return $responses;
	}

	/**
	 * Ordena parametros de busqueda para un resultado optimo.
	 * @package	TestGas.App.UC.UC1.orderParamsToSearch
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	array $data: parametros de busqueda
	 * @return	array
	 * @uses	\App\UC\UC1::getCPFromState
	 * @uses	\App\UC\UC3
	 * @since	Versión 1.0, revisión 2.
	 */
	public static function orderParamsToSearch(array $data) : array
	{
		$params = [];

		if (isset($data['pageSize'])) {
			$params['pageSize'] = $data['pageSize'];
		}

		if (isset($data['state'])) {
			if (empty($data['munic']) or $data['munic']=='') {
				$munics = [];
				$uc = new UC3();
				$state = $data['state'];
				$munics_obj = $uc($state);

				foreach ($munics_obj as $key => $munic) {
					$cps_obj = UC1::getCPFromState($state, $munic->value)
						->limit(21)
						->get()
					;
					$sub_cps = [];

					foreach ($cps_obj as $cp_obj) {
						$sub_cps[] = $cp_obj->d_codigo;
					}

					$munics[ $munic->value ] = $sub_cps;
				}

				$params['munics'] = $munics;
			} else {
				$cps = UC1::getCPFromState($data['state'], $data['munic']??'')
					->limit(21)
					->get()
				;

				$params['codigopostal'] = $cps;
			}
		}

		return $params;
	}

	/**
	 * Obtiene los objetos de la cubeta de códigos postales.
	 * @package	TestGas.App.UC.UC1.getCPObjects
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	array $zips: cps buscados
	 * @return	array
	 * @uses	\App\Models\Mex_CP::whereIn
	 * @since	Versión 1.0, revisión 2.
	 */
	public static function getCPObjects(array $zips): array
	{
		$cps = Mex_CP::whereIn('d_codigo', $zips)->get();
		$cps_cat = [];

		foreach ($cps as $cp) {
			$cps_cat[$cp->d_codigo] = $cp;
		}

		return $cps_cat;
	}

	/**
	 * Filtra los registros de acuerdo al estado y/o municipio.
	 * @package	TestGas.App.UC.UC1.getCPFromState
	 * @access	public
	 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
	 * @param	string $state: estado filtro
	 * @param	?string $munic='': municipio filtro
	 * @return	\Illuminate\Database\Eloquent\Builder
	 * @uses	\App\Models\Mex_CP::where
	 * @since	Versión 1.0, revisión 2.
	 */
	public static function getCPFromState(string $state, ?string $munic=''):
	\Illuminate\Database\Eloquent\Builder
	{
		$qry = Mex_CP::where('d_estado', $state)->groupBy('d_codigo');

		if ($munic!='') {
			$qry->where('d_mnpio', $munic);
		}

		return $qry;
	}
}
