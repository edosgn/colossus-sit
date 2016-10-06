// Importar el núcleo de Angular
import {ServicioService} from "../../services/servicio/servicio.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Servicio} from '../../model/servicio/servicio';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/servicio/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ServicioService]
})
 
// Servicio del componente donde irán los datos y funcionalidades
export class ServicioEditComponent implements OnInit{ 
	public errorMessage;
	public servicio : Servicio;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ServicioService: ServicioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.servicio = new Servicio(null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._ServicioService.showServicio(token,this.id).subscribe(

						response => {
							this.servicio = response.data;
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
		this._ServicioService.editServicio(this.servicio,token).subscribe(
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





