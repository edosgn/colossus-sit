// Importar el núcleo de Angular
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/vehiculo/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexVehiculoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public vehiculos;
	

	constructor(
		private _VehiculoService: VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._VehiculoService.getVehiculo().subscribe(
				response => {
					this.vehiculos = response.data;
					console.log(this.vehiculos);
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

	deleteVehiculo(id:string){
		let token = this._loginService.getToken();
		this._VehiculoService.deleteVehiculo(token,id).subscribe(
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
