// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {ServicioService} from "../../../services/servicio/servicio.service";
import {Servicio} from "../../../model/servicio/servicio";
import {Vehiculo} from "../../../model/vehiculo/vehiculo";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {VarianteService} from "../../../services/variante/variante.service";
import {CasoService} from "../../../services/caso/caso.service";

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteCambioServicio',
    templateUrl: 'app/view/tipoTramite/cambioServicio/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ServicioService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteCambioServicioComponent implements OnInit{ 
	
	public servicios;
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public tramiteEspecifico;
	public respuesta;
	public servicioSeleccionado = null;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() tramiteGeneralId ;
	@Input() vehiculo = null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newServicio':null,
		'oldServicio':null
	};
	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _VarianteService: VarianteService, 
		private _CasoService: CasoService, 
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _ServicioService: ServicioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){
		this.tramiteEspecifico = new TramiteEspecifico(null,6,this.tramiteGeneralId,null,null,null);
		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,6).subscribe(
				response => {
					this.casos = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,6).subscribe(
				response => {
					this.variantes = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);

		this._ServicioService.getServicio().subscribe(
				response => {
					this.servicios = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);


		this.datos.oldServicio = this.vehiculo.servicio.nombre;
		}



	onChangeServicio(event:any){

		for (var i = 0; i < this.servicios.length; ++i) {
			if(event == this.servicios[i].id) {
				this.servicioSeleccionado = this.servicios[i];
				this.datos.newServicio = this.servicioSeleccionado.nombre;
			}
			
		}
		
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
			this.servicioSeleccionado.id,
			this.vehiculo.color.id,
			this.vehiculo.combustible.id,
			this.vehiculo.carroceria.id,
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
			this.vehiculo.numeroPasajeros,
			this.vehiculo.pignorado,
			this.vehiculo.cancelado
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

	onChangeCaso(event:any){
		this.tramiteEspecifico.casoId=event;
		
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
	}
}
