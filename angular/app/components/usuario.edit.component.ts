// Importar el núcleo de Angular
import {LoginService} from "../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {UsuarioService} from '../services/usuario.service'; 
import {Usuario} from '../model/Usuario';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/usuario_edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,UsuarioService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class UsuarioEditComponent implements OnInit{ 
	public errorMessage;
	public usuario : Usuario;
	public id;
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
		private _UsuarioService: UsuarioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	

		
		this.usuario = new Usuario("", "", "", "", "","", "", "", "", "","");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._UsuarioService.showUsuario(token,this.id).subscribe(

						response => {
							this.usuario = response;
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
		console.log(token);

		this._UsuarioService.editUsuario(this.usuario,token).subscribe(
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





