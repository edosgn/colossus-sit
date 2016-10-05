// Importar el núcleo de Angular
import {ModuloService} from "../../services/modulo/modulo.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/modulo/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModuloService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexModuloComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public modulos;
	

	constructor(
		private _ModuloService: ModuloService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ModuloService.getModulo().subscribe(
				response => {
					this.modulos = response.data;
					console.log(this.modulos);
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

	deleteModulo(id:string){
		let token = this._loginService.getToken();
		this._ModuloService.deleteModulo(token,id).subscribe(
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
