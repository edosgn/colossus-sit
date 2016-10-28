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
var modulo_service_1 = require("../../../services/modulo/modulo.service");
var ciudadanoVehiculo_service_1 = require("../../../services/ciudadanoVehiculo/ciudadanoVehiculo.service");
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var tramite_service_1 = require("../../../services/tramite/tramite.service");
var login_service_1 = require("../../../services/login.service");
var index_traspaso_component_1 = require("../../../components/tipoTramite/tramiteTraspaso/index.traspaso.component");
var index_prenda_component_1 = require("../../../components/tipoTramite/tramitePrenda/index.prenda.component");
var index_TrasladoCuenta_component_1 = require("../../../components/tipoTramite/tramiteTrasladoCuenta/index.TrasladoCuenta.component");
var index_cambioServicio_component_1 = require("../../../components/tipoTramite/tramiteCambioServicio/index.cambioServicio.component");
var index_regrabarMotor_component_1 = require("../../../components/tipoTramite/tramiteRegrabarMotor/index.regrabarMotor.component");
var index_cambioMotor_component_1 = require("../../../components/tipoTramite/tramiteCambioMotor/index.cambioMotor.component");
var index_regrabarChasis_component_1 = require("../../../components/tipoTramite/tramiteRegrabarChasis/index.regrabarChasis.component");
var index_regrabarSerie_component_1 = require("../../../components/tipoTramite/tramiteRegrabarSerie/index.regrabarSerie.component");
var index_cambioColor_component_1 = require("../../../components/tipoTramite/tramiteCambioColor/index.cambioColor.component");
var index_cambioCarroceria_component_1 = require("../../../components/tipoTramite/tramiteCambioCarroceria/index.cambioCarroceria.component");
var index_duplicadoLicencia_component_1 = require("../../../components/tipoTramite/tramiteDuplicadoLicencia/index.duplicadoLicencia.component");
var index_duplicadoPlaca_component_1 = require("../../../components/tipoTramite/tramiteDuplicadoPlaca/index.duplicadoPlaca.component");
var index_cambioBlindaje_component_1 = require("../../../components/tipoTramite/tramiteCambioBlindaje/index.cambioBlindaje.component");
var index_cambioCombustible_component_1 = require("../../../components/tipoTramite/tramiteCambioCombustible/index.cambioCombustible.component");
var index_levantarPrenda_component_1 = require("../../../components/tipoTramite/tramiteLevantarPrenda/index.levantarPrenda.component");
var index_cambioPrendario_component_1 = require("../../../components/tipoTramite/tramiteCambioPrendario/index.cambioPrendario.component");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var Vehiculo_1 = require('../../../model/vehiculo/Vehiculo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexTramiteCuerpoComponent = (function () {
    function IndexTramiteCuerpoComponent(_VehiculoService, _CiudadanoVehiculoService, _TramiteService, _ModuloService, _loginService, _route, _router) {
        this._VehiculoService = _VehiculoService;
        this._CiudadanoVehiculoService = _CiudadanoVehiculoService;
        this._TramiteService = _TramiteService;
        this._ModuloService = _ModuloService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.color = false;
    }
    IndexTramiteCuerpoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculo = new Vehiculo_1.Vehiculo(null, null, null, null, null, null, null, null, null, "", "", "", "", "", "", "", "", "", "", "", null, null, null, null);
        this._route.params.subscribe(function (params) {
            _this.tramiteId = +params["tramiteId"];
        });
        var token = this._loginService.getToken();
        this._TramiteService.showTramite(token, this.tramiteId).subscribe(function (response) {
            _this.tramite = response.data;
            console.log(_this.tramite);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexTramiteCuerpoComponent.prototype.onKey = function (event) {
        var _this = this;
        var token = this._loginService.getToken();
        var values = event.target.value;
        var placa = {
            'placa': values,
        };
        this._VehiculoService.showVehiculoPlaca(token, placa).subscribe(function (response) {
            _this.vehiculo = response.data;
            var status = response.status;
            if (status == 'error') {
                _this.validate = false;
                _this.validateCiudadano = false;
                _this.claseSpan = "glyphicon glyphicon-remove form-control-feedback";
                _this.clase = "form-group has-error has-feedback";
            }
            else {
                _this.validate = true;
                _this.claseSpan = "glyphicon glyphicon-ok form-control-feedback";
                _this.clase = "form-group has-success has-feedback";
                _this.msg = response.msj;
                _this._CiudadanoVehiculoService.showCiudadanoVehiculoId(token, _this.vehiculo.id).subscribe(function (response) {
                    _this.ciudadanosVehiculo = response.data;
                    _this.respuesta = response;
                    if (_this.respuesta.status == 'error') {
                        _this.activar = true;
                        _this.validateCiudadano = false;
                    }
                    else {
                        _this.activar = false;
                        _this.validateCiudadano = true;
                    }
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
    IndexTramiteCuerpoComponent.prototype.onChangeCiudadano = function (id) {
        this.idCiudadanoSeleccionado = id;
        this.divTramite = true;
    };
    IndexTramiteCuerpoComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/tipoTramite/cuerpoTramite/index.component.html',
            directives: [
                router_1.ROUTER_DIRECTIVES,
                index_traspaso_component_1.NewTramiteTraspasoComponent,
                index_cambioColor_component_1.NewTramiteCambioColorComponent,
                index_cambioServicio_component_1.NewTramiteCambioServicioComponent,
                index_regrabarMotor_component_1.NewTramiteRegrabarMotorComponent,
                index_regrabarChasis_component_1.NewTramiteRegrabarChasisComponent,
                index_regrabarSerie_component_1.NewTramiteRegrabarSerieComponent,
                index_duplicadoLicencia_component_1.NewTramiteDuplicadoLicenciaComponent,
                index_cambioBlindaje_component_1.NewTramiteCambioBlindajeComponent,
                index_cambioMotor_component_1.NewTramiteCambioMotorComponent,
                index_duplicadoPlaca_component_1.NewTramiteDuplicadoPlacaComponent,
                index_cambioCarroceria_component_1.NewTramiteCambioCarroceriaComponent,
                index_TrasladoCuenta_component_1.NewTramiteTrasladoCuentaComponent,
                index_cambioCombustible_component_1.NewTramiteCambioCombustibleComponent,
                index_prenda_component_1.NewTramitePrendaComponent,
                index_levantarPrenda_component_1.NewTramiteLevantarPrendaComponent,
                index_cambioPrendario_component_1.NewTramiteCambioPrendarioComponent
            ],
            providers: [login_service_1.LoginService, modulo_service_1.ModuloService, tramite_service_1.TramiteService, vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService]
        }), 
        __metadata('design:paramtypes', [vehiculo_service_1.VehiculoService, ciudadanoVehiculo_service_1.CiudadanoVehiculoService, tramite_service_1.TramiteService, modulo_service_1.ModuloService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexTramiteCuerpoComponent);
    return IndexTramiteCuerpoComponent;
}());
exports.IndexTramiteCuerpoComponent = IndexTramiteCuerpoComponent;
//# sourceMappingURL=index.tramiteCuerpo.component.js.map