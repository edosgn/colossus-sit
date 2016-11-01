// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Vehiculo} from "../../../model/vehiculo/vehiculo";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {VarianteService} from "../../../services/variante/variante.service";
import {CasoService} from "../../../services/caso/caso.service";
import {CiudadanoVehiculo} from "../../../model/ciudadanovehiculo/ciudadanovehiculo";
import {CiudadanoVehiculoService} from '../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service';

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteCancelarMatricula',
    templateUrl: 'app/view/tipoTramite/cancelarMatricula/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService,CiudadanoVehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteCancelarMatriculaComponent implements OnInit{ 
	
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public chasis;
	public tramiteEspecifico;
	public respuesta;
	public servicioSeleccionado = null;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() tramiteGeneralId =33;
	@Input() ciudadanosVehiculo = null;
	@Input() vehiculo = null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newData':null,
		'oldData':null
	};
	public cancelado=0;
	public idCiudadanoOld;
	public nitEmpresaOld;
	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _CiudadanoVehiculoService: CiudadanoVehiculoService, 
		private _VarianteService: VarianteService, 
		private _CasoService: CasoService, 
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){
		if(this.ciudadanosVehiculo[0].ciudadano){
	   	 	this.datos.oldData=this.ciudadanosVehiculo[0].ciudadano.numeroIdentificacion;
	   	 	this.idCiudadanoOld = this.ciudadanosVehiculo[0].ciudadano.id;
		}else{
			this.datos.oldData=this.ciudadanosVehiculo[0].empresa.nit;
			this.nitEmpresaOld = this.ciudadanosVehiculo[0].empresa.nit;
		}

		this.datos.oldData=this.vehiculo.chasis;
		this.tramiteEspecifico = new TramiteEspecifico(null,15,this.tramiteGeneralId,null,null,null);
		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,15).subscribe(
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
		this._VarianteService.showVariantesTramite(token,15).subscribe(
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

		
		
	}





	enviarTramite(){
		for (var i in this.ciudadanosVehiculo) {
		let ciudadanoVehiculo = new CiudadanoVehiculo
		(
			this.ciudadanosVehiculo[i].id, 
			this.idCiudadanoOld,
			this.ciudadanosVehiculo[i].vehiculo.placa,
			this.nitEmpresaOld,
			this.ciudadanosVehiculo[i].licenciaTransito,
			this.ciudadanosVehiculo[i].fechaPropiedadInicial,
			this.ciudadanosVehiculo[i].fechaPropiedadFinal,
			'0'
		);
		let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.editCiudadanoVehiculo(ciudadanoVehiculo,token).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					 this.tramiteCreado.emit(true);
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
		this.cancelado=1;
		let token = this._loginService.getToken();
		this._TramiteEspecificoService.register2(this.tramiteEspecifico,token,this.datos).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					 this.tramiteCreado.emit(true);
				}

			error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});

		this.vehiculo2 = new Vehiculo(
			this.vehiculo.id,
			this.vehiculo.clase.id, 
			this.vehiculo.municipio.id, 
			this.vehiculo.linea.id,
			this.vehiculo.servicio.id,
			this.vehiculo.color.id,
			this.vehiculo.combustible.id,
			this.vehiculo.carroceria.id,
			this.vehiculo.organismoTransito.id,
			this.vehiculo.placa,
			this.vehiculo.numeroFactura,
			this.vehiculo.fechaFactura,
			this.vehiculo.valor,
			this.vehiculo.numeroManifiesto,
			this.vehiculo.fechaManifiesto,
			this.vehiculo.cilindraje,
			this.vehiculo.modelo,
			this.vehiculo.motor,
			this.vehiculo.chasis,
			this.vehiculo.serie,
			this.vehiculo.vin,
			this.vehiculo.numeroPasajeros,
			this.vehiculo.pignorado,
			this.cancelado
		);

		this._VehiculoService.editVehiculo(this.vehiculo2,token).subscribe(
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

	onChangeCaso(event:any){
		this.tramiteEspecifico.casoId=event;
		
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
	}
}