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
var modulo_service_1 = require("../../services/modulo/modulo.service");
var tramite_service_1 = require("../../services/tramite/tramite.service");
var login_service_1 = require("../../services/login.service");
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
// Decorador component, indicamos en que etiqueta se va a cargar la 
var IndexSeleccionarTramiteComponent = (function () {
    function IndexSeleccionarTramiteComponent(_TramiteService, _ModuloService, _loginService, _route, _router) {
        this._TramiteService = _TramiteService;
        this._ModuloService = _ModuloService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    IndexSeleccionarTramiteComponent.prototype.ngOnInit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._ModuloService.getModulo().subscribe(function (response) {
            _this.modulos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSeleccionarTramiteComponent.prototype.onChangeModulo = function (moduloId) {
        var _this = this;
        var token = this._loginService.getToken();
        this._TramiteService.TramitesModulo(moduloId, token).subscribe(function (response) {
            _this.tramites = response.data;
            _this.respuesta = response;
            if (_this.respuesta.status == 'success') {
                _this.activar = false;
            }
            else {
                _this.activar = true;
            }
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    IndexSeleccionarTramiteComponent.prototype.onChangeTramite = function (tramiteId) {
        this._router.navigate(['/tramiteCuerpo', tramiteId]);
    };
    IndexSeleccionarTramiteComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/SeleccionarTramite/index.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, modulo_service_1.ModuloService, tramite_service_1.TramiteService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, modulo_service_1.ModuloService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], IndexSeleccionarTramiteComponent);
    return IndexSeleccionarTramiteComponent;
}());
exports.IndexSeleccionarTramiteComponent = IndexSeleccionarTramiteComponent;
//# sourceMappingURL=index.SeleccionarTramite.component.js.map