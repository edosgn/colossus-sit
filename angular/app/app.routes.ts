import { provideRouter, RouterConfig } from '@angular/router';
import { LoginComponent } from "./components/login.component";
import { DefaulComponent } from "./components/defaul.component";
import { UsuarioEditComponent } from "./components/usuario.edit.component";
import { RegisterComponent } from "./components/register.component";

import { IndexDepartamentoComponent } from "./components/departamento/index.departamento.component";
import { NewDepartamentoComponent } from "./components/departamento/new.departamento.component";
import { DepartamentoEditComponent } from "./components/departamento/edit.departamento.component";

import { IndexMunicipioComponent } from "./components/municipio/index.municipio.component";
import { NewMunicipioComponent } from "./components/municipio/new.municipio.component";
import { MunicipioEditComponent } from "./components/municipio/edit.municipio.component";

import { IndexBancoComponent } from "./components/banco/index.banco.component";
import { NewBancoComponent } from "./components/banco/new.banco.component";
import { BancoEditComponent } from "./components/banco/edit.banco.component";

import { IndexColorComponent } from "./components/color/index.color.component";
import { NewColorComponent } from "./components/color/new.color.component";
import { ColorEditComponent } from "./components/color/edit.color.component";

import { IndexClaseComponent } from "./components/clase/index.clase.component";
import { ClaseEditComponent } from "./components/clase/edit.clase.component";
import { NewClaseComponent } from "./components/clase/new.clase.component";

import { IndexCombustibleComponent } from "./components/combustible/index.combustible.component";
import { NewCombustibleComponent } from "./components/combustible/new.combustible.component";
import { CombustibleEditComponent } from "./components/combustible/edit.combustible.component";

import { IndexLineaComponent } from "./components/linea/index.linea.component";
import { NewLineaComponent } from "./components/linea/new.linea.component";
import { LineaEditComponent } from "./components/linea/edit.linea.component";

import { IndexMarcaComponent } from "./components/marca/index.marca.component";
import { NewMarcaComponent } from "./components/marca/new.marca.component";
import { MarcaEditComponent } from "./components/marca/edit.marca.component";

import { IndexModalidadComponent } from "./components/modalidad/index.modalidad.component";
import { NewModalidadComponent } from "./components/modalidad/new.modalidad.component";
import { ModalidadEditComponent } from "./components/modalidad/edit.modalidad.component";

import { IndexConsumibleComponent } from "./components/consumible/index.consumible.component";
import { NewConsumibleComponent } from "./components/consumible/new.consumible.component";
import { ConsumibleEditComponent } from "./components/consumible/edit.consumible.component";

import { IndexCuentaComponent } from "./components/cuenta/index.cuenta.components";
import { NewCuentaComponent } from "./components/cuenta/new.cuenta.component";
import { CuentaEditComponent } from "./components/cuenta/edit.cuenta.component";

import { IndexModuloComponent } from "./components/modulo/index.modulo.component";
import { NewModuloComponent } from "./components/modulo/new.modulo.component";
import { ModuloEditComponent } from "./components/modulo/edit.modulo.component";

import { IndexTipoIdentificacionComponent } from "./components/tipo_identificacion/index.tipoidentificacion.component";
import { NewTipoIdentificacionComponent } from "./components/tipo_identificacion/new.tipoidentificacion.component";
import { TipoIdentificacionEditComponent } from "./components/tipo_identificacion/edit.tipoidentificacion.component";

import { IndexCiudadanoComponent } from "./components/ciudadano/index.ciudadano.component";
import { NewCiudadanoComponent } from "./components/ciudadano/new.ciudadano.component";
import { CiudadanoEditComponent } from "./components/ciudadano/edit.ciudadano.component";

import { IndexTipoEmpresaComponent } from "./components/tipo_Empresa/index.tipoEmpresa.component";
import { NewTipoEmpresaComponent } from "./components/tipo_Empresa/new.tipoEmpresa.component";
import { TipoEmpresaEditComponent } from "./components/tipo_Empresa/edit.tipoEmpresa.component";

import { IndexEmpresaComponent } from "./components/empresa/index.empresa.component";
import { NewEmpresaComponent } from "./components/empresa/new.empresa.component";
import { EmpresaEditComponent } from "./components/empresa/edit.empresa.component";

