// Importar el núcleo de Angular
import {ModuloService} from "../../../services/modulo/modulo.service";
import {CiudadanoVehiculoService} from "../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {TramiteService} from "../../../services/tramite/tramite.service";
import {LoginService} from "../../../services/login.service";

import {NewTramiteTraspasoComponent} from "../../../components/tipoTramite/tramiteTraspaso/index.traspaso.component";
import {NewTramitePrendaComponent} from "../../../components/tipoTramite/tramitePrenda/index.prenda.component";
import {NewTramiteTrasladoCuentaComponent} from "../../../components/tipoTramite/tramiteTrasladoCuenta/index.TrasladoCuenta.component";
import {NewTramiteCambioServicioComponent} from "../../../components/tipoTramite/tramiteCambioServicio/index.cambioServicio.component";
import {NewTramiteRegrabarMotorComponent} from "../../../components/tipoTramite/tramiteRegrabarMotor/index.regrabarMotor.component";
import {NewTramiteCambioMotorComponent} from "../../../components/tipoTramite/tramiteCambioMotor/index.cambioMotor.component";
import {NewTramiteRegrabarChasisComponent} from "../../../components/tipoTramite/tramiteRegrabarChasis/index.regrabarChasis.component";
import {NewTramiteRegrabarSerieComponent} from "../../../components/tipoTramite/tramiteRegrabarSerie/index.regrabarSerie.component";
import {NewTramiteCambioColorComponent} from "../../../components/tipoTramite/tramiteCambioColor/index.cambioColor.component";
import {NewTramiteCambioCarroceriaComponent} from "../../../components/tipoTramite/tramiteCambioCarroceria/index.cambioCarroceria.component";
import {NewTramiteDuplicadoLicenciaComponent} from "../../../components/tipoTramite/tramiteDuplicadoLicencia/index.duplicadoLicencia.component";
import {NewTramiteDuplicadoPlacaComponent} from "../../../components/tipoTramite/tramiteDuplicadoPlaca/index.duplicadoPlaca.component";
import {NewTramiteCambioBlindajeComponent} from "../../../components/tipoTramite/tramiteCambioBlindaje/index.cambioBlindaje.component";
import {NewTramiteCambioCombustibleComponent} from "../../../components/tipoTramite/tramiteCambioCombustible/index.cambioCombustible.component";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Tramite} from '../../../model/tramite/Tramite';
import {Vehiculo} from '../../../model/vehiculo/Vehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tipoTramite/cuerpoTramite/index.component.html',

    directives: [
    ROUTER_DIRECTIVES,
    NewTramiteTraspasoComponent,
    NewTramiteCambioColorComponent,
    NewTramiteCambioServicioComponent,
    NewTramiteRegrabarMotorComponent,
    NewTramiteRegrabarChasisComponent,
    NewTramiteRegrabarSerieComponent,
    NewTramiteDuplicadoLicenciaComponent,
    NewTramiteCambioBlindajeComponent,
    NewTramiteCambioMotorComponent,
    NewTramiteDuplicadoPlacaComponent,
    NewTramiteCambioCarroceriaComponent,
    NewTramiteTrasladoCuentaComponent,
    NewTramiteCambioCombustibleComponent,
    NewTramitePrendaComponent
    ],

    providers: [LoginService,ModuloService,TramiteService,VehiculoService,CiudadanoVehiculoService]
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
	public vehiculo: Vehiculo;
	public validate; 
	public clase;
	public msg;
	public claseSpan;
	public ciudadanosVehiculo;
	public validateCiudadano;
	public idCiudadanoSeleccionado;
	public finalizar;
	public divTramite;
	public color;



	constructor(
		private _VehiculoService: VehiculoService,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _TramiteService: TramiteService,
		private _ModuloService: ModuloService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){
		this.color=false;
	}


	ngOnInit(){	
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);

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
	this.divTramite=true;
  }
 
 
}
