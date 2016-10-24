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
var color_service_1 = require("../../../services/color/color.service");
var tramiteEspecifico_service_1 = require("../../../services/tramiteEspecifico/tramiteEspecifico.service");
var TramiteEspecifico_1 = require('../../../model/tramiteEspecifico/TramiteEspecifico');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexCambioColorComponent = (function () {
    function IndexCambioColorComponent(_TramiteEspecificoService, _loginService, _ColorService, _route, _router) {
        this._TramiteEspecificoService = _TramiteEspecificoService;
        this._loginService = _loginService;
        this._ColorService = _ColorService;
        this._route = _route;
        this._router = _router;
        this.tramiteGeneralId = 22;
        this.vehiculo = null;
        this.datos = {
            'nuevo': null,
            'viejo': null
        };
    }
    IndexCambioColorComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.tramiteEspecifico = new TramiteEspecifico_1.TramiteEspecifico(null, 5, this.tramiteGeneralId, null, null, null);
        this._ColorService.getColor().subscribe(function (response) {
            _this.colores = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this.datos.viejo = this.vehiculo.color.nombre;
    };
    IndexCambioColorComponent.prototype.onChangeColor = function (event) {
        this.datos.nuevo = event;
        console.log(this.datos);
        console.log(this.tramiteEspecifico);
    };
    IndexCambioColorComponent.prototype.enviarTramite = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._TramiteEspecificoService.register(this.tramiteEspecifico, token).subscribe(function (response) {
            _this.respuesta = response;
            console.log(_this.respuesta);
            (function (error) {
                _this.errorMessage = error;
                if (_this.errorMessage != null) {
                    console.log(_this.errorMessage);
                    alert("Error en la petición");
                }
            });
        });
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Object)
    ], IndexCambioColorComponent.prototype, "vehiculo", void 0);
    IndexCambioColorComponent = __decorate([
        core_1.Component({
            selector: 'color',
            templateUrl: 'app/view/tipoTramite/cambioColor/index.component.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, color_service_1.ColorService, tramiteEspecifico_service_1.TramiteEspecificoService]
        }), 
        __metadata('design:paramtypes', [tramiteEspecifico_service_1.TramiteEspecificoService, login_service_1.LoginService, color_service_1.ColorService, router_1.ActivatedRoute, router_1.Router])
    ], IndexCambioColorComponent);
    return IndexCambioColorComponent;
}());
exports.IndexCambioColorComponent = IndexCambioColorComponent;
//# sourceMappingURL=index.cambioColor.component.js.map