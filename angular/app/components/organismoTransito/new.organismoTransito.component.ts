// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {OrganismoTransitoService} from '../../services/organismoTransito/organismoTransito.service';
import {OrganismoTransito} from '../../model/organismoTransito/OrganismoTransito';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/organismoTransito/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,OrganismoTransitoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewOrganismoTransitoComponent {
	public organismoTransito: OrganismoTransito;
	public errorMessage;
	public respuesta;

	constructor(
		private _OrganismoTransitoService:OrganismoTransitoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.organismoTransito = new OrganismoTransito(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._OrganismoTransitoService.register(this.organismoTransito,token).subscribe(
			response => {
				this.respuesta = response;
				console.log(this.respuesta);

			error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
	}

	
 }
