// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {ModalidadService} from '../../services/modalidad/modalidad.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Modalidad} from '../../model/modalidad/modalidad';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/modalidad/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModalidadService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewModalidadComponent {
	public modalidad: Modalidad;
	public errorMessage;
	public respuesta;

	constructor(
		private _ModalidadService:ModalidadService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.modalidad = new Modalidad(null, "", null);

	}

	onSubmit(){
		console.log(this.modalidad);
		let token = this._loginService.getToken();

		this._ModalidadService.register(this.modalidad,token).subscribe(
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
