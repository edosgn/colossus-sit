// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ModuloService} from '../../services/modulo/modulo.service';
import {TramiteService} from '../../services/tramite/tramite.service';
import {Tramite} from '../../model/tramite/Tramite';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/tramite/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteService,ModuloService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteComponent {
	public tramite: Tramite;
	public errorMessage;
	public respuesta;
	public modulos;

	constructor(
		private _ModuloService:ModuloService,
		private _TramiteService:TramiteService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tramite = new Tramite(null, "",null,"","",true,null);
		this._ModuloService.getModulo().subscribe(
				response => {
					this.modulos = response.data;
					console.log(this.modulos);
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
		console.log(this.tramite);
		this._TramiteService.register(this.tramite,token).subscribe(
			response => {
				this.respuesta = response;
				console.log(this.respuesta);

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
