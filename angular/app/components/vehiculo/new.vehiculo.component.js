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
var tipoIdentificacion_service_1 = require('../../services/tipo_Identificacion/tipoIdentificacion.service');
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var Vehiculo_1 = require('../../model/vehiculo/Vehiculo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var NewVehiculoComponent = (function () {
    function NewVehiculoComponent(_TipoIdentificacionService, _VehiculoService, _loginService, _route, _router) {
        this._TipoIdentificacionService = _TipoIdentificacionService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    NewVehiculoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculo = new Vehiculo_1.Vehiculo(null, "", null, "", "", "", "", "");
        var token = this._loginService.getToken();
        this._TipoIdentificacionService.getTipoIdentificacion().subscribe(function (response) {
            _this.tiposIdentificacion = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    NewVehiculoComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._VehiculoService.register(this.vehiculo, token).subscribe(function (response) {
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
    NewVehiculoComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/view/vehiculo/new.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, tipoIdentificacion_service_1.TipoIdentificacionService]
        }), 
        __metadata('design:paramtypes', [tipoIdentificacion_service_1.TipoIdentificacionService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], NewVehiculoComponent);
    return NewVehiculoComponent;
}());
exports.NewVehiculoComponent = NewVehiculoComponent;
//# sourceMappingURL=new.vehiculo.component.js.map