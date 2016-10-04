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


];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
]; 