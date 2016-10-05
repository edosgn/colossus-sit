// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ConsumibleService} from '../../services/consumible/consumible.service';
import {Consumible} from '../../model/consumible/Consumible';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/consumible/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ConsumibleService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewConsumibleComponent {
	public consumible: Consumible;
	public errorMessage;
	public respuesta;

	constructor(
		private _ConsumibleService:ConsumibleService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.consumible = new Consumible(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._ConsumibleService.register(this.consumible,token).subscribe(
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
