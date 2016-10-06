// Importar el núcleo de Angular
import {EmpresaService} from "../../services/empresa/empresa.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/empresa/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,EmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexEmpresaComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public empresas;
	

	constructor(
		private _EmpresaService: EmpresaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._EmpresaService.getEmpresa().subscribe(
				response => {
					this.empresas = response.data;
					console.log(this.empresas);
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

	deleteEmpresa(id:string){
		let token = this._loginService.getToken();
		this._EmpresaService.deleteEmpresa(token,id).subscribe(
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
