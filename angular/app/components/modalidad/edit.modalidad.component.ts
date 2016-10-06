// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {ModalidadService} from '../../services/modalidad/modalidad.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Modalidad} from '../../model/modalidad/modalidad';
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/modalidad/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModalidadService]
})
 
// combustible del componente donde irán los datos y funcionalidades
export class ModalidadEditComponent implements OnInit{ 
	public errorMessage;
	public modalidad : Modalidad;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ModalidadService:ModalidadService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.modalidad = new Modalidad(null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._ModalidadService.showModalidad(token,this.id).subscribe(

						response => {
							this.modalidad = response.data;
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
		this._ModalidadService.editModalidad(this.modalidad,token).subscribe(
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





