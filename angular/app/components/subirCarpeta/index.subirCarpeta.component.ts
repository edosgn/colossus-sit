// Importar el núcleo de Angular
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
import {NewCiudadanoComponent} from '../../components/ciudadano/new.ciudadano.component';
import {NewEmpresaComponent} from '../../components/empresa/new.empresa.component';
import {CiudadanoVehiculo} from '../../model/CiudadanoVehiculo/CiudadanoVehiculo';
import {Ciudadano} from '../../model/ciudadano/Ciudadano';
import {TramiteGeneralService} from '../../services/tramiteGeneral/tramiteGeneral.service'; 
import {TramiteEspecificoService} from "../../services/tramiteEspecifico/tramiteEspecifico.service";
import {Empresa} from '../../model/empresa/Empresa';
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/subirCarpeta/index.component.html',
    directives: [ROUTER_DIRECTIVES, NewVehiculoComponent,NewCiudadanoComponent,NewEmpresaComponent],
    providers: [LoginService,TramiteEspecificoService,TramiteGeneralService,VehiculoService,CiudadanoVehiculoService,CiudadanoService,TipoIdentificacionService,EmpresaService,OrganismoTransitoService]
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
    public organismoTransitos;
    public json = {
 		'organismoTrancito' :[],
 	};


	constructor(
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
			this.ciudadano = new Ciudadano(null,"",null, "","","","","");
            this.ciudadanoVehiculo = new CiudadanoVehiculo(null, null,null,null,"","","","");
            this.empresa = new Empresa(null,null,null,null,null,"","","","");
            let token = this._loginService.getToken();
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
						this.claseSpan ="glyphicon glyphicon-remove form-control-feedback ";
						this.clase = "form-group has-error has-feedback";
						this.activar =false;
					}else{
							this.tramitesGeneralSeccion =true;
							this.claseSpan ="glyphicon glyphicon-ok form-control-feedback ";
							this.clase = "form-group has-success has-feedback";
				            this.msg = response.msj;
				            this.crear=false;
				            this.validate=true;
				       		this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token,this.vehiculo.id).subscribe(
								response => {
									this.ciudadanosVehiculo = response.data;
									this.respuesta = response;
									console.log(this.ciudadanosVehiculo);
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

  onChangeCiudadano(id) {
  	this.idCiudadanoSeleccionado = id;
  	console.log(this.idCiudadanoSeleccionado);
  }
  onChangeTramiteGeneral(id){
  	let tramiteGeneral = id;
	let token = this._loginService.getToken();
  	console.log("tramite general: " +tramiteGeneral);
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

  vheiculoCreado(event:any) {
  	this.placa.placa=event
    this.onKey("");
  }
  ciudadanoCreado(event:any) {
  	this.onKeyCiudadano(event);

  }
  empresaCreada(event:any){
  	this.onKeyEmpresa(event);
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
		this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo,token,this.TipoMatricula,this.json).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=='success') {
                    this.ciudadanoVehiculo.licenciaTransito="";
					this.validateCedula=false;
					this.onKey("");

				}
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
}
