// Importar el núcleo de Angular
import {BancoService} from "../../services/banco/banco.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/banco/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,BancoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexBancoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public bancos;
	

	constructor(
		private _BancoService: BancoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._BancoService.getBanco().subscribe(
				response => {
					this.bancos = response.data;
					console.log(this.bancos);
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

	deleteBanco(id:string){
		let token = this._loginService.getToken();
		this._BancoService.deleteBanco(token,id).subscribe(
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
