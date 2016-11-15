// Importar el núcleo de Angular
import {ServicioService} from "../../services/servicio/servicio.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Servicio} from '../../model/servicio/servicio';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/servicio/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ServicioService]
})
 
// Servicio del componente donde irán los datos y funcionalidades
export class NewServicioComponent {
	public servicio: Servicio;
	public errorMessage;
	public respuesta;

	constructor(
		private _ServicioService:ServicioService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.servicio = new Servicio(null, "", null);

	}

	onSubmit(){
		console.log(this.servicio);
		let token = this._loginService.getToken();

		this._ServicioService.register(this.servicio,token).subscribe(
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
