new Vue({
	el: '#app',
	vuetify: new Vuetify(),
	data() {
		return {
			//Form
			browse: {
				state:'',
				munic:'',
				sort:'',
			},
			selects_options: {
				state:[],
				munic:[],
				sort: [
					{value:'PRICEREG_ASC', text:'Precio regular ascendente'}
					,{value:'PRICEREG_DESC', text:'Precio regular descendente'}
					,{value:'PRICEPRE_ASC', text:'Precio premium ascendente'}
					,{value:'PRICEPRE_DESC', text:'Precio premium descendente'}
				]
			},
			loading: false,
			error: '',

			//Table
			table_headers: [
				{
					text: 'Razón social',
					align: 'start',
					sortable: false,
					value: 'razonsocial',
				},
				{ text: 'RFC', value: 'rfc' },
				{ text: 'Permiso', value: 'numeropermiso' },
				{ text: 'Precio Gas. Regular', value: 'regular' },
				{ text: 'Precio Gas. Premium', value: 'premium' },
				{ text: 'Precio Dieasel', value: 'dieasel' },
				{ text: 'Estado', value: 'estado' },
				{ text: 'Municipio', value: 'municipio' },
			],
			data: [],

			//Map
			markerClusterer: null,
			map: null,

			//Footer
			icons: [
				'mdi-facebook',
				'mdi-twitter',
				'mdi-linkedin',
				'mdi-instagram'
			]
		}
	},
	methods: {
		/**
		 * Realiza peticiones a la API para obtener puntos.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @uses	this.loading
		 * @uses	this.data
		 * @uses	this.error
		 * @since	Versión 1.0, revisión 2.
		 */
		getData() {
			this.loading = true;
			let qry = (new URLSearchParams(this.browse)).toString();
			fetch(`/api/gasoline/map?${qry}`)
				.then((res)=>{
					if (res.ok==false) {
						throw res;
					}
					return res.json()
				})
				.then((res)=>{
					this.data = res.resources.points;
					this.error = '';
				})
				.catch((err)=>{
					console.error(err)
					this.error = 'Ocurrió un error al buscar los datos';
				})
				.finally(()=>{
					this.loading = false;
				})
			;
		},
		/**
		 * Limpia formulario, tabla y mapa.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @uses	this.browse
		 * @uses	this.data
		 * @since	Versión 1.0, revisión 2.
		 */
		clear() {
			for (let prop in this.browse) {
				this.browse[prop] = '';
			}

			this.data = [];
		},

		/**
		 * Carga libreria de GoogleMaps y guarda la referencia la mapa.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @uses	this.map
		 * @since	Versión 1.0, revisión 2.
		 */
		initMap() {
			// Create the script tag, set the appropriate attributes
			let script = document.createElement('script');
			script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAamVCoyQ4AuvBpxVRMs9P-HFkfPVQj0Kw&callback=initMap';
			script.defer = true;
			let vue = this;

			// Attach your callback function to the `window` object
			window.initMap = function() {
				vue.map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 19.4031469, lng: -99.2491128},
					zoom: 4
				});
			};

			// Append the 'script' element to 'head'
			document.head.appendChild(script);
		},

		/**
		 * Solicita los recursos iniciales para cargar la pagina.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @uses	this.selects_options.state
		 * @uses	this.error
		 * @uses	this.loading
		 * @since	Versión 1.0, revisión 2.
		 */
		getResources() {
			fetch('/api/gasoline/map/resources')
				.then((res)=>{
					if (res.ok==false) {
						throw res;
					}
					return res.json()
				})
				.then((res)=>{
					this.selects_options.state = res.resources.states;
				})
				.catch((err)=>{
					this.error = 'Ocurrió un error al cargar los datos';
					this.loading = true;
				})
			;
		},
		/**
		 * Solicita los recursos iniciales para cargar la pagina.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @uses	this.selects_options.munic
		 * @uses	this.browse.state
		 * @uses	this.loading
		 * @uses	this.error
		 * @since	Versión 1.0, revisión 2.
		 */
		getMunics() {
			fetch(`/api/munic/state/${this.browse.state}`)
				.then((res)=>{
					if (res.ok==false) {
						throw res;
					}
					return res.json()
				})
				.then((res)=>{
					this.selects_options.munic = res.resources.munics;
					this.loading = false;
				})
				.catch((err)=>{
					this.error = 'Ocurrió un error al cargar los datos';
				})
			;
		}
	},
	watch: {
		/**
		 * Actualización manual de pines en el mapa.
		 * @access	public
		 * @author	Jesús Alejandro Álvarez Fragoso <ende.so@protonmail.com>
		 * @param	array data: registros de la información a desplegar
		 * @uses	this.markerClusterer
		 * @uses	this.map
		 * @since	Versión 1.0, revisión 2.
		 */
		data(data) {
			if (this.markerClusterer !== null) {
				this.markerClusterer.clearMarkers();
			}

			if (this.map===null) {
				return;
			}

			let markers = data.map((item, i) => {
				return new google.maps.Marker({
					position: {
						lat: parseFloat(item.latitude),
						lng: parseFloat(item.longitude)
					},
					label: item.razonsocial,
				});
			});

			this.markerClusterer = new MarkerClusterer(this.map, markers, {
				imagePath:
				"https://unpkg.com/@googlemaps/markerclustererplus@1.0.3/images/m",
			});
		}
	},
	mounted() {
		this.getResources();
		this.initMap();
	}
});
