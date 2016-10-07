// Importar el núcleo de Angular
import {CasoService} from "../../services/caso/caso.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {TramiteService} from '../../services/tramite/tramite.service';
import {Caso} from '../../model/caso/caso';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/caso/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CasoService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewCasoComponent {
	public caso: Caso;
	public errorMessage;
	public respuesta;
	public tramites;

	constructor(
		private _TramiteService:TramiteService,
		private _CasoService:CasoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.caso = new Caso(null,null,"");

			this._TramiteService.getTramite().subscribe(
					response => {
						this.tramites = response.data;
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
		console.log(this.caso);
		let token = this._loginService.getToken();
		this._CasoService.register(this.caso,token).subscribe(
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
