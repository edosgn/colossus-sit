// Importar el núcleo de Angular
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service';
import {VehiculoService} from '../../services/vehiculo/vehiculo.service';
import {TramiteGeneral} from '../../model/tramiteGeneral/TramiteGeneral';
import {Ciudadano} from '../../model/ciudadano/Ciudadano';
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {CiudadanoVehiculoService} from "../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";

 
// Decorador component, indicamos en que etiqueta se va a cargar la  

@Component({
    selector: 'registerTramiteGeneral',
    templateUrl: 'app/view/tramiteGeneral/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteGeneralService,VehiculoService,CiudadanoVehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteGeneralComponent {
	public tramiteGeneral: TramiteGeneral;
	public errorMessage;
	public respuesta;
	public ciudadano:Ciudadano;
	public vehiculos;
	public ciudadanosVehiculo:CiudadanoVehiculo;
	@Input() vehiculoId = null;
	@Input() ciudadanoId = null;
	@Input() empresaId = null;
	@Input() Apoderado = null;
	@Output() tramiteGeneralCreado = new EventEmitter<any>();
	constructor(

		private _TramiteGeneralService:TramiteGeneralService,
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tramiteGeneral = new TramiteGeneral(null,this.vehiculoId, null, "", "", null, null, null ,"",null,this.empresaId,this.ciudadanoId);
		let token = this._loginService.getToken();
		
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
	}

	onSubmit(){

		let token = this._loginService.getToken();

		this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token,this.vehiculoId).subscribe(
			response => {
				this.ciudadanosVehiculo = response.data;
			}, 
			error => {
				this.errorMessage = <any>error;

				if(this.errorMessage != null){
					console.log(this.errorMessage);
					alert("Error en la petición");
				}
			}
		);

		this.tramiteGeneral.apoderado = this.Apoderado;

		this._TramiteGeneralService.register(this.tramiteGeneral,token).subscribe(

			response => {
				this.respuesta = response;
				console.log(this.tramiteGeneral);
				if(this.respuesta.status=="success") {
						for (var i in this.ciudadanosVehiculo) {
							let ciudadanoVehiculo = new CiudadanoVehiculo
							(
								this.ciudadanosVehiculo[i].id, 
								this.ciudadanoId,
								this.ciudadanosVehiculo[i].vehiculo.placa,
								this.empresaId,
								this.tramiteGeneral.numeroLicencia,
								this.ciudadanosVehiculo[i].fechaPropiedadInicial,
								this.ciudadanosVehiculo[i].fechaPropiedadFinal,
								this.ciudadanosVehiculo[i].estadoPropiedad
							);
							let token = this._loginService.getToken();
							this._CiudadanoVehiculoService.editCiudadanoVehiculo(ciudadanoVehiculo,token).subscribe(
							response => {
								this.respuesta = response;
								if(this.respuesta.status=="success") {
									 this.tramiteGeneralCreado.emit(true);
								}
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
