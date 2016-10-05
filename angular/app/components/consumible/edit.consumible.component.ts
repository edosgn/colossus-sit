// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ConsumibleService} from '../../services/consumible/consumible.service';
import {Consumible} from '../../model/consumible/Consumible';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/consumible/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ConsumibleService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class ConsumibleEditComponent implements OnInit{ 
	public errorMessage;
	public consumible : Consumible;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ConsumibleService: ConsumibleService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.consumible = new Consumible(null,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._ConsumibleService.showConsumible(token,this.id).subscribe(

						response => {
							this.consumible = response.data;
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
		this._ConsumibleService.editConsumible(this.consumible,token).subscribe(
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





