// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service';
import {TramiteGeneral} from '../../model/tramiteGeneral/TramiteGeneral';
import {VehiculoService} from '../../services/vehiculo/vehiculo.service';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/tramiteGeneral/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,TramiteGeneralService,VehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class TramiteGeneralEditComponent implements OnInit{ 
	public errorMessage;
	public tramiteGeneral : TramiteGeneral;
	public id;
	public respuesta;
	public vehiculos;

	constructor(
		private _loginService: LoginService,
		private _TramiteGeneralService: TramiteGeneralService,
		private _VehiculoService: VehiculoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.tramiteGeneral = new TramiteGeneral(null, null, null, "", "", null, null, null ,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._TramiteGeneralService.showTramiteGeneral(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.tramiteGeneral = new TramiteGeneral(
								data.id,
								data.vehiculo.id, 
								data.numeroQpl,
								data.fechaInicial,
							    data.fechaFinal,
							    data.valor,
							    data.numeroLicencia, 
							    data.numeroSustrato,
							    data.nombre);
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}
			);
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
		this._TramiteGeneralService.editTramiteGeneral(this.tramiteGeneral,token).subscribe(
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





