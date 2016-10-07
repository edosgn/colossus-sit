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
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var login_service_1 = require('../../services/login.service');
var pago_service_1 = require('../../services/pago/pago.service');
var Pago_1 = require('../../model/pago/Pago');
var tramite_service_1 = require('../../services/tramite/tramite.service');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewPagoComponent = (function () {
    function NewPagoComponent(_TramiteService, _PagoService, _loginService, _route, _router) {
        this._TramiteService = _TramiteService;
        this._PagoService = _PagoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewPagoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.pago = new Pago_1.Pago(null, null, null, "", "");
        this._TramiteService.getTramite().subscribe(function (response) {
            _this.tramites = response.data;
            console.log(_this.tramites[0].nombre);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewPagoComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._PagoService.register(this.pago, token).subscribe(function (response) {
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
    NewPagoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/pago/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, pago_service_1.PagoService, tramite_service_1.TramiteService]
        }), 
        __metadata('design:paramtypes', [tramite_service_1.TramiteService, pago_service_1.PagoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewPagoComponent);
    return NewPagoComponent;
}());
exports.NewPagoComponent = NewPagoComponent;
//# sourceMappingURL=new.pago.component.js.map