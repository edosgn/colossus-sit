// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Vehiculo} from "../../../model/vehiculo/vehiculo";
import {CiudadanoVehiculo} from "../../../model/ciudadanovehiculo/ciudadanovehiculo";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {EmpresaService} from "../../../services/empresa/empresa.service";
import {CiudadanoService} from "../../../services/ciudadano/ciudadano.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {VarianteService} from "../../../services/variante/variante.service";
import {CasoService} from "../../../services/caso/caso.service";
import {TipoIdentificacionService} from '../../../services/tipo_Identificacion/tipoIdentificacion.service';
import {CiudadanoVehiculoService} from '../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service';
import {Ciudadano} from '../../../model/ciudadano/Ciudadano';
import {Empresa} from '../../../model/empresa/Empresa';
import {NewCiudadanoComponent} from '../../../components/ciudadano/new.ciudadano.component';
import {NewEmpresaComponent} from '../../../components/empresa/new.empresa.component';

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteRematricula',
    templateUrl: 'app/view/tipoTramite/tramiteRematricula/index.html',
    directives:
	[
	ROUTER_DIRECTIVES, 
	NewCiudadanoComponent,
	NewEmpresaComponent
	],
    providers: [LoginService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService,TipoIdentificacionService,EmpresaService,CiudadanoService,CiudadanoVehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteRematriculaComponent implements OnInit{ 
	
	public tipoIdentificaciones;
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public tramiteEspecifico;
	public respuesta;
	public tipoIdentificacion;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() vehiculo = null;
	@Input() tramiteGeneralId =null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newData':null,
		'oldData':null,
		'datosRematricula':null
	};
	public validateCedula;
	public claseSpanCedula;
	public claseCedula;
	public ciudadano:Ciudadano;
	public empresa:Empresa;
	public divDatos = false;
	public ciudadanoVehiculo;
	public divCiudadano;
	public divEmpresa;
	public idCiudadanoOld = null;
	public nitEmpresaOld= null;
	public idCiudadanoNew = null;
	public nitEmpresaNew= null;
	public ciudadanoVehiculoRegister;
	public TipoMatricula=null;
	public TipoTramite=null;
	public json=null;
	public licenciaTransito;
	public fechaRematricula;
	public numeroIdentificacion;
	public nit;
	public btnNewPropietario;
	public modalEmpresa;
	public modalCiudadano;



	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _VarianteService: VarianteService,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService, 
		private _TipoIdentificacionService: TipoIdentificacionService,
		private _CasoService: CasoService, 
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _EmpresaService: EmpresaService,
		private _CiudadanoService: CiudadanoService,
		private _router: Router
		
		){
			this.empresa = new Empresa(null,null,null,null,null,"","","","");
			this.ciudadano = new Ciudadano(null,"",null, "","","","","");
			this.ciudadanoVehiculo = new CiudadanoVehiculo(null,null, null,null,null,"","","");
	     }


	ngOnInit(){


		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,36).subscribe(
				response => {
					this.casos = response.data;
					if(this.casos!=null){
						this.tramiteEspecifico.casoId=this.casos[0].id;
					}
					
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,36).subscribe(
				response => {
					this.variantes = response.data;
					if(this.variantes!=null) {
						this.tramiteEspecifico.varianteId=this.variantes[0].id;
					}
					
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
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

       

		this.tramiteEspecifico = new TramiteEspecifico(null,36,this.tramiteGeneralId,null,null,null);

	}

	enviarTramite(){


	let ciudadanoVehiculo = new CiudadanoVehiculo
		(
			null, 
			this.idCiudadanoNew,
			this.vehiculo.placa,
			this.nitEmpresaNew,
			this.ciudadanoVehiculo.licenciaTransito,
			this.ciudadanoVehiculo.fechaPropiedadInicial,
			this.ciudadanoVehiculo.fechaPropiedadInicial,
			"1"
		);
	
	this.TipoMatricula=36;
  	let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.register(ciudadanoVehiculo,token,this.TipoMatricula,this.json,this.TipoTramite).subscribe(
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
			0
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
	this.datos.datosRematricula="con opcion de compra";
	for (var i = 0; i < this.casos.length; ++i) {
		if(event == this.casos[i].id) {
			this.casoSeleccionado = this.casos[i];
		}
		
	}
	if(this.casoSeleccionado.nombre == "LEASING") {
		this.divDatos= true;
	}else{
		this.divDatos= false;
	}
	this.tramiteEspecifico.casoId=event;

		
	
		
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
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
						this.btnNewPropietario=true;
						this.modalCiudadano=true;
					}else{
						this.divEmpresa = false;
						this.divCiudadano = true;
						this.ciudadano = response.data;
                    	this.idCiudadanoNew = this.ciudadano.numeroIdentificacion;
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
		                this.btnNewPropietario=true;
		                this.modalEmpresa=true;
                    }else{
                    	this.divCiudadano = false;
                    	this.divEmpresa = true;
                    	this.empresa = response.data;
                    	this.nitEmpresaNew = this.empresa.nit;
		                this.validateCedula=true;
		                this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
		                this.claseCedula = "form-group has-success has-feedback ";
		                this.ciudadano=null;
		                this.nitEmpresaNew=this.empresa.nit;
		              
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

  onChangeCasoData(event:any){

  	this.datos.datosRematricula=event;

  }

  ciudadanoCreado(event:any) {
		this.onKeyCiudadano(event);

	}
	empresaCreada(event:any){
		this.onKeyEmpresa(event);
	}

	btnCancelarModalCedula(){
		this.modalCiudadano=false;
		this.btnNewPropietario=false;
	}

	btnCancelarModalEmpresa(){
		this.modalEmpresa=false;
		this.btnNewPropietario=false;
	}

 
}