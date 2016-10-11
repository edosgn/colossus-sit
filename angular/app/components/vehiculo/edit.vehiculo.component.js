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
var municipio_service_1 = require('../../services/municipio/municipio.service');
var linea_service_1 = require('../../services/linea/linea.service');
var servicio_service_1 = require('../../services/servicio/servicio.service');
var color_service_1 = require('../../services/color/color.service');
var clase_service_1 = require('../../services/clase/clase.service');
var combustible_service_1 = require('../../services/combustible/combustible.service');
var carroceria_service_1 = require('../../services/carroceria/carroceria.service');
var organismoTransito_service_1 = require('../../services/organismoTransito/organismoTransito.service');
var vehiculo_service_1 = require("../../services/vehiculo/vehiculo.service");
var Vehiculo_1 = require('../../model/vehiculo/Vehiculo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var VehiculoEditComponent = (function () {
    function VehiculoEditComponent(_MunicipioService, _LineaService, _ServicioService, _ColorService, _ClaseService, _CombustibleService, _CarroceriaService, _OrganismoTransitoService, _VehiculoService, _loginService, _route, _router) {
        this._MunicipioService = _MunicipioService;
        this._LineaService = _LineaService;
        this._ServicioService = _ServicioService;
        this._ColorService = _ColorService;
        this._ClaseService = _ClaseService;
        this._CombustibleService = _CombustibleService;
        this._CarroceriaService = _CarroceriaService;
        this._OrganismoTransitoService = _OrganismoTransitoService;
        this._VehiculoService = _VehiculoService;
        this._loginService = _loginService;
        this._route = _route;
        this._router = _router;
    }
    VehiculoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculo = new Vehiculo_1.Vehiculo(null, null, null, null, null, null, null, null, null, "", "", "", "", "", "", "", "", "", "", "", null, null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._VehiculoService.showVehiculo(token, this.id).subscribe(function (response) {
            var data = response.data;
            console.log(data);
            _this.vehiculo = new Vehiculo_1.Vehiculo(data.id, data.clase.id, data.municipio.id, data.linea.id, data.servicio.id, data.color.id, data.combustible.id, data.carroceria.id, data.organismoTransito.id, data.placa, data.numeroFactura, data.fechaFactura, data.valor, data.numeroManifiesto, data.fechaManifiesto, data.cilindraje, data.modelo, data.motor, data.chasis, data.serie, data.vin, data.numeroPasajeros);
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._MunicipioService.getMunicipio().subscribe(function (response) {
            _this.municipios = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._LineaService.getLinea().subscribe(function (response) {
            _this.lineas = response.data;
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
        this._ColorService.getColor().subscribe(function (response) {
            _this.colores = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._CombustibleService.getCombustible().subscribe(function (response) {
            _this.combustibles = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._CarroceriaService.getCarroceria().subscribe(function (response) {
            _this.carrocerias = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._OrganismoTransitoService.getOrganismoTransito().subscribe(function (response) {
            _this.organismosTransito = response.data;
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
    };
    VehiculoEditComponent.prototype.onSubmit = function () {
        var _this = this;
        var token = this._loginService.getToken();
        this._VehiculoService.editVehiculo(this.vehiculo, token).subscribe(function (response) {
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
    VehiculoEditComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/view/vehiculo/edit.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, municipio_service_1.MunicipioService, linea_service_1.LineaService, servicio_service_1.ServicioService, color_service_1.ColorService, combustible_service_1.CombustibleService, carroceria_service_1.CarroceriaService, organismoTransito_service_1.OrganismoTransitoService, clase_service_1.ClaseService]
        }), 
        __metadata('design:paramtypes', [municipio_service_1.MunicipioService, linea_service_1.LineaService, servicio_service_1.ServicioService, color_service_1.ColorService, clase_service_1.ClaseService, combustible_service_1.CombustibleService, carroceria_service_1.CarroceriaService, organismoTransito_service_1.OrganismoTransitoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], VehiculoEditComponent);
    return VehiculoEditComponent;
}());
exports.VehiculoEditComponent = VehiculoEditComponent;
//# sourceMappingURL=edit.vehiculo.component.js.map