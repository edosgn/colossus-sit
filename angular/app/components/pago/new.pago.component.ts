// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {PagoService} from '../../services/pago/pago.service';
import {Pago} from '../../model/pago/Pago';
import {TramiteService} from '../../services/tramite/tramite.service';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/pago/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,PagoService,TramiteService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewPagoComponent {
	public pago: Pago;
	public errorMessage;
	public respuesta;
	public tramites;

	constructor(
		private _TramiteService:TramiteService,
		private _PagoService:PagoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		

		this.pago = new Pago(null,null,null, "", "");
		this._TramiteService.getTramite().subscribe(
				response => {
					this.tramites = response.data;
					console.log(this.tramites[0].nombre);
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

		this._PagoService.register(this.pago,token).subscribe(
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
