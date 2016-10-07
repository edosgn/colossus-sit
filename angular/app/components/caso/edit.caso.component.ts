// Importar el núcleo de Angular
import {CasoService} from "../../services/caso/caso.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {TramiteService} from '../../services/tramite/tramite.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Caso} from '../../model/caso/caso';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/caso/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CasoService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class CasoEditComponent implements OnInit{ 
	public errorMessage;
	public caso : Caso;
	public id;
	public respuesta;
	public tramites;

	constructor(
		private _TramiteService: TramiteService,
		private _loginService: LoginService,
		private _CasoService: CasoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){} 

	ngOnInit(){	

		this.caso = new Caso(null,null,""); 
		let token = this._loginService.getToken();
		this._TramiteService.getTramite().subscribe(
				response => {
					this.tramites = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._CasoService.showCaso(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.caso = new Caso(data.id,data.tramite.id, data.nombre);
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
		this._CasoService.editCaso(this.caso,token).subscribe(
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





