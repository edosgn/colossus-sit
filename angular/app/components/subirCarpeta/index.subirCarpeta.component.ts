// Importar el núcleo de Angular
import {TramiteService} from "../../services/tramite/tramite.service";
import {OrganismoTransitoService} from "../../services/organismoTransito/organismoTransito.service";
import {EmpresaService} from "../../services/empresa/empresa.service";
import {CiudadanoVehiculoService} from "../../services/ciudadanoVehiculo/ciudadanoVehiculo.service";
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Tramite} from '../../model/tramite/Tramite';
import {NewVehiculoComponent} from '../../components/vehiculo/new.vehiculo.component';
import {NewTramiteGeneralComponent} from '../../components/tramiteGeneral/new.tramiteGeneral.component';
import {NewCiudadanoComponent} from '../../components/ciudadano/new.ciudadano.component';
import {NewEmpresaComponent} from '../../components/empresa/new.empresa.component';
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {Ciudadano} from '../../model/ciudadano/Ciudadano';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service'; 
import {TramiteEspecificoService} from "../../services/tramiteEspecifico/tramiteEspecifico.service";
import {Empresa} from '../../model/empresa/Empresa';
import {NewTramiteTraspasoComponent} from "../../components/tipoTramite/tramiteTraspaso/index.traspaso.component";
import {NewTramiteTrasladoCuentaComponent} from "../../components/tipoTramite/tramiteTrasladoCuenta/index.TrasladoCuenta.component";
import {NewTramiteCambioServicioComponent} from "../../components/tipoTramite/tramiteCambioServicio/index.cambioServicio.component";
import {NewTramiteRegrabarMotorComponent} from "../../components/tipoTramite/tramiteRegrabarMotor/index.regrabarMotor.component";
import {NewTramiteCambioMotorComponent} from "../../components/tipoTramite/tramiteCambioMotor/index.cambioMotor.component";
import {NewTramiteRegrabarChasisComponent} from "../../components/tipoTramite/tramiteRegrabarChasis/index.regrabarChasis.component";
import {NewTramiteRegrabarSerieComponent} from "../../components/tipoTramite/tramiteRegrabarSerie/index.regrabarSerie.component";
import {NewTramiteCambioColorComponent} from "../../components/tipoTramite/tramiteCambioColor/index.cambioColor.component";
import {NewTramiteCambioCarroceriaComponent} from "../../components/tipoTramite/tramiteCambioCarroceria/index.cambioCarroceria.component";
import {NewTramiteDuplicadoLicenciaComponent} from "../../components/tipoTramite/tramiteDuplicadoLicencia/index.duplicadoLicencia.component";
import {NewTramiteDuplicadoPlacaComponent} from "../../components/tipoTramite/tramiteDuplicadoPlaca/index.duplicadoPlaca.component";
import {NewTramiteCambioBlindajeComponent} from "../../components/tipoTramite/tramiteCambioBlindaje/index.cambioBlindaje.component";;

// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/subirCarpeta/index.component.html',
    directives: [
        ROUTER_DIRECTIVES,
	    NewVehiculoComponent,
	    NewCiudadanoComponent,
	    NewEmpresaComponent,
	    NewTramiteGeneralComponent,
	    NewTramiteTraspasoComponent,
	    NewTramiteCambioColorComponent,
	    NewTramiteCambioServicioComponent,
	    NewTramiteRegrabarMotorComponent,
	    NewTramiteRegrabarChasisComponent,
	    NewTramiteRegrabarSerieComponent,
	    NewTramiteDuplicadoLicenciaComponent,
	    NewTramiteCambioBlindajeComponent,
	    NewTramiteCambioMotorComponent,
	    NewTramiteDuplicadoPlacaComponent,
	    NewTramiteCambioCarroceriaComponent,
	    NewTramiteTrasladoCuentaComponent],
    providers: [
        LoginService,
	    TramiteService,
	    TramiteEspecificoService,
	    TramiteGeneralService,
	    VehiculoService,
	    CiudadanoVehiculoService,
	    CiudadanoService,
	    TipoIdentificacionService,
	    EmpresaService,
	    OrganismoTransitoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexSubirCarpetaComponent implements OnInit{ 
	public tramitesGeneral;
	public ciudadano: Ciudadano;
	public errorMessage; 
	public tramiteId;
	public respuesta;
	public activar;
	public vehiculo;
	public validate;
	public ciudadanoVehiculo: CiudadanoVehiculo;
	public empresa: Empresa;
	public clase;
	public msg;
	public claseSpan;
	public ciudadanosVehiculo;
	public validateCiudadano;
	public idCiudadanoSeleccionado;
	public colores;
	public colorNuevo;
	public finalizar; 
	public crear;
	public placa;
	public resive;
	public identificacion;
	public validateCedula;
	public msgCiudadano;
	public calseCedula;
	public claseSpanCedula;
	public existe;
    public tipoIdentificaciones;
    public nit;
    public btnNewPropietario;
    public modalCiudadano;
    public modalEmpresa;
    public btnSeleccionarApoderado;
    public tramiteEspecificos;
    public tramitesGeneralSeccion;
    public divEmpresa;
    public TipoMatricula = 1;
    public divTramiteGeneral;
    public idEmpresaSeleccionada;
    public tramiteGeneralSeccion;
    public tramites;
    public tramiteEspesificolSeleccionado:number;
    public divTramite;
    public tramiteGeneralSeleccionado;
    public TipoTramite = {
    	'caso':null,
    	'variante':null
    };

    public organismoTransitos;
    public json = {
 		'datosGenerales' :null,
 	};
 	public existeCiudadano;
 	public existeEmpresa;


	constructor(
		private _TramiteService:TramiteService,
		private _OrganismoTransitoService: OrganismoTransitoService,
		private _TramiteEspecificoService: TramiteEspecificoService,
		private _TramiteGeneral: TramiteGeneralService,
        private _EmpresaService: EmpresaService,
        private _TipoIdentificacionService: TipoIdentificacionService,
		private _VehiculoService: VehiculoService,
		private _CiudadanoService: CiudadanoService,
		private _CiudadanoVehiculoService: CiudadanoVehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){
			let token = this._loginService.getToken();
		  this._TramiteService.TramitesModulo(1,token).subscribe(
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

			this.ciudadano = new Ciudadano(null,"",null, "","","","","");
            this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,null,null,"","","");
            this.empresa = new Empresa(null,null,null,null,null,"","","","");
            this._TipoIdentificacionService.getTipoIdentificacion().subscribe(
                    response => {
                        this.tipoIdentificaciones = response.data;
                    }, 
                    error => {
                        this.errorMessage = <any>error;
                        if(this.errorMessage != null){
                            console.log(this.errorMessage);
                            alert("Error en la petición");
                        }
                    }
                );
            this._OrganismoTransitoService.getOrganismoTransito().subscribe(
				response => {
					this.organismoTransitos = response.data;
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


	ngOnInit(){	
		this.placa = {
 		'placa' : this.placa,
 	};

		this._route.params.subscribe(params =>{
				this.tramiteId = +params["tramiteId"];
			});

		let token = this._loginService.getToken();
	}

	onKey(event:any) {
	this.tramiteEspesificolSeleccionado=null;
	this.idCiudadanoSeleccionado=null
 	let token = this._loginService.getToken();
 	this._VehiculoService.showVehiculoPlaca(token,this.placa).subscribe(
				response => {
					this.vehiculo = response.data;
					let status = response.status;
					if(status == 'error') {
						this.tramitesGeneral=false;
						this.validate=false	;
						this.validateCiudadano=false;
						this.crear=true;
						this.tramitesGeneralSeccion=false;
						this.claseSpan ="glyphicon glyphicon-remove form-control-feedback ";
						this.clase = "form-group has-error has-feedback";
						this.activar =false;
					}else{
							this.claseSpan ="glyphicon glyphicon-ok form-control-feedback ";
							this.clase = "form-group has-success has-feedback";
				            this.msg = response.msj;
				            this.crear=false;
				            this.validate=true;
				       		this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token,this.vehiculo.id).subscribe(
								response => {
									this.ciudadanosVehiculo = response.data;
									this.respuesta = response;
									this.tramitesGeneralSeccion =true;
									if(this.respuesta.status == 'error') {
										this.activar=true;
										this.validateCiudadano=false;
									}else{
									 this.activar=true;
									 this.validate=true	;
									 this.validateCiudadano=true;
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
				       		let vehiculoTramite = {
						 		'vehiculoId' : this.vehiculo.id,
						 	};
							this._TramiteGeneral.showTramiteGeneralVehiculo(token,vehiculoTramite).subscribe(
								response => {
									this.tramitesGeneral = response.data;
									this.tramiteEspecificos = null;
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

  onKeyCiudadano(event:any){
  	let identificacion = {
 		'numeroIdentificacion' : event,
 	};
  	let token = this._loginService.getToken();
  	this._CiudadanoService.showCiudadanoCedula(token,identificacion).subscribe(
				response => {
					let status = response.status;
					if(this.ciudadanosVehiculo) {
						for (var i = this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
								if(this.ciudadanosVehiculo[i].ciudadano) {
									if(this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
									this.existe = true;
								}
							}
						}
					}

					if(this.ciudadanosVehiculo) {
                        for (var i = this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                            if(this.ciudadanosVehiculo[i].empresa) {
                                if(this.ciudadanosVehiculo[i].empresa.nit == event) {
                                    this.existeEmpresa = true;
                                }
                            }
                        }
                    }

                    if(this.existeEmpresa){
                        this.validateCedula = false;
                        this.existe = false;
                        alert ("existe una relacion con una empresa imposible asociar ciudadano");
                        return(0);
                    }

					
					if(this.existe){
                        this.validateCedula = false;
                        this.existe = false;
						alert ("existe una relacion con el ciudadano");
					}else{
						if(status == 'error') {
						this.validateCedula=false;
						this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
						this.calseCedula = "form-group has-error has-feedback ";
						this.btnNewPropietario=true;
						this.modalCiudadano=true;
						}else{
							this.ciudadano = response.data;
							this.btnNewPropietario=false;
							this.validateCedula=true;
							this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
							this.calseCedula = "form-group has-success has-feedback ";
				            this.msgCiudadano = response.msj;
                            this.divEmpresa = false;
						}
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
  }

  onKeyEmpresa(event:any){
      let nit = {
         'nit' : event,
     };
      let token = this._loginService.getToken();
      this._EmpresaService.showNit(token,nit).subscribe(
                response => {
                    let status = response.status;

                    if(this.ciudadanosVehiculo) {
                        for (var i = this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                            if(this.ciudadanosVehiculo[i].empresa) {
                                if(this.ciudadanosVehiculo[i].empresa.nit == event) {
                                    this.existe = true;
                                }
                            }
                        }
                    }

                    if(this.ciudadanosVehiculo) {
						for (var i = this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
								if(this.ciudadanosVehiculo[i].ciudadano) {
									if(this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
									this.existeCiudadano = true;
								}
							}
						}
					}

					if(this.existeCiudadano){
                        this.validateCedula = false;
                        this.existe = false;
                        alert ("existe una relacion con un siudadano imposible asociar empresa");
                        return(0);
                    }

                    
                    if(this.existe){
                        this.validateCedula = false;
                        this.existe = false;
                        alert ("existe una relacion con la empresa");
                    }else{
                        if(status == 'error') {
                        this.validateCedula=false;
                        this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
                        this.calseCedula = "form-group has-error has-feedback ";
                        this.btnNewPropietario = true;
                        this.modalEmpresa=true;
                        }else{
                   			this.empresa = response.data;
                        	this.btnNewPropietario=false;
                        	this.divEmpresa=true;
                            this.validateCedula=true;
                            this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
                            this.calseCedula = "form-group has-success has-feedback ";
                            this.msgCiudadano = response.msj;
                            this.ciudadano = new Ciudadano(null,"",null, "","","","","");
                        }
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
  }


  VehiculoCiudadano(){

  	this.ciudadanoVehiculo.ciudadanoId=this.ciudadano.numeroIdentificacion;
  	this.ciudadanoVehiculo.estadoPropiedad="1";
    this.ciudadanoVehiculo.empresaId=this.empresa.nit;
    this.ciudadanoVehiculo.vehiculoId=this.vehiculo.placa;
    this.ciudadanoVehiculo.fechaPropiedadInicial=this.vehiculo.fechaFactura;
    if(this.ciudadanosVehiculo != null) {
       this.ciudadanoVehiculo.licenciaTransito=this.ciudadanosVehiculo[0].licenciaTransito;
    }
  	let token = this._loginService.getToken();
		this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo,token,this.TipoMatricula,this.json,this.TipoTramite).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=='success') {
                    this.ciudadanoVehiculo.licenciaTransito=null;
					this.validateCedula=false;
					this.json = null;
					this.TipoTramite=null;
					this.onKey("");
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

  onChangeTramiteGeneral(id){
  	this.tramiteGeneralSeleccionado= id;
  	this.tramiteEspesificolSeleccionado = id;
	let token = this._loginService.getToken();
	  	this._TramiteEspecificoService.showTramiteEspecificoGeneral(token,id).subscribe(
					response => {
						this.tramiteEspecificos = response.data;
						console.log(this.tramiteEspecificos);
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
  
  onChangeApoderado(event:any){
    	if(event==true){
    		this.btnSeleccionarApoderado=true;
    	}else{
    		this.btnSeleccionarApoderado=false;
    	}
    }

    onChangeCiudadano(id) {
    	this.divTramiteGeneral=false;
  		this.idCiudadanoSeleccionado = id;
  		this.idEmpresaSeleccionada = null;
  	}
   onChangeEmpresa(id){
   	this.divTramiteGeneral=false;
	  	this.idEmpresaSeleccionada = id;
	  	this.idCiudadanoSeleccionado = null;
	}

    onChangeNit(Value) {
	        if(Value == 4) {
	            this.nit = true;
	            this.validateCedula=false;
	        }else{
	            this.nit = false;
	            this.validateCedula=false;
	        }
    }
    onChangeTipoMatricula(event:any){
    	this.TipoMatricula = event;
    }

    btnCancelarVinculo(){
        this.validateCedula=false;
    }

    btnCancelarModalCedula(){
    	this.modalCiudadano=false;
    	this.btnNewPropietario=false;
    }

    btnCancelarModalEmpresa(){
	    this.modalEmpresa=false;
	    this.btnNewPropietario=false;
    }
    btnNuevoTramiteGeneral(){
    	if(this.idCiudadanoSeleccionado != null || this.idEmpresaSeleccionada != null){
    	 this.divTramiteGeneral=true;
    	}
    }
    btnCancelarNuevoTramiteGeneral(){
    	this.divTramiteGeneral=false;
    }
    btnNuevoTramiteEspesifico(){
    	this.divTramite=true;
    }
    prueba(event:any){
    	if(event=="2") {
    		this.json.datosGenerales = "Con opcion de compra";
    	}else{
    		this.json.datosGenerales = event;
    	}
    }

    vheiculoCreado(event:any) {
	  	this.placa.placa=event
	    this.onKey("");
		  }
	  tramiteGeneralCreado(tramiteGeneral){
	  	if(tramiteGeneral) {
	  		this.divTramiteGeneral=false;
	  		this.idCiudadanoSeleccionado=null;
	  		this.idEmpresaSeleccionada=null;
	  		this.tramiteGeneralSeccion=null;
	  		this.onKey("");
	  	}
	  }
	  ciudadanoCreado(event:any) {
	  	this.onKeyCiudadano(event);

	  }
	  empresaCreada(event:any){
	  	this.onKeyEmpresa(event);
	  }

	  tramiteCreado(isCreado:any){
		if(isCreado) {
			this.divTramite=false;
		  		this.onKey("");
		  	}
	  }
}