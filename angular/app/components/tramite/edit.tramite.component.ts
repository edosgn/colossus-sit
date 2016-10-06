// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteService} from '../../services/tramite/tramite.service';
import {Tramite} from '../../model/tramite/Tramite';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tramite/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class TramiteEditComponent implements OnInit{ 
	public errorMessage;
	public tramite : Tramite;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _TramiteService: TramiteService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.tramite = new Tramite(null,"",null,"","",null,null);


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._TramiteService.showTramite(token,this.id).subscribe(

						response => {
							this.tramite = response.data;
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
		this._TramiteService.editTramite(this.tramite,token).subscribe(
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





