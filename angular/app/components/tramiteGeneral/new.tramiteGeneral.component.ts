// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service';
import {VehiculoService} from '../../services/vehiculo/vehiculo.service';
import {TramiteGeneral} from '../../model/tramiteGeneral/TramiteGeneral';
 
// Decorador component, indicamos en que etiqueta se va a cargar la  

@Component({
    selector: 'registerTramiteGeneral',
    templateUrl: 'app/view/tramiteGeneral/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteGeneralService,VehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteGeneralComponent {
	public tramiteGeneral: TramiteGeneral;
	public errorMessage;
	public respuesta;
	public vehiculos;

	constructor(

		private _TramiteGeneralService:TramiteGeneralService,
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tramiteGeneral = new TramiteGeneral(null, null, null, "", "", null, null, null ,"");

		let token = this._loginService.getToken();
		
		this._VehiculoService.getVehiculo().subscribe(
				response => {
					this.vehiculos = response.data;
					console.log(this.vehiculos);
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
		this._TramiteGeneralService.register(this.tramiteGeneral,token).subscribe(
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