import { IndexServicioComponent } from "./components/servicio/index.servicio.component";
import { NewServicioComponent } from "./components/servicio/new.servicio.component";
import { ServicioEditComponent } from "./components/servicio/edit.servicio.component";

import { IndexCarroceriaComponent } from "./components/carroceria/index.carroceria.component";
import { NewCarroceriaComponent } from "./components/carroceria/new.carroceria.component";
import { CarroceriaEditComponent } from "./components/carroceria/edit.carroceria.component";

import { IndexTramiteComponent } from "./components/tramite/index.tramite.component";
import { NewTramiteComponent } from "./components/tramite/new.tramite.component";
import { TramiteEditComponent } from "./components/tramite/edit.tramite.component";

import { IndexPagoComponent } from "./components/pago/index.pago.component";
import { NewPagoComponent } from "./components/pago/new.pago.component";
import { PagoEditComponent } from "./components/pago/edit.pago.component";

import { IndexOrganismoTransitoComponent } from "./components/organismoTransito/index.organismoTransito.component";
import { NewOrganismoTransitoComponent } from "./components/organismoTransito/new.organismoTransito.component";
import { OrganismoTransitoEditComponent } from "./components/organismoTransito/edit.organismoTransito.component";

import { IndexConceptoComponent } from "./components/concepto/index.concepto.component";
import { NewConceptoComponent } from "./components/concepto/new.concepto.component";
import { ConceptoEditComponent } from "./components/concepto/edit.concepto.component";

import { IndexVarianteComponent } from "./components/variante/index.variante.components";
import { NewVarianteComponent } from "./components/variante/new.variante.component";
import { VarianteEditComponent } from "./components/variante/edit.variante.component";

import { IndexCasoComponent } from "./components/caso/index.caso.component";
import { NewCasoComponent } from "./components/caso/new.caso.component";
import { CasoEditComponent } from "./components/caso/edit.caso.component";

import { IndexAlmacenComponent } from "./components/almacen/index.almacen.component";
import { NewAlmacenComponent } from "./components/almacen/new.almacen.component";
import { AlmacenEditComponent } from "./components/almacen/edit.almacen.component";

import { IndexVehiculoComponent } from "./components/vehiculo/index.vehiculo.component";
import { NewVehiculoComponent } from "./components/vehiculo/new.vehiculo.component";
import { VehiculoEditComponent } from "./components/vehiculo/edit.vehiculo.component";





