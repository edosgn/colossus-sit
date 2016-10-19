// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {CiudadanoVehiculoService} from "../../services/CiudadanoVehiculo/CiudadanoVehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {Vehiculo} from '../../model/vehiculo/Vehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/ciudadanoVehiculo/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,CiudadanoVehiculoService,CiudadanoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class CiudadanoVehiculoEditComponent implements OnInit{ 
	public vehiculos;
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public errorMessage;
	public token;
	public ciudadanos;
	public respuesta;
	public id;
	public validate;
	public data;
	public calse;
	public msg;
	public claseSpan;
	public vehiculo: Vehiculo;

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
		this.msg = "vechiculo";
		this.claseSpan ="";
		this.validate=false;
		this.ciudadanoVehiculo = new CiudadanoVehiculo(null,null, null,null,"","","","");
        let token = this._loginService.getToken();
        this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
		this._CiudadanoVehiculoService.showCiudadanoVehiculo(token,this.id).subscribe(
				response => {
					this.data = response.data;
					this.vehiculo = response.data.vehiculo;
					this.ciudadanoVehiculo = new CiudadanoVehiculo(this.data.id, this.data.ciudadano.id,this.data.vehiculo.placa,null,this.data.licenciaTransito,this.data.fechaPropiedadInicial,this.data.fechaPropiedadFinal,this.data.estadoPropiedad);
					this.validate = true;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		
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
		this._CiudadanoVehiculoService.editCiudadanoVehiculo(this.ciudadanoVehiculo,token).subscribe(
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


}





