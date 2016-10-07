// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {Vehiculo} from '../../model/vehiculo/Vehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/vehiculo/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,VehiculoService,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class VehiculoEditComponent implements OnInit{ 
	public errorMessage;
	public vehiculo : Vehiculo;
	public id;
	public respuesta;
	public tiposIdentificacion;

	constructor(
		private _TipoIdentificacionService:TipoIdentificacionService,
		private _loginService: LoginService,
		private _VehiculoService: VehiculoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);

		let token = this._loginService.getToken();
		this._TipoIdentificacionService.getTipoIdentificacion().subscribe(
				response => {
					this.tiposIdentificacion = response.data;
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

			this._VehiculoService.showVehiculo(token,this.id).subscribe(

						response => {
							let data = response.data;
							console.log(data);
							this.vehiculo = new Vehiculo(
								data.id,
								data.clase.id, 
								data.municipio.id, 
								data.linea.id,
								data.servicio.id,
								data.color.id,
								data.combustible.id,
								data.carroceria.id,
								data.organismoTransito.id,
								data.placa,
								data.numeroFactura,
								data.fechaFactura,
								data.valor,
								data.numeroManifiesto,
								data.fechaManifiesto,
								data.cilindraje,
								data.modelo,
								data.motor,
								data.chasis,
								data.serie,
								data.vin,
								data.numeroPasajeros
								);
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
		this._VehiculoService.editVehiculo(this.vehiculo,token).subscribe(
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





