// Importar el núcleo de Angular
import {ConsumibleService} from "../../services/consumible/consumible.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/consumible/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ConsumibleService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexConsumibleComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public consumibles;
	

	constructor(
		private _ConsumibleService: ConsumibleService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ConsumibleService.getConsumible().subscribe(
				response => {
					this.consumibles = response.data;
					console.log(this.consumibles);
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

	deleteConsumible(id:string){
		let token = this._loginService.getToken();
		this._ConsumibleService.deleteConsumible(token,id).subscribe(
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
