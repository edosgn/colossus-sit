// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {CiudadanoVehiculoService} from "../../services/CiudadanoVehiculo/CiudadanoVehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/ciudadanoVehiculo/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,CiudadanoVehiculoService,CiudadanoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class CiudadanoVehiculoEditComponent implements OnInit{ 
	public vehiculos;
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public errorMessage;
	public token;
	public ciudadanos;
	public respuesta;
	public id;

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _CiudadanoVehiculoService:CiudadanoVehiculoService,
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,"","","","");
        let token = this._loginService.getToken();
        this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
		this._CiudadanoVehiculoService.showCiudadanoVehiculo(token,this.id).subscribe(
				response => {
					let data = response.data;
					this.ciudadanoVehiculo = new CiudadanoVehiculo(data.id, data.ciudadano.id,data.vehiculo.id,data.licenciaTransito,data.fechaPropiedadInicial,data.fechaPropiedadFinal,data.estadoPropiedad);
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
						}, 
						error => {
							this.errorMessage = <any>error;

							if(this.errorMessage != null){
								console.log(this.errorMessage);
								alert("Error en la petición");
							}
						}
					);
				this._CiudadanoService.getCiudadano().subscribe(
						response => {
							this.ciudadanos = response.data;
							console.log(this.ciudadanos);
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
		this._CiudadanoVehiculoService.editCiudadanoVehiculo(this.ciudadanoVehiculo,token).subscribe(
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





