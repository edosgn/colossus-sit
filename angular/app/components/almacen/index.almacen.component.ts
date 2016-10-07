// Importar el núcleo de Angular
import {AlmacenService} from "../../services/almacen/almacen.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/almacen/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,AlmacenService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexAlmacenComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public almacenes;
	

	constructor(
		private _AlmacenService: AlmacenService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._AlmacenService.getAlmacen().subscribe(
				response => {
					this.almacenes = response.data;
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

	deleteAlmacen(id:string){
		let token = this._loginService.getToken();
		this._AlmacenService.deleteAlmacen(token,id).subscribe(
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
