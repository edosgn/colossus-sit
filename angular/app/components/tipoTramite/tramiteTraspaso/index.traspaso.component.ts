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

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteTraspaso',
    templateUrl: 'app/view/tipoTramite/tramiteTraspaso/index.component.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService,TipoIdentificacionService,EmpresaService,CiudadanoService,CiudadanoVehiculoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteTraspasoComponent implements OnInit{ 
	
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
	public colorSeleccionado = null;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() ciudadanosVehiculo = null;
	@Input() tramiteGeneralId =null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newData':null,
		'oldData':null,
		'datosTraspaso':null
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
	     }


	ngOnInit(){

		if(this.ciudadanosVehiculo[0].ciudadano){
	   	 	this.datos.oldData=this.ciudadanosVehiculo[0].ciudadano.numeroIdentificacion;
	   	 	this.idCiudadanoOld = this.ciudadanosVehiculo[0].ciudadano.id;
		}else{
			this.datos.oldData=this.ciudadanosVehiculo[0].empresa.nit;
			this.nitEmpresaOld = this.ciudadanosVehiculo[0].empresa.nit;
		}

		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,2).subscribe(
				response => {
					this.casos = response.data;
					this.tramiteEspecifico.casoId=this.casos[0].id;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,2).subscribe(
				response => {
					this.variantes = response.data;
					this.tramiteEspecifico.varianteId=this.variantes[0].id;
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

       

		this.tramiteEspecifico = new TramiteEspecifico(null,2,this.tramiteGeneralId,null,null,null);

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

	let token = this._loginService.getToken();

	this.ciudadanoVehiculoRegister = new CiudadanoVehiculo
		(
			this.ciudadanosVehiculo[i].id, 
			this.idCiudadanoNew,
			this.ciudadanosVehiculo[i].vehiculo.placa,
			this.nitEmpresaNew,
			this.ciudadanosVehiculo[i].licenciaTransito,
			this.ciudadanosVehiculo[i].fechaPropiedadInicial,
			this.ciudadanosVehiculo[i].fechaPropiedadFinal,
			'1'
		);


	this._CiudadanoVehiculoService.registerPropietario(this.ciudadanoVehiculoRegister,token).subscribe(
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


	this._TramiteEspecificoService.register2(this.tramiteEspecifico,token,this.datos).subscribe(
		response => {
			this.respuesta = response;

		error => {
				this.errorMessage = <any>error;

				if(this.errorMessage != null){
					alert("Error en la petición");
				}
			}

	});

	}


	onChangeCaso(event:any){
		this.datos.datosTraspaso="con opcion de compra";
		for (var i = 0; i < this.casos.length; ++i) {
			if(event == this.casos[i].id) {
				this.casoSeleccionado = this.casos[i];
			}
			
		}
		if(this.casoSeleccionado.nombre == "Leasing") {
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
					}else{
						this.divCiudadano = true;
						this.ciudadano = response.data;
                    	this.idCiudadanoNew = this.ciudadano.id;
						this.validateCedula=true;
						this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
						this.claseCedula = "form-group has-success has-feedback ";
						this.empresa=null;
						this.datos.newData = this.ciudadano.numeroIdentificacion;
						
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
                    	this.nitEmpresaNew = this.empresa.nit;
		                this.validateCedula=true;
		                this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
		                this.claseCedula = "form-group has-success has-feedback ";
		                this.ciudadano=null;
		                this.datos.newData = this.empresa.nit;
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

  	this.datos.datosTraspaso=event;

  }

 
}