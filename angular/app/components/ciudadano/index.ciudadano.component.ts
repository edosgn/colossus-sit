// Importar el núcleo de Angular
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/ciudadano/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CiudadanoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCiudadanoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public ciudadanos;
	

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
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

	deleteCiudadano(id:string){
		let token = this._loginService.getToken();
		this._CiudadanoService.deleteCiudadano(token,id).subscribe(
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
