// Importar el núcleo de Angular
import {ModuloService} from "../../../services/modulo/modulo.service";
import {CiudadanoVehiculoService} from "../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {TramiteService} from "../../../services/tramite/tramite.service";
import {LoginService} from "../../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Tramite} from '../../../model/tramite/Tramite';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tipoTramite/cuerpoTramite/index.component.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModuloService,TramiteService,VehiculoService,CiudadanoVehiculoService,]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTramiteCuerpoComponent implements OnInit{ 
	public errorMessage;
	public tramiteId;
	public respuesta;
	public modulos;
	public tramites;
	public activar;
	public tramite:Tramite;
	public vehiculo;
	public validate;
	public clase;
	public msg;
	public claseSpan;
	public ciudadanosVehiculo;
	public validateCiudadano;
	public idCiudadanoSeleccionado;
	public finalizar;



	constructor(
		private _VehiculoService: VehiculoService,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _TramiteService: TramiteService,
		private _ModuloService: ModuloService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	

		this._route.params.subscribe(params =>{
				this.tramiteId = +params["tramiteId"];
		});

		let token = this._loginService.getToken();
		this._TramiteService.showTramite(token,this.tramiteId).subscribe(

			response => {
				this.tramite=response.data;
		        console.log(this.tramite);
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

	onKey(event:any) {
 	let token = this._loginService.getToken();
 	let values = event.target.value;
 	let placa = {
 		'placa' : values,
 	};
 	this._VehiculoService.showVehiculoPlaca(token,placa).subscribe(
				response => {
					this.vehiculo = response.data;
					let status = response.status;
					if(status == 'error') {
						this.validate=false	;
						this.validateCiudadano=false;
						this.claseSpan ="glyphicon glyphicon-remove form-control-feedback";
						this.clase = "form-group has-error has-feedback";
					}else{
						    this.validate=true	;
							this.claseSpan ="glyphicon glyphicon-ok form-control-feedback";
							this.clase = "form-group has-success has-feedback";
				            this.msg = response.msj;

				       		this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token,this.vehiculo.id).subscribe(
								response => {
									this.ciudadanosVehiculo = response.data;
									this.respuesta = response;
									if(this.respuesta.status == 'error') {
										this.activar=true;
										this.validateCiudadano=false;
									}else{
									 this.activar=false;
									 this.validateCiudadano=true;
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
   

  }

  onChangeCiudadano(id) {
  	this.idCiudadanoSeleccionado = id;
  	console.log(this.idCiudadanoSeleccionado);
  }
 
 
}
