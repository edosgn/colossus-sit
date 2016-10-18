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
var departamento_service_1 = require("../../services/departamento/departamento.service");
var marca_service_1 = require("../../services/marca/marca.service");
var Vehiculo_1 = require('../../model/vehiculo/Vehiculo');
// Decorador component, indicamos en que etiqueta se va a cargar la 
var VehiculoEditComponent = (function () {
    function VehiculoEditComponent(_MunicipioService, _DepartamentoService, _MarcaService, _LineaService, _ServicioService, _ColorService, _ClaseService, _CombustibleService, _CarroceriaService, _OrganismoTransitoService, _VehiculoService, _loginService, _route, _router) {
        this._MunicipioService = _MunicipioService;
        this._DepartamentoService = _DepartamentoService;
        this._MarcaService = _MarcaService;
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
    VehiculoEditComponent.prototype.onChange = function (departamentoValue) {
        var _this = this;
        this.departamento = {
            "departamentoId": departamentoValue,
        };
        var token = this._loginService.getToken();
        this._MunicipioService.getMunicipiosDep(this.departamento, token).subscribe(function (response) {
            _this.municipios = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    VehiculoEditComponent.prototype.onChangeM = function (marcaValue) {
        var _this = this;
        this.marca = {
            "marcaId": marcaValue,
        };
        var token = this._loginService.getToken();
        this._LineaService.getLineasMar(this.marca, token).subscribe(function (response) {
            _this.lineas = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
    };
    VehiculoEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.vehiculo = new Vehiculo_1.Vehiculo(null, null, null, null, null, null, null, null, null, "", "", "", "", "", "", "", "", "", "", "", null, null);
        var token = this._loginService.getToken();
        this._route.params.subscribe(function (params) {
            _this.id = +params["id"];
        });
        this._VehiculoService.showVehiculo(token, this.id).subscribe(function (response) {
            _this.data = response.data;
            console.log(_this.data);
            _this.vehiculo = new Vehiculo_1.Vehiculo(_this.data.id, _this.data.clase.id, _this.data.municipio.id, _this.data.linea.id, _this.data.servicio.id, _this.data.color.id, _this.data.combustible.id, _this.data.carroceria.id, _this.data.organismoTransito.id, _this.data.placa, _this.data.numeroFactura, _this.data.fechaFactura, _this.data.valor, _this.data.numeroManifiesto, _this.data.fechaManifiesto, _this.data.cilindraje, _this.data.modelo, _this.data.motor, _this.data.chasis, _this.data.serie, _this.data.vin, _this.data.numeroPasajeros);
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
        this._LineaService.getLinea().subscribe(function (response) {
            _this.lineas = response.data;
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
        this._DepartamentoService.getDepartamento().subscribe(function (response) {
            _this.departamentos = response.data;
        }, function (error) {
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
                alert("Error en la petición");
            }
        });
        this._MarcaService.getMarca().subscribe(function (response) {
            _this.marcas = response.data;
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
            providers: [login_service_1.LoginService, vehiculo_service_1.VehiculoService, municipio_service_1.MunicipioService, linea_service_1.LineaService, servicio_service_1.ServicioService, color_service_1.ColorService, combustible_service_1.CombustibleService, carroceria_service_1.CarroceriaService, organismoTransito_service_1.OrganismoTransitoService, clase_service_1.ClaseService, departamento_service_1.DepartamentoService, marca_service_1.MarcaService]
        }), 
        __metadata('design:paramtypes', [municipio_service_1.MunicipioService, departamento_service_1.DepartamentoService, marca_service_1.MarcaService, linea_service_1.LineaService, servicio_service_1.ServicioService, color_service_1.ColorService, clase_service_1.ClaseService, combustible_service_1.CombustibleService, carroceria_service_1.CarroceriaService, organismoTransito_service_1.OrganismoTransitoService, vehiculo_service_1.VehiculoService, login_service_1.LoginService, router_1.ActivatedRoute, router_1.Router])
    ], VehiculoEditComponent);
    return VehiculoEditComponent;
}());
exports.VehiculoEditComponent = VehiculoEditComponent;
//# sourceMappingURL=edit.vehiculo.component.js.map