export const routes: RouterConfig = [
    {
    	path:'',
    	redirectTo: '/login',
    	terminal: true

    },
	{ path: 'index', component: DefaulComponent},
	{ path: 'login', component: LoginComponent},
	{ path: 'login/:id', component: LoginComponent},
	{ path: 'registrar', component: RegisterComponent},
    { path: 'usuario-edit/:id', component: UsuarioEditComponent},

    { path: 'departamento/index', component: IndexDepartamentoComponent},
    { path: 'departamento/new', component: NewDepartamentoComponent},
    { path: 'departamento/show/:id', component: DepartamentoEditComponent},

    { path: 'municipio/index', component: IndexMunicipioComponent},
    { path: 'municipio/new', component: NewMunicipioComponent},
    { path: 'municipio/show/:id', component: MunicipioEditComponent},

    { path: 'banco/index', component: IndexBancoComponent},
    { path: 'banco/new', component: NewBancoComponent},
    { path: 'banco/show/:id', component: BancoEditComponent},

    { path: 'color/index', component: IndexColorComponent},
    { path: 'color/new', component: NewColorComponent},
    { path: 'color/show/:id', component: ColorEditComponent},

    { path: 'clase/index', component: IndexClaseComponent},
    { path: 'clase/new', component: NewClaseComponent},
    { path: 'clase/show/:id', component: ClaseEditComponent},

    { path: 'combustible/index', component: IndexCombustibleComponent},
    { path: 'combustible/new', component: NewCombustibleComponent},
    { path: 'combustible/show/:id', component: CombustibleEditComponent},

    { path: 'linea/index', component: IndexLineaComponent},
    { path: 'linea/new', component: NewLineaComponent},
    { path: 'linea/show/:id', component: LineaEditComponent},

    { path: 'marca/index', component: IndexMarcaComponent},
    { path: 'marca/new', component: NewMarcaComponent},
    { path: 'marca/show/:id', component: MarcaEditComponent},

    { path: 'modalidad/index', component: IndexModalidadComponent},
    { path: 'modalidad/new', component: NewModalidadComponent},
    { path: 'modalidad/show/:id', component: ModalidadEditComponent},

    { path: 'consumible/index', component: IndexConsumibleComponent},
    { path: 'consumible/new', component: NewConsumibleComponent},
    { path: 'Consumible/show/:id', component: ConsumibleEditComponent},

    { path: 'cuenta/index', component: IndexCuentaComponent},
    { path: 'cuenta/new', component: NewCuentaComponent},
    { path: 'cuenta/show/:id', component: CuentaEditComponent},

    { path: 'modulo/index', component: IndexModuloComponent},
    { path: 'modulo/new', component: NewModuloComponent},
    { path: 'modulo/show/:id', component: ModuloEditComponent},

    { path: 'tipoIdentificacion/index', component: IndexTipoIdentificacionComponent},
    { path: 'tipoIdentificacion/new', component: NewTipoIdentificacionComponent},
    { path: 'tipoIdentificacion/show/:id', component: TipoIdentificacionEditComponent},

    { path: 'ciudadano/index', component: IndexCiudadanoComponent},
    { path: 'ciudadano/new', component: NewCiudadanoComponent},
    { path: 'ciudadano/show/:id', component: CiudadanoEditComponent},

    { path: 'tipoEmpresa/index', component: IndexTipoEmpresaComponent},
    { path: 'tipoEmpresa/new', component: NewTipoEmpresaComponent},
    { path: 'tipoEmpresa/show/:id', component: TipoEmpresaEditComponent},

    { path: 'empresa/index', component: IndexEmpresaComponent},
    { path: 'empresa/new', component: NewEmpresaComponent},
    { path: 'empresa/show/:id', component: EmpresaEditComponent},

    { path: 'servicio/index', component: IndexServicioComponent},
    { path: 'servicio/new', component: NewServicioComponent},
    { path: 'servicio/show/:id', component: ServicioEditComponent},

    { path: 'carroceria/index', component: IndexCarroceriaComponent},
    { path: 'carroceria/new', component: NewCarroceriaComponent},
    { path: 'carroceria/show/:id', component: CarroceriaEditComponent},

    { path: 'tramite/index', component: IndexTramiteComponent},
    { path: 'tramite/new', component: NewTramiteComponent},
    { path: 'tramite/show/:id', component: TramiteEditComponent},

    { path: 'pago/index', component: IndexPagoComponent},
    { path: 'pago/new', component: NewPagoComponent},
    { path: 'pago/show/:id', component: PagoEditComponent},

    { path: 'organismoTransito/index', component: IndexOrganismoTransitoComponent},
    { path: 'organismoTransito/new', component: NewOrganismoTransitoComponent},
    { path: 'organismoTransito/show/:id', component: OrganismoTransitoEditComponent},

    { path: 'concepto/index', component: IndexConceptoComponent},
    { path: 'concepto/new', component: NewConceptoComponent},
    { path: 'concepto/show/:id', component: ConceptoEditComponent},

    { path: 'variante/index', component: IndexVarianteComponent},
    { path: 'variante/new', component: NewVarianteComponent},
    { path: 'variante/show/:id', component: VarianteEditComponent},

    { path: 'caso/index', component: IndexCasoComponent},
    { path: 'caso/new', component: NewCasoComponent},
    { path: 'caso/show/:id', component: CasoEditComponent},

    { path: 'almacen/index', component: IndexAlmacenComponent},
    { path: 'almacen/new', component: NewAlmacenComponent},
    { path: 'almacen/show/:id', component: AlmacenEditComponent},

    { path: 'vehiculo/index', component: IndexVehiculoComponent},
    { path: 'vehiculo/new', component: NewVehiculoComponent},
    { path: 'vehiculo/show/:id', component: VehiculoEditComponent},
];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
]; 