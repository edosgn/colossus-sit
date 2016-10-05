// Importar el núcleo de Angular
import {CuentaService} from "../../services/cuenta/cuenta.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/cuenta/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CuentaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCuentaComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public cuentas;
	

	constructor(
		private _CuentaService: CuentaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		if(token) {
	     	console.log('logueado');
	     }else{
	     	this._router.navigate(["/login"]);
	     }

		this._CuentaService.getCuenta().subscribe(
				response => {
					this.cuentas = response.data;
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

	deleteCuenta(id:string){
		let token = this._loginService.getToken();
		this._CuentaService.deleteCuenta(token,id).subscribe(
				response => {
					    this.respuesta= response;
					    console.log(this.respuesta); 
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
