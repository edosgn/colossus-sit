// Importar el núcleo de Angular
import {ClaseService} from "../../services/clase/clase.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Clase} from '../../model/clase/clase';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/clase/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ClaseService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewClaseComponent {
	public clase: Clase;
	public errorMessage;
	public respuesta;

	constructor(
		private _ClaseService:ClaseService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.clase = new Clase(null, "", null);

	}

	onSubmit(){
		console.log(this.clase);
		let token = this._loginService.getToken();

		this._ClaseService.register(this.clase,token).subscribe(
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
