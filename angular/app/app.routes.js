"use strict";
var router_1 = require('@angular/router');
var login_component_1 = require("./components/login.component");
var defaul_component_1 = require("./components/defaul.component");
var usuario_edit_component_1 = require("./components/usuario.edit.component");
var register_component_1 = require("./components/register.component");
var index_departamento_component_1 = require("./components/departamento/index.departamento.component");
var new_departamento_component_1 = require("./components/departamento/new.departamento.component");
var edit_departamento_component_1 = require("./components/departamento/edit.departamento.component");
var index_municipio_component_1 = require("./components/municipio/index.municipio.component");
var new_municipio_component_1 = require("./components/municipio/new.municipio.component");
var edit_municipio_component_1 = require("./components/municipio/edit.municipio.component");
var index_banco_component_1 = require("./components/banco/index.banco.component");
var new_banco_component_1 = require("./components/banco/new.banco.component");
var edit_banco_component_1 = require("./components/banco/edit.banco.component");
var index_color_component_1 = require("./components/color/index.color.component");
var new_color_component_1 = require("./components/color/new.color.component");
var edit_color_component_1 = require("./components/color/edit.color.component");
var index_clase_component_1 = require("./components/clase/index.clase.component");
var edit_clase_component_1 = require("./components/clase/edit.clase.component");
var new_clase_component_1 = require("./components/clase/new.clase.component");
var index_combustible_component_1 = require("./components/combustible/index.combustible.component");
var new_combustible_component_1 = require("./components/combustible/new.combustible.component");
var edit_combustible_component_1 = require("./components/combustible/edit.combustible.component");
var index_linea_component_1 = require("./components/linea/index.linea.component");
var new_linea_component_1 = require("./components/linea/new.linea.component");
var edit_linea_component_1 = require("./components/linea/edit.linea.component");
var index_marca_component_1 = require("./components/marca/index.marca.component");
var new_marca_component_1 = require("./components/marca/new.marca.component");
var edit_marca_component_1 = require("./components/marca/edit.marca.component");
var index_modalidad_component_1 = require("./components/modalidad/index.modalidad.component");
var new_modalidad_component_1 = require("./components/modalidad/new.modalidad.component");
var edit_modalidad_component_1 = require("./components/modalidad/edit.modalidad.component");
var index_consumible_component_1 = require("./components/consumible/index.consumible.component");
var new_consumible_component_1 = require("./components/consumible/new.consumible.component");
var edit_consumible_component_1 = require("./components/consumible/edit.consumible.component");
var index_cuenta_components_1 = require("./components/cuenta/index.cuenta.components");
var new_cuenta_component_1 = require("./components/cuenta/new.cuenta.component");
var edit_cuenta_component_1 = require("./components/cuenta/edit.cuenta.component");
var index_modulo_component_1 = require("./components/modulo/index.modulo.component");
var new_modulo_component_1 = require("./components/modulo/new.modulo.component");
var edit_modulo_component_1 = require("./components/modulo/edit.modulo.component");
exports.routes = [
    {
        path: '',
        redirectTo: '/login',
        terminal: true
    },
    { path: 'index', component: defaul_component_1.DefaulComponent },
    { path: 'login', component: login_component_1.LoginComponent },
    { path: 'login/:id', component: login_component_1.LoginComponent },
    { path: 'registrar', component: register_component_1.RegisterComponent },
    { path: 'usuario-edit/:id', component: usuario_edit_component_1.UsuarioEditComponent },
    { path: 'departamento/index', component: index_departamento_component_1.IndexDepartamentoComponent },
    { path: 'departamento/new', component: new_departamento_component_1.NewDepartamentoComponent },
    { path: 'departamento/show/:id', component: edit_departamento_component_1.DepartamentoEditComponent },
    { path: 'municipio/index', component: index_municipio_component_1.IndexMunicipioComponent },
    { path: 'municipio/new', component: new_municipio_component_1.NewMunicipioComponent },
    { path: 'municipio/show/:id', component: edit_municipio_component_1.MunicipioEditComponent },
    { path: 'banco/index', component: index_banco_component_1.IndexBancoComponent },
    { path: 'banco/new', component: new_banco_component_1.NewBancoComponent },
    { path: 'banco/show/:id', component: edit_banco_component_1.BancoEditComponent },
    { path: 'color/index', component: index_color_component_1.IndexColorComponent },
    { path: 'color/new', component: new_color_component_1.NewColorComponent },
    { path: 'color/show/:id', component: edit_color_component_1.ColorEditComponent },
    { path: 'clase/index', component: index_clase_component_1.IndexClaseComponent },
    { path: 'clase/new', component: new_clase_component_1.NewClaseComponent },
    { path: 'clase/show/:id', component: edit_clase_component_1.ClaseEditComponent },
    { path: 'combustible/index', component: index_combustible_component_1.IndexCombustibleComponent },
    { path: 'combustible/new', component: new_combustible_component_1.NewCombustibleComponent },
    { path: 'combustible/show/:id', component: edit_combustible_component_1.CombustibleEditComponent },
    { path: 'linea/index', component: index_linea_component_1.IndexLineaComponent },
    { path: 'linea/new', component: new_linea_component_1.NewLineaComponent },
    { path: 'linea/show/:id', component: edit_linea_component_1.LineaEditComponent },
    { path: 'marca/index', component: index_marca_component_1.IndexMarcaComponent },
    { path: 'marca/new', component: new_marca_component_1.NewMarcaComponent },
    { path: 'marca/show/:id', component: edit_marca_component_1.MarcaEditComponent },
    { path: 'modalidad/index', component: index_modalidad_component_1.IndexModalidadComponent },
    { path: 'modalidad/new', component: new_modalidad_component_1.NewModalidadComponent },
    { path: 'modalidad/show/:id', component: edit_modalidad_component_1.ModalidadEditComponent },
    { path: 'consumible/index', component: index_consumible_component_1.IndexConsumibleComponent },
    { path: 'consumible/new', component: new_consumible_component_1.NewConsumibleComponent },
    { path: 'Consumible/show/:id', component: edit_consumible_component_1.ConsumibleEditComponent },
    { path: 'cuenta/index', component: index_cuenta_components_1.IndexCuentaComponent },
    { path: 'cuenta/new', component: new_cuenta_component_1.NewCuentaComponent },
    { path: 'cuenta/show/:id', component: edit_cuenta_component_1.CuentaEditComponent },
    { path: 'modulo/index', component: index_modulo_component_1.IndexModuloComponent },
    { path: 'modulo/new', component: new_modulo_component_1.NewModuloComponent },
    { path: 'modulo/show/:id', component: edit_modulo_component_1.ModuloEditComponent },
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map