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
var login_service_1 = require("../../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var vehiculo_1 = require("../../../model/vehiculo/vehiculo");
var tramiteEspecifico_service_1 = require("../../../services/tramiteEspecifico/tramiteEspecifico.service");
var TramiteEspecifico_1 = require('../../../model/tramiteEspecifico/TramiteEspecifico');
var vehiculo_service_1 = require("../../../services/vehiculo/vehiculo.service");
var variante_service_1 = require("../../../services/variante/variante.service");
var caso_service_1 = require("../../../services/caso/caso.service");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewTramiteRegrabarMotorComponent = (function () {
    function NewTramiteRegrabarMotorComponent(_TramiteEspecificoService, _VarianteService, _CasoService, _VehiculoService, _loginService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._VarianteService = _VarianteService;
        this._CasoService = _CasoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
        this.servicioSeleccionado = null;
        this.varianteTramite = null;
        this.casoTramite = null;
        this.tramiteGeneralId = 22;
        this.vehiculo = null;
        this.tramiteCreado = new core_1.EventEmitter();
        this.datos = {
            'newMotor': null,
            'oldMotor': null
        };
    }
    NewTramiteRegrabarMotorComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 7, this.tramiteGeneralId, null, null, null);
        var token = this._loginService.getToken();
        this._CasoService.showCasosTramite(token, 7).subscribe(function (response) {
            _this.casos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._VarianteService.showVariantesTramite(token, 7).subscribe(function (response) {
            _this.variantes = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this.datos.oldMotor = this.vehiculo.motor;
    };
    NewTramiteRegrabarMotorComponent.prototype.enviarTramite = function () {
        var _this = this;
        this.datos.newMotor = this.Motor;
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.register2(this.tramiteEspecifico, token, this.datos).subscribe(function (response) {
            _this.respuesta = response;
            if (_this.respuesta.status == "success") {
                _this.tramiteCreado.emit(true);
            }
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
        this.vehiculo2 = new vehiculo_1.Vehiculo(this.vehiculo.id, this.vehiculo.clase.id, this.vehiculo.municipio.id, this.vehiculo.linea.id, this.vehiculo.servicio.id, this.vehiculo.color.id, this.vehiculo.combustible.id, this.vehiculo.carroceria.id, this.vehiculo.organismoTransito.id, this.vehiculo.placa, this.vehiculo.numeroFactura, this.vehiculo.fechaFactura, this.vehiculo.valor, this.vehiculo.numeroManifiesto, this.vehiculo.fechaManifiesto, this.vehiculo.cilindraje, this.vehiculo.modelo, this.Motor, this.vehiculo.chasis, this.vehiculo.serie, this.vehiculo.vin, this.vehiculo.numeroPasajeros, this.vehiculo.pignorado, this.vehiculo.cancelado);
        this._VehiculoService.editVehiculo(this.vehiculo2, token).subscribe(function (response) {
            _this.respuesta = response;
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    NewTramiteRegrabarMotorComponent.prototype.onChangeCaso = function (event) {
        this.tramiteEspecifico.casoId = event;
    };
    NewTramiteRegrabarMotorComponent.prototype.onChangeVariante = function (event) {
        this.tramiteEspecifico.varianteId = event;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteRegrabarMotorComponent.prototype, "tramiteGeneralId", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], NewTramiteRegrabarMotorComponent.prototype, "vehiculo", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', Object)
    ], NewTramiteRegrabarMotorComponent.prototype, "tramiteCreado", void 0);
    NewTramiteRegrabarMotorComponent = __decorate([
        core_1.Component({
            selector: 'tramiteRegrabarMotor',
            templateUrl: 'app/view/tipoTramite/regrabarMotor/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, tramiteEspecifico_service_1.TramiteEspecificoService, vehiculo_service_1.VehiculoService, variante_service_1.VarianteService, caso_service_1.CasoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, variante_service_1.VarianteService, caso_service_1.CasoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewTramiteRegrabarMotorComponent);
    return NewTramiteRegrabarMotorComponent;
}());
exports.NewTramiteRegrabarMotorComponent = NewTramiteRegrabarMotorComponent;
//# sourceMappingURL=index.regrabarMotor.component.js.map