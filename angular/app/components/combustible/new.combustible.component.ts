// Importar el núcleo de Angular
import {CombustibleService} from "../../services/combustible/combustible.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Combustible} from '../../model/combustible/combustible';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/combustible/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CombustibleService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewCombustibleComponent {
	public combustible: Combustible;
	public errorMessage;
	public respuesta;

	constructor(
		private _CombustibleService:CombustibleService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.combustible = new Combustible(null, "", null);

	}

	onSubmit(){
		console.log(this.combustible);
		let token = this._loginService.getToken();

		this._CombustibleService.register(this.combustible,token).subscribe(
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
