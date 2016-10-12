// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {CiudadanoVehiculoService} from "../../services/CiudadanoVehiculo/CiudadanoVehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {Vehiculo} from '../../model/vehiculo/Vehiculo';
import {Ciudadano} from '../../model/ciudadano/Ciudadano';

// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/ciudadanoVehiculo/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,CiudadanoVehiculoService,CiudadanoService]
})

 
// Clase del componente donde irán los datos y funcionalidades
export class NewCiudadanoVehiculoComponent {
	public vehiculos;
	public vehiculo: Vehiculo;
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public errorMessage;
	public token;
	public ciudadanos;
	public respuesta;
	public values;
	public calse;
	public calseCedula;
	public msg;
	public msgCiudadano;
	public claseSpan;
	public claseSpanCedula;
	public validate;
	public ciudadano: Ciudadano;
	public validateCedula;

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _CiudadanoVehiculoService:CiudadanoVehiculoService,
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}


	ngOnInit(){
		this.calse = "form-group has-feedback";
		this.msg = "ingrese la placa";
		this.claseSpan ="";
		this.validate=false;
     	this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);
		this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,"","","","");
		this.ciudadano = new Ciudadano(null,"",null, "","","","","");

		this._CiudadanoService.getCiudadano().subscribe(
				response => {
					this.ciudadanos = response.data;
					console.log(this.ciudadanos);
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


	onSubmit(){
		let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo,token).subscribe(
			response => {
				this.respuesta = response;
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
						this.claseSpan ="glyphicon glyphicon-remove form-control-feedback";
						this.calse = "form-group has-error has-feedback";
					}else{
						this.validate=true;
						this.claseSpan ="glyphicon glyphicon-ok form-control-feedback";
						this.calse = "form-group has-success has-feedback";
			            this.msg = response.msj;
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


  onKeyCiudadano(event:any) {
 	let token = this._loginService.getToken();
 	let values = event.target.value;
 	let ciudadano = {
 		'numeroIdentificacion' : values,
 	};
 	this._CiudadanoService.showCiudadanoCedula(token,ciudadano).subscribe(
				response => {
					this.ciudadano = response.data;
					let status = response.status;
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

	

	
 }
