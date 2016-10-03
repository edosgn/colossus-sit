// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../services/login.service';
import {Usuario} from '../model/Usuario';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/usuario_new.html'
})
 
// Clase del componente donde irán los datos y funcionalidades
export class RegisterComponent {
	public usuario: Usuario;
	public errorMessage;
	public respuesta;
	public roles = [
		    { value: 'ROLE_ADMIN', display: 'Administrator' },
		    { value: 'ROLE_USER', display: 'Usuario' },
		];

	public estados = [
		    { value: 'Activo', display: 'Activo' },
		    { value: 'Inactivo', display: 'Inactivo' },
		];	

	constructor(
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.usuario = new Usuario("", "", "", "", "","", "", "activo", "", "","");

	}

	onSubmit(){
		console.log(this.usuario);

		this._loginService.register(this.usuario).subscribe(
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

	callUsuarioEstado(value){
		console.log(value);
		this.usuario.estado = value;
	}
 }
