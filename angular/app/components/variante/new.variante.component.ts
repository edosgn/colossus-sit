// Importar el núcleo de Angular
import {VarianteService} from "../../services/variante/variante.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {TramiteService} from '../../services/tramite/tramite.service';
import {Variante} from '../../model/variante/variante';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/variante/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VarianteService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewVarianteComponent {
	public variante: Variante;
	public errorMessage;
	public respuesta;
	public tramites;

	constructor(
		private _TramiteService:TramiteService,
		private _VarianteService:VarianteService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.variante = new Variante(null,null,"");

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
		console.log(this.variante);
		let token = this._loginService.getToken();
		this._VarianteService.register(this.variante,token).subscribe(
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
