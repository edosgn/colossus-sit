// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {CiudadanoVehiculoService} from "../../services/CiudadanoVehiculo/CiudadanoVehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";

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
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public errorMessage;
	public token;
	public ciudadanos;
	public respuesta;

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _CiudadanoVehiculoService:CiudadanoVehiculoService,
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,"","","","");

		this._VehiculoService.getVehiculo().subscribe(
				response => {
					this.vehiculos = response.data;
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

	

	
 }
