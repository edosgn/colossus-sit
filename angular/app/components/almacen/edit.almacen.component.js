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
var almacen_service_1 = require("../../services/almacen/almacen.service");
var servicio_service_1 = require("../../services/servicio/servicio.service");
var organismoTransito_service_1 = require('../../services/organismoTransito/organismoTransito.service');
var consumible_service_1 = require("../../services/consumible/consumible.service");
var clase_service_1 = require("../../services/clase/clase.service");
var Almacen_1 = require('../../model/almacen/Almacen');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var AlmacenEditComponent = (function () {
    function AlmacenEditComponent(_ClaseService, _ConsumibleService, _AlmacenService, _OrganismoTransitoService, _loginService, _ServicioService, _route, _router) {
        this._ClaseService = _ClaseService;
        this._ConsumibleService = _ConsumibleService;
        this._AlmacenService = _AlmacenService;
        this._OrganismoTransitoService = _OrganismoTransitoService;
        this._loginService = _loginService;
        this._ServicioService = _ServicioService;
        this._route = _route;
        this._router = _router;
    }
    AlmacenEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.almacen = new Almacen_1.Almacen(null, null, null, null, null, null, null, null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._AlmacenService.showAlmacen(token, this.id).subscribe(function (response) {
            var data = response.data;
            console.log(data);
            _this.almacen = new Almacen_1.Almacen(data.id, data.servicio.id, data.organismoTransito.id, data.consumible.id, data.clase.id, data.rangoInicio, data.rangoFin, data.lote);
            console.log(_this.almacen);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._OrganismoTransitoService.getOrganismoTransito().subscribe(function (response) {
            _this.organismosTransporte = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._ClaseService.getClase().subscribe(function (response) {
            _this.clases = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._ConsumibleService.getConsumible().subscribe(function (response) {
            _this.consumibles = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._AlmacenService.getAlmacen().subscribe(function (response) {
            _this.tiposAlmacen = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._ServicioService.getServicio().subscribe(function (response) {
            _this.servicios = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    AlmacenEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._AlmacenService.editAlmacen(this.almacen, token).subscribe(function (response) {
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
    AlmacenEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/almacen/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, servicio_service_1.ServicioService, almacen_service_1.AlmacenService, organismoTransito_service_1.OrganismoTransitoService, almacen_service_1.AlmacenService, consumible_service_1.ConsumibleService, clase_service_1.ClaseService]
        }), 
        __metadata('design:paramtypes', [clase_service_1.ClaseService, consumible_service_1.ConsumibleService, almacen_service_1.AlmacenService, organismoTransito_service_1.OrganismoTransitoService, login_service_1.LoginService, servicio_service_1.ServicioService, router_1.ActivatedRoute, router_1.Router])
    ], AlmacenEditComponent);
    return AlmacenEditComponent;
}());
exports.AlmacenEditComponent = AlmacenEditComponent;
//# sourceMappingURL=edit.almacen.component.js.map