// Importar el núcleo de Angular
import {CiudadanoVehiculoService} from "../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/ciudadanoVehiculo/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CiudadanoVehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCiudadanoVehiculoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public ciudadanoVehiculos;
	

	constructor(
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._CiudadanoVehiculoService.getCiudadanoVehiculo().subscribe(
				response => {
					this.ciudadanoVehiculos = response.data;
					console.log(this.ciudadanoVehiculos);
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

	deleteCiudadanoVehiculo(id:string){
		let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.deleteCiudadanoVehiculo(token,id).subscribe(
				response => {
					    this.respuesta= response;
					    console.log(this.respuesta); 
					    this.ngOnInit();
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
