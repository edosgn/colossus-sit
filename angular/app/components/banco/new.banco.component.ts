// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {BancoService} from '../../services/banco/banco.service';
import {Banco} from '../../model/banco/Banco';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/banco/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,BancoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewBancoComponent {
	public banco: Banco;
	public errorMessage;
	public respuesta;

	constructor(
		private _BancoService:BancoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.banco = new Banco(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._BancoService.register(this.banco,token).subscribe(
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
