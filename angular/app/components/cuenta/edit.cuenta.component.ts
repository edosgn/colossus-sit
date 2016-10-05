// Importar el núcleo de Angular
import {CuentaService} from "../../services/cuenta/cuenta.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {BancoService} from '../../services/banco/banco.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Cuenta} from '../../model/cuenta/cuenta';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/cuenta/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CuentaService,BancoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class CuentaEditComponent implements OnInit{ 
	public errorMessage;
	public cuenta : Cuenta;
	public id;
	public respuesta;
	public bancos;

	constructor(
		private _BancoService: BancoService,
		private _loginService: LoginService,
		private _CuentaService: CuentaService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	

		this.cuenta = new Cuenta(null,null, "", null);
		let token = this._loginService.getToken();
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
		
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._CuentaService.showCuenta(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.cuenta = new Cuenta(data.id,data.banco.id, data.numero, data.observacion);
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
		this._CuentaService.editCuenta(this.cuenta,token).subscribe(
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





