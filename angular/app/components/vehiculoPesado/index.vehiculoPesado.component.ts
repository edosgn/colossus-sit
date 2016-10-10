// Importar el núcleo de Angular
import {VehiculoPesadoService} from "../../services/vehiculoPesado/vehiculoPesado.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/vehiculoPesado/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoPesadoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexVehiculoPesadoComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public vehiculosPesados;
	

	constructor(
		private _VehiculoPesadoService: VehiculoPesadoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._VehiculoPesadoService.getVehiculoPesado().subscribe(
				response => {
					this.vehiculosPesados = response.data;
					console.log(this.vehiculosPesados);
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

	deleteVehiculoPesado(id:string){
		let token = this._loginService.getToken();
		this._VehiculoPesadoService.deleteVehiculoPesado(token,id).subscribe(
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
