// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteEspecificoService} from '../../services/tramiteEspecifico/tramiteEspecifico.service';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service';
import {TramiteEspecifico} from '../../model/tramiteEspecifico/TramiteEspecifico';
import {TramiteService} from '../../services/tramite/tramite.service';
import {VarianteService} from '../../services/variante/variante.service';
import {CasoService} from '../../services/caso/caso.service';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/tramiteEspecifico/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService,TramiteService,TramiteGeneralService,VarianteService,CasoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteEspecificoComponent {
	public tramiteEspecifico: TramiteEspecifico;
	public errorMessage;
	public respuesta;
	public tramites;
	public tramitesGeneral;
	public variantes;
	public casos;

	constructor(
		private _TramiteService:TramiteService,
		private _TramiteEspecificoService:TramiteEspecificoService,
		private _VarianteService:VarianteService,
		private _CasoService:CasoService,
		private _TramiteGeneralService:TramiteGeneralService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tramiteEspecifico = new TramiteEspecifico(null,null,null,null,null,null);
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
		this._TramiteGeneralService.getTramiteGeneral().subscribe(
				response => {
					this.tramitesGeneral = response.data;
					
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.getVariante().subscribe(
				response => {
					this.variantes = response.data;
					
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._CasoService.getCaso().subscribe(
				response => {
					this.casos = response.data;
					
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

		this._TramiteEspecificoService.register(this.tramiteEspecifico,token).subscribe(
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
