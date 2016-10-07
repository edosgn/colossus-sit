// Importar el núcleo de Angular
import {OrganismoTransitoService} from "../../services/organismoTransito/organismoTransito.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/organismoTransito/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,OrganismoTransitoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexOrganismoTransitoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public organismoTransitos;
	

	constructor(
		private _OrganismoTransitoService: OrganismoTransitoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._OrganismoTransitoService.getOrganismoTransito().subscribe(
				response => {
					this.organismoTransitos = response.data;
					console.log(this.organismoTransitos);
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

	deleteOrganismoTransito(id:string){
		let token = this._loginService.getToken();
		this._OrganismoTransitoService.deleteOrganismoTransito(token,id).subscribe(
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
