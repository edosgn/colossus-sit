// Importar el núcleo de Angular
import {CarroceriaService} from "../../services/carroceria/carroceria.service";
import {ClaseService} from "../../services/clase/clase.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Carroceria} from '../../model/carroceria/carroceria';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/carroceria/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CarroceriaService,ClaseService]
})
 
// Carroceria del componente donde irán los datos y funcionalidades
export class NewCarroceriaComponent {
	public carroceria: Carroceria;
	public errorMessage;
	public respuesta;
	public clases;

	constructor(
		private _ClaseService:ClaseService,
		private _CarroceriaService:CarroceriaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.carroceria = new Carroceria(null,null, "", null);
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
		console.log(this.carroceria);
		let token = this._loginService.getToken();

		this._CarroceriaService.register(this.carroceria,token).subscribe(
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
