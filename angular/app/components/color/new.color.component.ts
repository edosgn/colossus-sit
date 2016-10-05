// Importar el núcleo de Angular
import {ColorService} from "../../services/color/color.service";
import {LoginService} from "../../services/login.service";
import {Color} from '../../model/color/color';
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/color/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ColorService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewColorComponent {
	public color: Color;
	public errorMessage;
	public respuesta;

	constructor(
		private _ColorService:ColorService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.color = new Color(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._ColorService.register(this.color,token).subscribe(
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
