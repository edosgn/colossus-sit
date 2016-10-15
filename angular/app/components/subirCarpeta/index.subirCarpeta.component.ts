// Importar el núcleo de Angular
import {CiudadanoVehiculoService} from "../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Tramite} from '../../model/tramite/Tramite';
import {NewVehiculoComponent} from '../../components/vehiculo/new.vehiculo.component';
import {NewCiudadanoComponent} from '../../components/ciudadano/new.ciudadano.component';
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/subirCarpeta/index.component.html',
    directives: [ROUTER_DIRECTIVES, NewVehiculoComponent,NewCiudadanoComponent],
    providers: [LoginService,VehiculoService,CiudadanoVehiculoService,CiudadanoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexSubirCarpetaComponent implements OnInit{ 
	public errorMessage; 
	public tramiteId;
	public respuesta;
	public activar;
	public vehiculo;
	public validate;
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public clase;
	public msg;
	public claseSpan;
	public ciudadanosVehiculo;
	public validateCiudadano;
	public idCiudadanoSeleccionado;
	public colores;
	public colorNuevo;
	public finalizar;
	public crear;
	public placa;
	public resive;
	public identificacion;
	public ciudadano;
	public validateCedula;
	public msgCiudadano;
	public calseCedula;
	public claseSpanCedula;
	public existe;



	constructor(
		private _VehiculoService: VehiculoService,
		private _CiudadanoService: CiudadanoService,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,"","","","");}


	ngOnInit(){	
		this.placa = {
 		'placa' : this.placa,
 	};

		this._route.params.subscribe(params =>{
				this.tramiteId = +params["tramiteId"];
			});

		let token = this._loginService.getToken();
	  
	}

	onKey(event:any) {
 	let token = this._loginService.getToken();
 	console.log(this.placa);
 	
 	
 	this._VehiculoService.showVehiculoPlaca(token,this.placa).subscribe(
				response => {
					this.vehiculo = response.data;
					let status = response.status;
					if(status == 'error') {
						this.validate=false	;
						this.validateCiudadano=false;
						this.crear=true;
						this.claseSpan ="glyphicon glyphicon-remove form-control-feedback";
						this.clase = "form-group has-error has-feedback";
						this.activar =false;
					}else{
							this.claseSpan ="glyphicon glyphicon-ok form-control-feedback";
							this.clase = "form-group has-success has-feedback";
				            this.msg = response.msj;
				            this.crear=false;
				            this.validate=true;
				       		this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token,this.vehiculo.id).subscribe(
								response => {
									this.ciudadanosVehiculo = response.data;
									this.respuesta = response;
									if(this.respuesta.status == 'error') {
										this.activar=true;
										this.validateCiudadano=false;
									}else{
									 this.activar=true;
									 this.validate=true	;
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

  vheiculoCreado(event:any) {
  	this.placa.placa=event
    this.onKey("");
  }

  onKeyCiudadano(event:any){
  	let identificacion = {
 		'numeroIdentificacion' : event,
 	};
  	let token = this._loginService.getToken();
  	this._CiudadanoService.showCiudadanoCedula(token,identificacion).subscribe(
				response => {
					this.ciudadano = response.data;
					let status = response.status;

					if(this.ciudadanosVehiculo) {
						for (var i = this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
							if(this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
								let existe = true;
							}
						}
					}
					
					if(existe){
						alert ("existe una relacion con el ciudadano");
						
					}else{
							if(status == 'error') {
						this.validateCedula=false;
						this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
						this.calseCedula = "form-group has-error has-feedback";
						}else{
							this.validateCedula=true;
							this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
							this.calseCedula = "form-group has-success has-feedback";
				            this.msgCiudadano = response.msj;
						}
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

  VehiculoCiudadano(){

  	this.ciudadanoVehiculo.ciudadanoId=this.ciudadano.numeroIdentificacion;
  	this.ciudadanoVehiculo.vehiculoId=this.vehiculo.placa;

  	let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo,token).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=='success') {
					this.validateCedula=false;
					this.onKey("");

				}
				console.log(this.respuesta);
			error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
  }
 
}
