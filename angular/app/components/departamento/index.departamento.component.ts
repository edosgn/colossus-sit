// Importar el núcleo de Angular
import {DepartamentoService} from "../../services/departamento/departamento.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/departamento/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,DepartamentoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexDepartamentoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public departamentos;
	

	constructor(
		private _DepartamentoService: DepartamentoService,
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

		this._DepartamentoService.getDepartamento().subscribe(
				response => {
					this.departamentos = response.data;
					console.log(this.departamentos[0].nombre);
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

	deleteDepartamento(id:string){
		let token = this._loginService.getToken();
		this._DepartamentoService.deleteDepartamento(token,id).subscribe(
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
