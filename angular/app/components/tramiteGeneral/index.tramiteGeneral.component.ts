// Importar el núcleo de Angular
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service';
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tramiteGeneral/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteGeneralService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexTramiteGeneralComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public tramitesGeneral;
	

	constructor(
		private _TramiteGeneral: TramiteGeneralService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._TramiteGeneral.getTramiteGeneral().subscribe(
				response => {
					this.tramitesGeneral = response.data;
					console.log(this.tramitesGeneral);
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

	deleteTramiteGeneral(id:string){
		let token = this._loginService.getToken();
		this._TramiteGeneral.deleteTramiteGeneral(token,id).subscribe(
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
