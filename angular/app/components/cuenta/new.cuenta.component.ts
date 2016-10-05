// Importar el núcleo de Angular
import {CuentaService} from "../../services/cuenta/cuenta.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {BancoService} from '../../services/banco/banco.service';
import {Cuenta} from '../../model/cuenta/cuenta';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/cuenta/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CuentaService,BancoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewCuentaComponent {
	public cuenta: Cuenta;
	public errorMessage;
	public respuesta;
	public bancos;

	constructor(
		private _BancoService:BancoService,
		private _CuentaService:CuentaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.cuenta = new Cuenta(null,null,null,"");

			this._BancoService.getBanco().subscribe(
					response => {
						this.bancos = response.data;
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
		console.log(this.cuenta);
		let token = this._loginService.getToken();
		this._CuentaService.register(this.cuenta,token).subscribe(
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
