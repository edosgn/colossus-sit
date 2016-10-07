// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteService} from '../../services/tramite/tramite.service';
import {PagoService} from "../../services/pago/pago.service";
import {Pago} from '../../model/pago/Pago';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/pago/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,TramiteService,PagoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class PagoEditComponent implements OnInit{ 
	public errorMessage;
	public pago : Pago;
	public id;
	public respuesta;
	public tramites;

	constructor(
		private _loginService: LoginService,
		private _TramiteService: TramiteService,
		private _PagoService: PagoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.pago = new Pago(null,null,null, "", "");
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

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._PagoService.showPago(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.pago = new Pago(data.id,data.tramite.id, data.valor, data.fechaPago,data.horaPagoHM);
							console.log(this.pago);
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
		this._PagoService.editPago(this.pago,token).subscribe(
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





