// Importar el núcleo de Angular
import {LoginService} from "../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {UsuarioService} from '../services/usuario.service'; 
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/default.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,UsuarioService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class DefaulComponent implements OnInit{ 
	public errorMessage;
	public Usuarios;

	constructor(
		private _loginService: LoginService,
		private _UsuarioService: UsuarioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		this._UsuarioService.getUsuarios().subscribe(
				response => {
					this.Usuarios = response.usuarios;
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

	deleteUsuario(id:string){
		let token = this._loginService.getToken();
		console.log(token);

		this._UsuarioService.deleteUsuario(token,id).subscribe(
				response => {
					    let respuesta= response;
					    console.log(respuesta); 
					    this.ngOnInit();
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

}
