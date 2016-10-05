// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {ModalidadService} from '../../services/modalidad/modalidad.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/modalidad/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModalidadService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexModalidadComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public modalidades;
	

	constructor(
		private _ModalidadService:ModalidadService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ModalidadService.getModalidad().subscribe(
					response => {
						this.modalidades = response.data;
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

	deleteModalidad(id:string){
		let token = this._loginService.getToken();
		this._ModalidadService.deleteModalidad(token,id).subscribe(
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
