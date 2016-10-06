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
];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
]; 