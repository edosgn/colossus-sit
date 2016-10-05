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

];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
]; 