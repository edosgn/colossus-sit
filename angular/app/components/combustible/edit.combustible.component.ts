// Importar el núcleo de Angular
import {CombustibleService} from "../../services/combustible/combustible.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Combustible} from '../../model/combustible/combustible';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/combustible/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CombustibleService]
})
 
// combustible del componente donde irán los datos y funcionalidades
export class CombustibleEditComponent implements OnInit{ 
	public errorMessage;
	public combustible : Combustible;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _CombustibleService: CombustibleService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.combustible = new Combustible(null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._CombustibleService.showCombustible(token,this.id).subscribe(

						response => {
							this.combustible = response.data;
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
		this._CombustibleService.editCombustible(this.combustible,token).subscribe(
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





