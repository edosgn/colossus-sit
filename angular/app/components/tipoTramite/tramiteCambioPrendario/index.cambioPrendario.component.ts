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
import {CombustibleService} from "../../../services/combustible/combustible.service";
import {TipoIdentificacionService} from '../../../services/tipo_Identificacion/tipoIdentificacion.service';
import {EmpresaService} from "../../../services/empresa/empresa.service";
import {CiudadanoService} from "../../../services/ciudadano/ciudadano.service";

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteCambioPrendario',
    templateUrl: 'app/view/tipoTramite/cambioPrendario/index.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService,CombustibleService,TipoIdentificacionService,CiudadanoService,EmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteCambioPrendarioComponent implements OnInit{ 
	
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public combustibleSeleccionado;
	public tramiteEspecifico;
	public respuesta;
	public nuevo = true;
	public usado = null;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() tramiteGeneralId =22;
	@Input() vehiculo = null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'prendario':null
	};


	public validateCedula;
	public claseSpanCedula;
	public claseCedula;
	public ciudadano;
	public empresa;
	public divDatos = false;
	public ciudadanoVehiculo;
	public divCiudadano;
	public divEmpresa;
	public idCiudadano = null;
	public nitEmpresa= null;
	public tipoIdentificaciones;
	public cancelado=null;
	public pignorado=null;
	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _VarianteService: VarianteService,
		private _TipoIdentificacionService: TipoIdentificacionService,
		private _CombustibleService: CombustibleService, 
		private _CasoService: CasoService, 
		private _EmpresaService: EmpresaService,
		private _CiudadanoService: CiudadanoService,
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){
		this.tramiteEspecifico = new TramiteEspecifico(null,54,this.tramiteGeneralId,null,null,null);
		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,54).subscribe(
				response => {
					this.casos = response.data;
					if(this.casos!=null) {
						this.tramiteEspecifico.casoId=this.casos[0].id;
					}
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,54).subscribe(
				response => {
					this.variantes = response.data;
					if(this.variantes!=null) {
						this.tramiteEspecifico.varianteId=this.variantes[0].id;
					}
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);

		this._TipoIdentificacionService.getTipoIdentificacion().subscribe(
            response => {
                this.tipoIdentificaciones = response.data;
            }, 
            error => {
                this.errorMessage = <any>error;
                if(this.errorMessage != null){
                    alert("Error en la petición");
                }
            }
        );

		

		
		
	}


	enviarTramite(){

		this.pignorado=true;
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
			this.pignorado,
			this.vehiculo.cancelado
		);
		console.log(this.vehiculo2);

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

	onKeyCiudadano(event:any){
  	let identificacion = {
 		'numeroIdentificacion' : event,
 	};
  	let token = this._loginService.getToken();
  	this._CiudadanoService.showCiudadanoCedula(token,identificacion).subscribe(
				response => {
					let status = response.status;
					if(status=="error") {
						this.validateCedula=false;
						this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
						this.claseCedula = "form-group has-error has-feedback ";
						this.ciudadano=null;
					}else{
						this.divCiudadano = true;
						this.ciudadano = response.data;
						this.datos.prendario=this.ciudadano.numeroIdentificacion;
                    	this.idCiudadano = this.ciudadano.id;
						this.validateCedula=true;
						this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
						this.claseCedula = "form-group has-success has-feedback ";
						this.empresa=null;
						
					}
				}, 
				error => {
					this.errorMessage = <any>error;
					if(this.errorMessage != null){
						alert("Error en la petición");
					}
				}
			);
 	}
  
 	onKeyEmpresa(event:any){
    let nit = {
         'nit' : event,
    };
      let token = this._loginService.getToken();
      this._EmpresaService.showNit(token,nit).subscribe(
                response => {
                    let status = response.status;
                    if(status=="error") {
                    	this.validateCedula=false;
		                this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
		                this.claseCedula = "form-group has-error has-feedback ";
		                this.empresa=null;
                    }else{
                    	this.divEmpresa = true;
                    	this.empresa = response.data;
                    	this.datos.prendario=this.empresa.nit;
                    	this.nitEmpresa = this.empresa.nit;
		                this.validateCedula=true;
		                this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
		                this.claseCedula = "form-group has-success has-feedback ";
		                this.ciudadano=null;
                    }
                }, 
                error => {
                    this.errorMessage = <any>error;

                    if(this.errorMessage != null){
                        alert("Error en la petición");
                    }
                }
            );
  }

	onChangeCaso(event:any){
		this.tramiteEspecifico.casoId=event;
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
	}
	
}
