// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {MarcaService} from '../../services/marca/marca.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/marca/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,MarcaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexMarcaComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public marcas;
	

	constructor(
		private _MarcaService:MarcaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._MarcaService.getMarca().subscribe(
					response => {
						this.marcas = response.data;
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

	deleteMarca(id:string){
		let token = this._loginService.getToken();
		this._MarcaService.deleteMarca(token,id).subscribe(
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
