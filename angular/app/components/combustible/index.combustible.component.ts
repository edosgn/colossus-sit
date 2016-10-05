// Importar el núcleo de Angular
import {CombustibleService} from "../../services/combustible/combustible.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/combustible/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CombustibleService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCombustibleComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public combustibles;
	

	constructor(
		private _CombustibleService: CombustibleService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		if(token) {
	     	console.log('logueado');
	     }else{
	     	this._router.navigate(["/login"]);
	     }

		this._CombustibleService.getCombustible().subscribe(
				response => {
					this.combustibles = response.data;
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

	deleteCombustible(id:string){
		let token = this._loginService.getToken();
		this._CombustibleService.deleteCombustible(token,id).subscribe(
				response => {
					    this.respuesta= response;
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
