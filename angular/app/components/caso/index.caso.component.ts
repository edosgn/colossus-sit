// Importar el núcleo de Angular
import {CasoService} from "../../services/caso/caso.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/caso/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CasoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCasoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public casos;
	

	constructor(
		private _CasoService: CasoService,
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

		this._CasoService.getCaso().subscribe(
				response => {
					this.casos = response.data;
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

	deleteCaso(id:string){
		let token = this._loginService.getToken();
		this._CasoService.deleteCaso(token,id).subscribe(
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
