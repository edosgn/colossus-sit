"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
// Importar el núcleo de Angular
var tramite_service_1 = require("../../services/tramite/tramite.service");
var organismoTransito_service_1 = require("../../services/organismoTransito/organismoTransito.service");
var empresa_service_1 = require("../../services/empresa/empresa.service");
var ciudadanoVehiculo_service_1 = require("../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
var tipoIdentificacion_service_1 = require('../../services/tipo_Identificacion/tipoIdentificacion.service');
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var ciudadano_service_1 = require("../../services/ciudadano/ciudadano.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var new_vehiculo_component_1 = require('../../components/vehiculo/new.vehiculo.component');
var new_tramiteGeneral_component_1 = require('../../components/tramiteGeneral/new.tramiteGeneral.component');
var new_ciudadano_component_1 = require('../../components/ciudadano/new.ciudadano.component');
var new_empresa_component_1 = require('../../components/empresa/new.empresa.component');
var CiudadanoVehiculo_1 = require('../../model/CiudadanoVehiculo/CiudadanoVehiculo');
var Ciudadano_1 = require('../../model/ciudadano/Ciudadano');
var tramiteGeneral_service_1 = require('../../services/tramiteGeneral/tramiteGeneral.service');
var tramiteEspecifico_service_1 = require("../../services/tramiteEspecifico/tramiteEspecifico.service");
var Empresa_1 = require('../../model/empresa/Empresa');
var index_cambioColor_component_1 = require("../../components/tipoTramite/tramiteCambioColor/index.cambioColor.component");
var index_TrasladoCuenta_component_1 = require("../../components/tipoTramite/tramiteTrasladoCuenta/index.TrasladoCuenta.component");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexSubirCarpetaComponent = (function () {
    function IndexSubirCarpetaComponent(_TramiteService, _OrganismoTransitoService, _TramiteEspecificoService, _TramiteGeneral, _EmpresaService, _TipoIdentificacionService, _VehiculoService, _CiudadanoService, _CiudadanoVehiculoService, _loginService, _route, _router) {
        var _this = this;
        this._TramiteService = _TramiteService;
        this._OrganismoTransitoService = _OrganismoTransitoService;
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._TramiteGeneral = _TramiteGeneral;
        this._EmpresaService = _EmpresaService;
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._VehiculoService = _VehiculoService;
        this._CiudadanoService = _CiudadanoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.TipoMatricula = 1;
        this.TipoTramite = {
            'caso': null,
            'variante': null
        };
        this.json = {
            'datosGenerales': null,
        };
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.tramites = response.data;
            console.log(_this.tramites);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
        this.ciudadanoVehiculo = new CiudadanoVehiculo_1.CiudadanoVehiculo(null, null, null, null, "", "", "", "");
        this.empresa = new Empresa_1.Empresa(null, null, null, null, null, "", "", "", "");
        var token = this._loginService.getToken();
        this._TipoIdentificacionService.getTipoIdentificacion().subscribe(function (response) {
            _this.tipoIdentificaciones = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._OrganismoTransitoService.getOrganismoTransito().subscribe(function (response) {
            _this.organismoTransitos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    }
    IndexSubirCarpetaComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.placa = {
            'placa': this.placa,
        };
        this._route.params.subscribe(function (params) {
            _this.tramiteId = +params["tramiteId"];
        });
        var token = this._loginService.getToken();
    };
    IndexSubirCarpetaComponent.prototype.onKey = function (event) {
        var _this = this;
        this.tramiteEspesificolSeleccionado = null;
        this.idCiudadanoSeleccionado = null;
        var token = this._loginService.getToken();
        this._VehiculoService.showVehiculoPlaca(token, this.placa).subscribe(function (response) {
            _this.vehiculo = response.data;
            var status = response.status;
            if (status == 'error') {
                _this.tramitesGeneral = false;
                _this.validate = false;
                _this.validateCiudadano = false;
                _this.crear = true;
                _this.tramitesGeneralSeccion = false;
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback ";
                _this.clase = "form-group has-error has-feedback";
                _this.activar = false;
            }
            else {
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback ";
                _this.clase = "form-group has-success has-feedback";
                _this.msg = response.msj;
                _this.crear = false;
                _this.validate = true;
                _this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, _this.vehiculo.id).subscribe(function (response) {
                    _this.ciudadanosVehiculo = response.data;
                    _this.respuesta = response;
                    _this.tramitesGeneralSeccion = true;
                    if (_this.respuesta.status == 'error') {
                        _this.activar = true;
                        _this.validateCiudadano = false;
                    }
                    else {
                        _this.activar = true;
                        _this.validate = true;
                        _this.validateCiudadano = true;
                    }
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
                var vehiculoTramite = {
                    'vehiculoId': _this.vehiculo.id,
                };
                _this._TramiteGeneral.showTramiteGeneralVehiculo(token, vehiculoTramite).subscribe(function (response) {
                    _this.tramitesGeneral = response.data;
                    _this.tramiteEspecificos = null;
                }, function (error) {
                    _this.errorMessage = error;
                    if (_this.errorMessage != null) {
                        console.log(_this.errorMessage);
                        alert("Error en la petición");
                    }
                });
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onKeyCiudadano = function (event) {
        var _this = this;
        var identificacion = {
            'numeroIdentificacion': event,
        };
        var token = this._loginService.getToken();
        this._CiudadanoService.showCiudadanoCedula(token, identificacion).subscribe(function (response) {
            var status = response.status;
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].ciudadano) {
                        if (_this.ciudadanosVehiculo[i].ciudadano.numeroIdentificacion == event) {
                            _this.existe = true;
                        }
                    }
                }
            }
            if (_this.existe) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con el ciudadano");
            }
            else {
                if (status == 'error') {
                    _this.validateCedula = false;
                    _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                    _this.calseCedula = "form-group has-error has-feedback ";
                    _this.btnNewPropietario = true;
                    _this.modalCiudadano = true;
                }
                else {
                    _this.ciudadano = response.data;
                    _this.btnNewPropietario = false;
                    _this.validateCedula = true;
                    _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                    _this.calseCedula = "form-group has-success has-feedback ";
                    _this.msgCiudadano = response.msj;
                    _this.divEmpresa = false;
                }
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onKeyEmpresa = function (event) {
        var _this = this;
        var nit = {
            'nit': event,
        };
        var token = this._loginService.getToken();
        this._EmpresaService.showNit(token, nit).subscribe(function (response) {
            var status = response.status;
            if (_this.ciudadanosVehiculo) {
                for (var i = _this.ciudadanosVehiculo.length - 1; i >= 0; i--) {
                    if (_this.ciudadanosVehiculo[i].empresa) {
                        if (_this.ciudadanosVehiculo[i].empresa.nit == event) {
                            _this.existe = true;
                        }
                    }
                }
            }
            if (_this.existe) {
                _this.validateCedula = false;
                _this.existe = false;
                alert("existe una relacion con la empresa");
            }
            else {
                if (status == 'error') {
                    _this.validateCedula = false;
                    _this.claseSpanCedula = "glyphicon glyphicon-remove form-control-feedback";
                    _this.calseCedula = "form-group has-error has-feedback ";
                    _this.btnNewPropietario = true;
                    _this.modalEmpresa = true;
                }
                else {
                    _this.empresa = response.data;
                    _this.btnNewPropietario = false;
                    _this.divEmpresa = true;
                    _this.validateCedula = true;
                    _this.claseSpanCedula = "glyphicon glyphicon-ok form-control-feedback";
                    _this.calseCedula = "form-group has-success has-feedback ";
                    _this.msgCiudadano = response.msj;
                    _this.ciudadano = new Ciudadano_1.Ciudadano(null, "", null, "", "", "", "", "");
                }
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.VehiculoCiudadano = function () {
        var _this = this;
        this.ciudadanoVehiculo.ciudadanoId = this.ciudadano.numeroIdentificacion;
        this.ciudadanoVehiculo.estadoPropiedad = "1";
        this.ciudadanoVehiculo.empresaId = this.empresa.nit;
        this.ciudadanoVehiculo.vehiculoId = this.vehiculo.placa;
        this.ciudadanoVehiculo.fechaPropiedadInicial = this.vehiculo.fechaFactura;
        if (this.ciudadanosVehiculo != null) {
            this.ciudadanoVehiculo.licenciaTransito = this.ciudadanosVehiculo[0].licenciaTransito;
        }
        var token = this._loginService.getToken();
        this._CiudadanoVehiculoService.register(this.ciudadanoVehiculo, token, this.TipoMatricula, this.json, this.TipoTramite).subscribe(function (response) {
            _this.respuesta = response;
            if (_this.respuesta.status == 'success') {
                _this.ciudadanoVehiculo.licenciaTransito = "";
                _this.validateCedula = false;
                _this.json = null;
                _this.TipoTramite = null;
                _this.onKey("");
            }
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    IndexSubirCarpetaComponent.prototype.onChangeTramiteGeneral = function (id) {
        var _this = this;
        this.tramiteGeneralSeleccionado = id;
        this.tramiteEspesificolSeleccionado = id;
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.showTramiteEspecificoGeneral(token, id).subscribe(function (response) {
            _this.tramiteEspecificos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSubirCarpetaComponent.prototype.onChangeApoderado = function (event) {
        if (event == true) {
            this.btnSeleccionarApoderado = true;
        }
        else {
            this.btnSeleccionarApoderado = false;
        }
    };
    IndexSubirCarpetaComponent.prototype.onChangeCiudadano = function (id) {
        this.divTramiteGeneral = false;
        this.idCiudadanoSeleccionado = id;
        this.idEmpresaSeleccionada = null;
    };
    IndexSubirCarpetaComponent.prototype.onChangeEmpresa = function (id) {
        this.divTramiteGeneral = false;
        this.idEmpresaSeleccionada = id;
        this.idCiudadanoSeleccionado = null;
    };
    IndexSubirCarpetaComponent.prototype.onChangeNit = function (Value) {
        if (Value == 4) {
            this.nit = true;
            this.validateCedula = false;
        }
        else {
            this.nit = false;
            this.validateCedula = false;
        }
    };
    IndexSubirCarpetaComponent.prototype.onChangeTipoMatricula = function (event) {
        this.TipoMatricula = event;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarVinculo = function () {
        this.validateCedula = false;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarModalCedula = function () {
        this.modalCiudadano = false;
        this.btnNewPropietario = false;
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarModalEmpresa = function () {
        this.modalEmpresa = false;
        this.btnNewPropietario = false;
    };
    IndexSubirCarpetaComponent.prototype.btnNuevoTramiteGeneral = function () {
        if (this.idCiudadanoSeleccionado != null || this.idEmpresaSeleccionada != null) {
            this.divTramiteGeneral = true;
        }
    };
    IndexSubirCarpetaComponent.prototype.btnCancelarNuevoTramiteGeneral = function () {
        this.divTramiteGeneral = false;
    };
    IndexSubirCarpetaComponent.prototype.btnNuevoTramiteEspesifico = function () {
        this.divTramite = true;
    };
    IndexSubirCarpetaComponent.prototype.prueba = function (event) {
        if (event == "2") {
            this.json.datosGenerales = "Con opcion de compra";
        }
        else {
            this.json.datosGenerales = event;
        }
    };
    IndexSubirCarpetaComponent.prototype.vheiculoCreado = function (event) {
        this.placa.placa = event;
        this.onKey("");
    };
    IndexSubirCarpetaComponent.prototype.tramiteGeneralCreado = function (tramiteGeneral) {
        if (tramiteGeneral) {
            this.divTramiteGeneral = false;
            this.idCiudadanoSeleccionado = null;
            this.idEmpresaSeleccionada = null;
            this.tramiteGeneralSeccion = null;
            this.onKey("");
        }
    };
    IndexSubirCarpetaComponent.prototype.ciudadanoCreado = function (event) {
        this.onKeyCiudadano(event);
    };
    IndexSubirCarpetaComponent.prototype.empresaCreada = function (event) {
        this.onKeyEmpresa(event);
    };
    IndexSubirCarpetaComponent.prototype.tramiteCreado = function (isCreado) {
        if (isCreado) {
            this.onKey("");
        }
    };
    IndexSubirCarpetaComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/subirCarpeta/index.component.html',
            directives: [router_1.ROUTER_DIRECTIVES,
                new_vehiculo_component_1.NewVehiculoComponent,
                new_ciudadano_component_1.NewCiudadanoComponent,
                new_empresa_component_1.NewEmpresaComponent,
                new_tramiteGeneral_component_1.NewTramiteGeneralComponent,
                index_cambioColor_component_1.NewTramiteCambioColorComponent,
                index_TrasladoCuenta_component_1.NewTramiteTrasladoCuentaComponent],
            providers: [login_service_1.LoginService,
                tramite_service_1.TramiteService,
                tramiteEspecifico_service_1.TramiteEspecificoService,
                tramiteGeneral_service_1.TramiteGeneralService,
                vehiculo_service_1.VehiculoService,
                ciudadanoVehiculo_service_1.CiudadanoVehiculoService,
                ciudadano_service_1.CiudadanoService,
                tipoIdentificacion_service_1.TipoIdentificacionService,
                empresa_service_1.EmpresaService,
                organismoTransito_service_1.OrganismoTransitoService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, organismoTransito_service_1.OrganismoTransitoService, tramiteEspecifico_service_1.TramiteEspecificoService, tramiteGeneral_service_1.TramiteGeneralService, empresa_service_1.EmpresaService, tipoIdentificacion_service_1.TipoIdentificacionService, vehiculo_service_1.VehiculoService, ciudadano_service_1.CiudadanoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexSubirCarpetaComponent);
    return IndexSubirCarpetaComponent;
}());
exports.IndexSubirCarpetaComponent = IndexSubirCarpetaComponent;
//# sourceMappingURL=index.subirCarpeta.component.js.map