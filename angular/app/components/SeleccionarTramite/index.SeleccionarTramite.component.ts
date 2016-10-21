// Importar el núcleo de Angular
import {ModuloService} from "../../services/modulo/modulo.service";
import {TramiteService} from "../../services/tramite/tramite.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/SeleccionarTramite/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ModuloService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexSeleccionarTramiteComponent implements OnInit{ 
	public errorMessage;
	public id;
	public respuesta;
	public modulos;
	public tramites;
	public activar;
	

	constructor(
		private _TramiteService: TramiteService,
		private _ModuloService: ModuloService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}


	ngOnInit(){	
		let token = this._loginService.getToken();
		
		this._ModuloService.getModulo().subscribe(
				response => {
					this.modulos = response.data;
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

	onChangeModulo(moduloId){
		let token = this._loginService.getToken();
		
		this._TramiteService.TramitesModulo(moduloId,token).subscribe(
				response => {
					this.tramites = response.data;
					this.respuesta = response;
					if(this.respuesta.status=='success') {
						this.activar=false;
					}else{
						this.activar=true;
					}
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

	onChangeTramite(tramiteId){
	this._router.navigate(['/tramiteCuerpo',tramiteId]);
	}
}
