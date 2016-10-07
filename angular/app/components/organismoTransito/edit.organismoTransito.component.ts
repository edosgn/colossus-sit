// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {OrganismoTransitoService} from '../../services/organismoTransito/organismoTransito.service';
import {OrganismoTransito} from '../../model/organismoTransito/OrganismoTransito';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/organismoTransito/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,OrganismoTransitoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class OrganismoTransitoEditComponent implements OnInit{ 
	public errorMessage;
	public organismoTransito : OrganismoTransito;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _OrganismoTransitoService: OrganismoTransitoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.organismoTransito = new OrganismoTransito(null,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._OrganismoTransitoService.showOrganismoTransito(token,this.id).subscribe(

						response => {
							this.organismoTransito = response.data;
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


	onSubmit(){
		let token = this._loginService.getToken();
		this._OrganismoTransitoService.editOrganismoTransito(this.organismoTransito,token).subscribe(
			response => {
				this.respuesta = response;
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





