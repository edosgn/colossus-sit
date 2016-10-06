// Importar el núcleo de Angular
import {CarroceriaService} from "../../services/carroceria/carroceria.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {ClaseService} from "../../services/clase/clase.service";
import {Carroceria} from '../../model/carroceria/carroceria';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/carroceria/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CarroceriaService,ClaseService]
})
 
// Carroceria del componente donde irán los datos y funcionalidades
export class CarroceriaEditComponent implements OnInit{ 
	public errorMessage;
	public carroceria : Carroceria;
	public id;
	public respuesta;
	public clases;

	constructor(
		private _ClaseService: ClaseService,
		private _loginService: LoginService,
		private _CarroceriaService: CarroceriaService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.carroceria = new Carroceria(null,null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._CarroceriaService.showCarroceria(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.carroceria = new Carroceria(data.id,data.clase.id,data.nombre,data.codigoMt);
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}

					);

			this._ClaseService.getClase().subscribe(
				response => {
					this.clases = response.data;
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
		this._CarroceriaService.editCarroceria(this.carroceria,token).subscribe(
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





