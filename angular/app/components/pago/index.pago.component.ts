// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {PagoService} from "../../services/pago/pago.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/pago/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,PagoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexPagoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public pagos;
	

	constructor(
		private _PagoService: PagoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._PagoService.getPago().subscribe(
				response => {
					this.pagos = response.data;
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

	deletePago(id:string){
		let token = this._loginService.getToken();
		this._PagoService.deletePago(token,id).subscribe(
				response => {
					    this.respuesta= response;
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
