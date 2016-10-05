// Importar el núcleo de Angular
import {ClaseService} from "../../services/clase/clase.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Clase} from '../../model/clase/clase';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/clase/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ClaseService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class ClaseEditComponent implements OnInit{ 
	public errorMessage;
	public clase : Clase;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ClaseService: ClaseService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.clase = new Clase(null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._ClaseService.showClase(token,this.id).subscribe(

						response => {
							this.clase = response.data;
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
		this._ClaseService.editClase(this.clase,token).subscribe(
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





