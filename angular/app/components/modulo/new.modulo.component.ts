// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ModuloService} from '../../services/modulo/modulo.service';
import {Modulo} from '../../model/modulo/modulo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/modulo/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModuloService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewModuloComponent {
	public modulo: Modulo;
	public errorMessage;
	public respuesta;

	constructor(
		private _ModuloService:ModuloService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.modulo = new Modulo(null, "","");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._ModuloService.register(this.modulo,token).subscribe(
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
