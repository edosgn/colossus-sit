// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {TramiteEspecificoService} from "../../services/tramiteEspecifico/tramiteEspecifico.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tramiteEspecifico/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTramiteEspecificoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public tramiteEspecificos;
	public datos;
	public var;
	

	constructor(
		private _TramiteEspecificoService: TramiteEspecificoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._TramiteEspecificoService.getTramiteEspecifico().subscribe(
				response => {
					this.tramiteEspecificos = response.data;
					this.var = response.data;
					console.log(this.var);
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

	deleteTramiteEspecifico(id:string){
		let token = this._loginService.getToken();
		this._TramiteEspecificoService.deleteTramiteEspecifico(token,id).subscribe(
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
