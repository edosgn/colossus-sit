// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Vehiculo} from "../../../model/vehiculo/vehiculo";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
import {CarroceriaService} from '../../../services/carroceria/carroceria.service';
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {VarianteService} from "../../../services/variante/variante.service";
import {CasoService} from "../../../services/caso/caso.service";

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteCambioCarroceria',
    templateUrl: 'app/view/tipoTramite/cambioCarroceria/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService,CarroceriaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteCambioCarroceriaComponent implements OnInit{ 
	
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public chasis;
	public tramiteEspecifico;
	public respuesta;
	public carroceriaSeleccionada = null;
	public carrocerias;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() tramiteGeneralId =22;
	@Input() vehiculo = null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newCarroceria':null,
		'oldCarroceria':null
	};
	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _VarianteService: VarianteService, 
		private _CarroceriaService: CarroceriaService,
		private _CasoService: CasoService, 
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){
		this.datos.oldCarroceria=this.vehiculo.carroceria.nombre;
		this.tramiteEspecifico = new TramiteEspecifico(null,32,this.tramiteGeneralId,null,null,null);
		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,32).subscribe(
				response => {
					this.casos = response.data;
					if(this.casos!=null) {
						this.tramiteEspecifico.casoId=this.casos[0].id;
					}

					

				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,32).subscribe(
				response => {
					this.variantes = response.data;
					if(this.variantes!=null) {
						this.tramiteEspecifico.varianteId=this.variantes[0].id;
					}
					
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);

		
    	this._CarroceriaService.getCarroceriasClase(this.vehiculo.clase.id,token).subscribe(
				response => {
					this.carrocerias = response.data;
					this.datos.newCarroceria=this.carrocerias[0].nombre;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
	}





	enviarTramite(){
		let token = this._loginService.getToken();
		this._TramiteEspecificoService.register2(this.tramiteEspecifico,token,this.datos).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					 this.tramiteCreado.emit(true);
				}

			error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});

		this.vehiculo2 = new Vehiculo(
			this.vehiculo.id,
			this.vehiculo.clase.id, 
			this.vehiculo.municipio.id, 
			this.vehiculo.linea.id,
			this.vehiculo.servicio.id,
			this.vehiculo.color.id,
			this.vehiculo.combustible.id,
			this.carroceriaSeleccionada.id,
			this.vehiculo.organismoTransito.id,
			this.vehiculo.placa,
			this.vehiculo.numeroFactura,
			this.vehiculo.fechaFactura,
			this.vehiculo.valor,
			this.vehiculo.numeroManifiesto,
			this.vehiculo.fechaManifiesto,
			this.vehiculo.cilindraje,
			this.vehiculo.modelo,
			this.vehiculo.motor,
			this.vehiculo.chasis,
			this.vehiculo.serie,
			this.vehiculo.vin,
			this.vehiculo.numeroPasajeros
		);

		this._VehiculoService.editVehiculo(this.vehiculo2,token).subscribe(
			response => {
				this.respuesta = response;
			error => {
					this.errorMessage = <any>error;
					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
		
	}

	onChangeCarroceria(event:any){
		for (var i = 0; i < this.carrocerias.length; ++i) {
			if(event == this.carrocerias[i].id) {
				this.carroceriaSeleccionada = this.carrocerias[i];
				this.datos.newCarroceria = this.carroceriaSeleccionada.nombre;
			}
		}
	}

	onChangeCaso(event:any){
		this.tramiteEspecifico.casoId=event;
		
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
	}
}