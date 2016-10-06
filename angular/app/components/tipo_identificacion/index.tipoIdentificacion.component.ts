// Importar el núcleo de Angular
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tipo_Identificacion/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTipoIdentificacionComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public tipoIdentificaciones;
	

	constructor(
		private _TipoIdentificacionService: TipoIdentificacionService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._TipoIdentificacionService.getTipoIdentificacion().subscribe(
				response => {
					this.tipoIdentificaciones = response.data;
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
		this._TipoIdentificacionService.deleteTipoIdentificacion(token,id).subscribe(
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
