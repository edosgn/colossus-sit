// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {CuentaService} from "../../services/cuenta/cuenta.service";
import {TramiteService} from '../../services/tramite/tramite.service';
import {ConceptoService} from "../../services/concepto/concepto.service";
import {Concepto} from '../../model/concepto/Concepto';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/concepto/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ConceptoService,TramiteService,CuentaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewConceptoComponent {
	public concepto: Concepto;
	public errorMessage;
	public respuesta;
	public tramites;
	public cuentas;
	public ciudadanos;

	constructor(
		private _CuentaService: CuentaService,
		private _TramiteService: TramiteService,	
		private _ConceptoService:ConceptoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.concepto = new Concepto(null,null,null,"",null);
		let token = this._loginService.getToken();
		
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
		this._CuentaService.getCuenta().subscribe(
				response => {
					this.cuentas = response.data;
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
		this._ConceptoService.register(this.concepto,token).subscribe(
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
