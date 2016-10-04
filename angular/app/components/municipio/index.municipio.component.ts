// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {MunicipioService} from "../../services/municipio/municipio.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/municipio/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,MunicipioService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexMunicipioComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public municipios;
	

	constructor(
		private _MunicipioService: MunicipioService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._MunicipioService.getMunicipio().subscribe(
				response => {
					this.municipios = response.data;
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

	deleteMunicipio(id:string){
		let token = this._loginService.getToken();
		this._MunicipioService.deleteMunicipio(token,id).subscribe(
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
