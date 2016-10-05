// Importar el núcleo de Angular
import {ColorService} from "../../services/color/color.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/color/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ColorService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexColorComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public colores;
	

	constructor(
		private _ColorService: ColorService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ColorService.getColor().subscribe(
				response => {
					this.colores = response.data;
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

	deleteColor(id:string){
		let token = this._loginService.getToken();
		this._ColorService.deleteColor(token,id).subscribe(
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
