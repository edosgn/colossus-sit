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
var index_tipoidentificacion_component_1 = require("./components/tipo_identificacion/index.tipoidentificacion.component");
var new_tipoidentificacion_component_1 = require("./components/tipo_identificacion/new.tipoidentificacion.component");
var edit_tipoidentificacion_component_1 = require("./components/tipo_identificacion/edit.tipoidentificacion.component");
var index_ciudadano_component_1 = require("./components/ciudadano/index.ciudadano.component");
var new_ciudadano_component_1 = require("./components/ciudadano/new.ciudadano.component");
var edit_ciudadano_component_1 = require("./components/ciudadano/edit.ciudadano.component");
var index_tipoEmpresa_component_1 = require("./components/tipo_Empresa/index.tipoEmpresa.component");
var new_tipoEmpresa_component_1 = require("./components/tipo_Empresa/new.tipoEmpresa.component");
var edit_tipoEmpresa_component_1 = require("./components/tipo_Empresa/edit.tipoEmpresa.component");
var index_empresa_component_1 = require("./components/empresa/index.empresa.component");
var new_empresa_component_1 = require("./components/empresa/new.empresa.component");
var edit_empresa_component_1 = require("./components/empresa/edit.empresa.component");
var index_servicio_component_1 = require("./components/servicio/index.servicio.component");
var new_servicio_component_1 = require("./components/servicio/new.servicio.component");
var edit_servicio_component_1 = require("./components/servicio/edit.servicio.component");
var index_carroceria_component_1 = require("./components/carroceria/index.carroceria.component");
var new_carroceria_component_1 = require("./components/carroceria/new.carroceria.component");
var edit_carroceria_component_1 = require("./components/carroceria/edit.carroceria.component");
var index_tramite_component_1 = require("./components/tramite/index.tramite.component");
var new_tramite_component_1 = require("./components/tramite/new.tramite.component");
var edit_tramite_component_1 = require("./components/tramite/edit.tramite.component");
var index_pago_component_1 = require("./components/pago/index.pago.component");
var new_pago_component_1 = require("./components/pago/new.pago.component");
var edit_pago_component_1 = require("./components/pago/edit.pago.component");
var index_organismoTransito_component_1 = require("./components/organismoTransito/index.organismoTransito.component");
var new_organismoTransito_component_1 = require("./components/organismoTransito/new.organismoTransito.component");
var edit_organismoTransito_component_1 = require("./components/organismoTransito/edit.organismoTransito.component");
var index_concepto_component_1 = require("./components/concepto/index.concepto.component");
var new_concepto_component_1 = require("./components/concepto/new.concepto.component");
var edit_concepto_component_1 = require("./components/concepto/edit.concepto.component");
var index_variante_components_1 = require("./components/variante/index.variante.components");
var new_variante_component_1 = require("./components/variante/new.variante.component");
var edit_variante_component_1 = require("./components/variante/edit.variante.component");
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
    { path: 'tipoIdentificacion/index', component: index_tipoidentificacion_component_1.IndexTipoIdentificacionComponent },
    { path: 'tipoIdentificacion/new', component: new_tipoidentificacion_component_1.NewTipoIdentificacionComponent },
    { path: 'tipoIdentificacion/show/:id', component: edit_tipoidentificacion_component_1.TipoIdentificacionEditComponent },
    { path: 'ciudadano/index', component: index_ciudadano_component_1.IndexCiudadanoComponent },
    { path: 'ciudadano/new', component: new_ciudadano_component_1.NewCiudadanoComponent },
    { path: 'ciudadano/show/:id', component: edit_ciudadano_component_1.CiudadanoEditComponent },
    { path: 'tipoEmpresa/index', component: index_tipoEmpresa_component_1.IndexTipoEmpresaComponent },
    { path: 'tipoEmpresa/new', component: new_tipoEmpresa_component_1.NewTipoEmpresaComponent },
    { path: 'tipoEmpresa/show/:id', component: edit_tipoEmpresa_component_1.TipoEmpresaEditComponent },
    { path: 'empresa/index', component: index_empresa_component_1.IndexEmpresaComponent },
    { path: 'empresa/new', component: new_empresa_component_1.NewEmpresaComponent },
    { path: 'empresa/show/:id', component: edit_empresa_component_1.EmpresaEditComponent },
    { path: 'servicio/index', component: index_servicio_component_1.IndexServicioComponent },
    { path: 'servicio/new', component: new_servicio_component_1.NewServicioComponent },
    { path: 'servicio/show/:id', component: edit_servicio_component_1.ServicioEditComponent },
    { path: 'carroceria/index', component: index_carroceria_component_1.IndexCarroceriaComponent },
    { path: 'carroceria/new', component: new_carroceria_component_1.NewCarroceriaComponent },
    { path: 'carroceria/show/:id', component: edit_carroceria_component_1.CarroceriaEditComponent },
    { path: 'tramite/index', component: index_tramite_component_1.IndexTramiteComponent },
    { path: 'tramite/new', component: new_tramite_component_1.NewTramiteComponent },
    { path: 'tramite/show/:id', component: edit_tramite_component_1.TramiteEditComponent },
    { path: 'pago/index', component: index_pago_component_1.IndexPagoComponent },
    { path: 'pago/new', component: new_pago_component_1.NewPagoComponent },
    { path: 'pago/show/:id', component: edit_pago_component_1.PagoEditComponent },
    { path: 'organismoTransito/index', component: index_organismoTransito_component_1.IndexOrganismoTransitoComponent },
    { path: 'organismoTransito/new', component: new_organismoTransito_component_1.NewOrganismoTransitoComponent },
    { path: 'organismoTransito/show/:id', component: edit_organismoTransito_component_1.OrganismoTransitoEditComponent },
    { path: 'concepto/index', component: index_concepto_component_1.IndexConceptoComponent },
    { path: 'concepto/new', component: new_concepto_component_1.NewConceptoComponent },
    { path: 'concepto/show/:id', component: edit_concepto_component_1.ConceptoEditComponent },
    { path: 'variante/index', component: index_variante_components_1.IndexVarianteComponent },
    { path: 'variante/new', component: new_variante_component_1.NewVarianteComponent },
    { path: 'variante/show/:id', component: edit_variante_component_1.VarianteEditComponent },
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map