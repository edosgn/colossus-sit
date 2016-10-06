// Importar el núcleo de Angular
import {TramiteService} from "../../services/tramite/tramite.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tramite/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTramiteComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public tramites;
	

	constructor(
		private _TramiteService: TramiteService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._TramiteService.getTramite().subscribe(
				response => {
					this.tramites = response.data;
					console.log(this.tramites);
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

	deleteTramite(id:string){
		let token = this._loginService.getToken();
		this._TramiteService.deleteTramite(token,id).subscribe(
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
