// Importar el núcleo de Angular
import {ConceptoService} from "../../services/concepto/concepto.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/concepto/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ConceptoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexConceptoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public conceptos;
	

	constructor(
		private _ConceptoService: ConceptoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ConceptoService.getConcepto().subscribe(
				response => {
					this.conceptos = response.data;
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

	deleteConcepto(id:string){
		let token = this._loginService.getToken();
		this._ConceptoService.deleteConcepto(token,id).subscribe(
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
